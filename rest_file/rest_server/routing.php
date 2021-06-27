<?php

namespace KB\rest_server;

use LogicException, InvalidArgumentException, BadMethodCallException;

use KB\rest_server\routing\base_route;
use KB\rest_server\routing\action_route;
use KB\rest_server\routing\controller_route;


/**
 * Collection of route rules
 *
 * CONFIG:
 * -------
 * routing.php
 *      [
 *          'cache' => [
 *              'connection' => string, - cache connection name
 *              'timeout' => int, - Caching timeout
 *              'key' => string, - cache key for storing routes
 *          ]
 *      ]
 */
class routing extends base_route {
	/**
	 * @var routing
	 */
	protected static $instance;

	/**
	 * @var controller_route[]
	 */
	protected static $controllers = [];

	/**
	 * Private constructor prevent to create instance
	 */
	protected function __construct() {
	}

	/**
	 * @param $value
	 *
	 * @throws BadMethodCallException
	 */
	public static function default_https_only($value) {
		if (!empty(self::$controllers)) {
			throw new BadMethodCallException('You cannot set this property after creating even one controller!');
		}

		self::instance()->set_https_only($value);
	}

	/**
	 * @param $content_types
	 *
	 * @throws BadMethodCallException
	 */
	public static function default_allowed_content_types($content_types) {
		if (!empty(self::$controllers)) {
			throw new BadMethodCallException('You cannot set this property after creating even one controller!');
		}

		if (!is_array($content_types)) {
			$content_types = func_get_args();
		}

		self::instance()->set_allowed_content_types($content_types);
	}

	/**
	 * @param string $name - controller full class name without "\controller\"
	 * @param string $uri_prefix
	 *
	 * @return controller_route
	 *
	 * @throws \InvalidArgumentException
	 */
	public static function add_controller($name, $uri_prefix) {
		#region Check input values
		$uri_prefix = trim($uri_prefix, '/');

		if (!empty($uri_prefix) && !preg_match('/^([a-zA-Z0-9-_]+\/?)+$/', $uri_prefix)) {
			throw new InvalidArgumentException('Controller URI prefix must contain only latin letters, numbers, "/" and "-", and cannot contain two or more "/" in sequence."!');
		}

		$name = trim(str_replace(array('/', '|'), '\\', $name));

		if (empty($name)) {
			throw new InvalidArgumentException('Controller name cannot be empty');
		}

		if (isset(self::$controllers[$name])) {
			throw new InvalidArgumentException("Controller with name '{$name}' already exists!");
		}
		#endregion

		self::$controllers[$name] = (new controller_route($uri_prefix))
			->set_https_only(self::instance()->_is_https)
			->set_allowed_content_types(self::instance()->_allowed_content_types);

		return self::$controllers[$name];
	}

	/**
	 * Add URI route to the controller
	 *
	 * @param string $method
	 * @param string $controller
	 * @param string $uri
	 * @param string $action_function
	 *
	 * @return action_route
	 *
	 * @throws InvalidArgumentException
	 */
	public static function add_route($method, $controller, $uri, $action_function) {
		$controller = trim(str_replace(['/', '|'], '\\', $controller));

		#region Check input values
		if (empty($controller)) {
			throw new InvalidArgumentException('Controller name cannot be empty!');
		}

		if (!isset(self::$controllers[$controller])) {
			throw new \InvalidArgumentException("Controller with name '{$controller}' is not registered!");
		}

		#endregion

		return self::$controllers[$controller]->add_action($method, $uri, $action_function);
	}

	/**
	 * Load routes from cache, or routes files
	 *
	 * @param string $routes_file
	 *
	 * @returns array
	 *
	 * @throws LogicException()
	 * @throws InvalidArgumentException
	 */
	public static function load($routes_file) {

		//print_r($routes_file);
		//die();
		#region Check Input and config properties
		if (!file_exists($routes_file)) {
			throw new \InvalidArgumentException("Routing file '{$routes_file}' does not exist!");
		}

			// load routes from settings file
			/** @noinspection PhpIncludeInspection */
			include($routes_file);
			$routes = self::compile();
			self::$controllers = []; // clear memory from not compiled routes

		return $routes;
	}

	/**
	 * @return routing
	 */
	protected static function instance() {
		if (!isset(self::$instance)) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	/**
	 * Compile routing table to array
	 *
	 * @return array
	 * [
	 *      'controller_name' => [
	 *              'prefix' => string,
	 *              'actions' => [
	 *                  [
	 *                      'is_https' => bool,
	 *                      'allowed_content_types' => string[],
	 *                      'method' => string,
	 *                      'uri' => string,
	 *                      'parameters' => array,
	 *                      'function' => string,
	 *                  ],
	 *                  ...
	 *              ],
	 *      ],
	 *      ...
	 * ]
	 */
	protected static function compile() {
		$result = [];

		foreach (self::$controllers as $name => $controller) {
			$result[$name] = $controller->to_array();
		}

		return $result;
	}
}
