<?php

namespace KB\rest_server;

use RuntimeException, LogicException, InvalidArgumentException;

use KB\network\http\response;
use KB\network\http\request;



/**
 * Base class for controllers
 *
 * @property request $request
 * @property response $response
 * @property string $action
 * @property array $parameters
 */
abstract class controller {
	#region parameters
	/**
	 * @var route
	 */
	private $_route;

	/**
	 * @var request
	 */
	private $_request;

	/**
	 * @var response
	 */
	private $_response;
	#endregion

	/**
	 * @param route $route
	 * @param request $request
	 * @param response $response
	 */
	private function __construct(route $route, request $request, response $response) {
		$this->_route = $route;
		$this->_request = $request;
		$this->_response = $response;
	}

	/**
	 * Common logic before every action in the controller
	 */
	abstract protected function execute_before_action();

	/**
	 * Common logic before every action in the controller
	 */
	abstract protected function execute_after_action();

	/**
	 * @param string $name
	 *
	 * @return mixed
	 * @throws InvalidArgumentException
	 */
	public function __get($name) {
		switch ($name) {
			case 'request':
				return $this->_request;
			case 'response':
				return $this->_response;
			case 'controller_name':
				return $this->_route->controller_name;
			case 'action':
				return $this->_route->action;
			case 'parameters':
				return $this->_route->parameters;
			default:
				throw new InvalidArgumentException("Property '{$name}' does not exist in class " . get_class($this));
		}
	}

	public static function build(route $route, request $request, response $response) {
		$class_name = 'rest\controller\\' . $route->controller_name . '_controller';

		if (!class_exists($class_name)) {
			throw new LogicException("Controller class '{$class_name}' does not exist!");
		}

		$action = "action_{$route->action}";

		if (!method_exists($class_name, $action)) {
			throw new LogicException("Controller '{$class_name}' does not have action method '{$action}'!");
		}

		return new $class_name($route, $request, $response);
	}

	/**
	 * Execute action and return response. The action can return no response.
	 *
	 * @return response
	 *
	 * @throws Throwable - if action throws one
	 */
	public function execute() {
		$answer = null;

		try {
			$this->execute_before_action();
			$answer = call_user_func_array([$this, "action_{$this->action}"], $this->parameters);
		} finally {
			$this->execute_after_action();
		}

		if (null !== $answer) {
			$this->response->set($answer);
		}

		return $this->response;
	}
}
