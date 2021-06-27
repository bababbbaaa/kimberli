<?php

namespace KB\rest_server;

use RuntimeException, InvalidArgumentException, BadMethodCallException, ErrorException, Exception, Error;

use KB\network\http\content_type;
use KB\network\http\request;
use KB\network\http\response;


/**
 * REST API entry point
 */
final class application {
	const ROUTES_FILE = 'routes.php';

	/**
	 * @var string
	 */
	private $_application_real_path;

	/**
	 * @var request
	 */
	private $_request;

	/**
	 * @param string $name
	 *
	 * @return request|string
	 */
	public function __get($name) {
		switch ($name) {
			case 'application_real_path':
				return $this->_application_real_path;
			case 'request':
				return $this->_request;
			default:
				throw new InvalidArgumentException("Property '{$name}' does not exist in class " . get_class($this));
		}
	}

	/**
	 * @param string $application_real_path
	 * @param request $request
	 */
	private function __construct($application_real_path, request $request) {
		$this->_application_real_path = $application_real_path;
		$this->_request = $request;
	}

	/**
	 * @param string $application_path
	 *
	 * @return application
	 */
	public static function init($application_path) {
		if (empty($application_path) || !is_string($application_path)) {
			throw new InvalidArgumentException('Property "application_path" must be not empty string!');
		}

		$application_real_path = realpath($application_path);

		if (false === $application_real_path || !is_dir($application_real_path)) {
			throw new \InvalidArgumentException('Application path is invalid!');
		}

		$routers_path = $application_real_path . DIRECTORY_SEPARATOR . self::ROUTES_FILE;

		if (!is_file($routers_path)) {
			throw new \RuntimeException('Routers file not found!');
		}

		$server_config_file = $application_real_path . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'server.php';

		if (!file_exists($server_config_file)) {
			throw new \InvalidArgumentException("Config file '{$server_config_file}' does not exist!");
		}

		$application_config_file = $application_real_path . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'application.php';

		if (!file_exists($application_config_file)) {
			throw new \InvalidArgumentException("Config file '{$application_config_file}' does not exist!");
		}


		$request = request::create();

		return new self($application_real_path, $request);
	}

	public function execute() {
		if ($this->request->is_primary()) {
			// setup auto loader and error handlers
			$this->setup_handlers();


			// set UTF-8
			mb_internal_encoding('UTF-8');
			mb_regex_encoding('UTF-8');
		}


		#region load routes and find current route

		$route = route::find(routing::load($this->application_path(self::ROUTES_FILE)), $this->request->http_method, $this->request->uri);

		$response = response::create($this->request);

		if (!$route) {
			return $response
				->set_code(response::NOT_FOUND)
				->set_content_type(content_type::TEXT)
				->set('Requested resource does not exist.');
		}

		if ($route->is_https && !$this->request->is_https) {
			return $response
				->set_code(response::FORBIDDEN)
				->set_content_type(content_type::TEXT)
				->set('The request is allowed only via secure https protocol.');
		}

		// check allowed content types with requested
		$content_type = self::find_best_content_type($this->request->accept_content_types, $route);

		if (!$content_type) {
			return $response
				->set_code(response::NOT_ACCEPTABLE)
				->set_header('Accept', implode(',', $route->allowed_content_types))
				->set_content_type(content_type::TEXT)
				->set('Not acceptable content type.');
		}

		$response->set_content_type($content_type);
		#endregion

		// execute action
		return controller::build($route, $this->request, $response, $path = $this->application_real_path)->execute();
	}

	/**
	 * Get absolute path to application folder with controller, routes and models
	 *
	 * @param string $relative_path
	 *
	 * @return string
	 */
	public function application_path($relative_path = '') {
		if (!empty($relative_path) && !is_string($relative_path)) {
			throw new InvalidArgumentException('The property "relative_path" must be a string');
		}

		if ($relative_path) {
			return $this->application_real_path . DIRECTORY_SEPARATOR . trim($relative_path, '\/');
		}

		return $this->application_real_path;
	}

	/**
	 * Set system timezone
	 *
	 * @param string $timezone - string like 'UTC' or 'Canada/Yukon'
	 *
	 * @link http://php.net/manual/en/timezones.php
	 *
	 * @throws InvalidArgumentException
	 *      - if provide invalid timezone identifier
	 */
	public static function set_time_zone($timezone) {
		if (@date_default_timezone_set($timezone) === false) {
			throw new InvalidArgumentException('Invalid time zone identifier!');
		}
	}

	/**
	 * Setup auto loader and error handlers
	 * @codeCoverageIgnore
	 */
	protected function setup_handlers() {
		// setup error handlers
		set_exception_handler([$this, 'exception_handler']);
		set_error_handler([__CLASS__, 'error_handler']);
		register_shutdown_function([__CLASS__, 'shutdown_handler']);
	}

	#region Error and Exception handlers
	/**
	 * Allows to catch fatal errors which are not caught by error_handler()
	 * @codeCoverageIgnore
	 */
	public static function shutdown_handler() {
		$error = error_get_last();

		if ($error) {
			self::exception_handler(new ErrorException($error['message'], $error['type'], 0, $error['file'], $error['line']));
		}
	}

	/**
	 * Catches PHP errors and converts them to ErrorException for getting one point for the errors processing
	 * @codeCoverageIgnore
	 *
	 * @param $error_code
	 * @param $message
	 * @param null $file
	 * @param null $line
	 *
	 * @return bool
	 *
	 * @throws ErrorException
	 */
	public static function error_handler($error_code, $message, $file = null, $line = null) {
		if (error_reporting() & $error_code) {
			// convert PHP error to Error Exception
			throw new ErrorException($message, $error_code, 0, $file, $line);
		}

		// do not call internal PHP error handler
		return true;
	}

		/**
	 * One point for caching all error types
	 * @codeCoverageIgnore
	 *
	 * @param Exception|Error $exception
	 *
	 * @throws
	 */
	public function exception_handler($exception) {
		http_response_code(response::INTERNAL_SERVER_ERROR);

		try {

			$response = response::create($this->_request);

			$response->set_content_type(content_type::JSON)
				->set($this->parse_exception($exception))
				->send();
		} catch (Exception $e) {
			try {
				//print_r($e);
			} catch (Exception $e) {
			}
		}

		exit(1);
	}

	public static function parse_exception($e) {
		$trace = [];

		foreach ($e->getTrace() as $item) {
			$trace[] = [
				'file' => isset($item['file']) ? $item['file'] : 'undefined',
				'line' => isset($item['line']) ? $item['line'] : 'undefined',
				'class' => isset($item['class']) ? $item['class'] : 'undefined',
				'function' => isset($item['function']) ? $item['function'] : 'undefined',
			];
		}

		return [
			'error' => $e->getMessage(),
			'type' => get_class($e),
			'file' => $e->getFile(),
			'line' => $e->getLine(),
			'trace' => $trace,
		];
	}
	#endregion

	/**
	 * Cut off system path from file path, makes it shorter and more comfortable for reading
	 *
	 * @param string $file_path
	 *
	 * @return string
	 */
	public function cut_trace_file_path($file_path) {
		if (strpos($file_path, $this->application_path()) !== 0) {
			return $file_path;
		}

		return '...' . (string) substr($file_path, strlen($this->application_path()));
	}

	/**
	 * Find the best content type for the request, or return null if no one content type is acceptable
	 *
	 * @param array $accept_content_types
	 * @param route $route
	 *
	 * @return string
	 */
	private static function find_best_content_type(array $accept_content_types, route $route) {
		$default_content_type = $route->allowed_content_types[0];
		$allows_text_plain = false;

		foreach ($accept_content_types as $requested_type) {
			if ($requested_type === '*/*') {
				return $default_content_type;
			}

			if (in_array($requested_type, $route->allowed_content_types)) {
				return $requested_type;
			}

			if ($requested_type === 'text/plain') {
				$allows_text_plain = true;
			}
		}

		return $allows_text_plain ? $default_content_type : '';
	}
}
