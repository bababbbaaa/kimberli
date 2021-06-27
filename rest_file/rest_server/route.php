<?php

namespace KB\rest_server;

use InvalidArgumentException;

/**
 * Active route
 *
 * @property-read bool $is_https
 * @property-read string $controller_name
 * @property-read string $action
 * @property-read array $parameters
 * @property-read array $allowed_content_types
 */
final class route {
	private $_is_https;
	private $_controller_name;
	private $_action;
	private $_allowed_content_types;
	private $_parameters;

	/**
	 * Find matched route by method and URI
	 *
	 * @param array $routing_table
	 * @param string $method
	 * @param string $uri
	 *
	 * @return route or null
	 */
	public static function find(array $routing_table, $method, $uri) {
		// URI is trimmed with "/", root request has empty string URI
		// controller prefix is trimmed with "/", prefix for the root controller is empty string
		// action URI is trimmed with "/", root controller default action has empty string URI
		foreach ($routing_table as $controller_name => $controller) {
			if (empty($uri) && !empty($controller['prefix'])) {
				// empty URI but not root controller
				continue;
			}

			if (empty($controller['prefix']) || $uri === $controller['prefix'] || strpos($uri, $controller['prefix'] . '/') === 0) {
				// URI begins from controller prefix, try to find the action in this controller
				$action_uri = ($controller['prefix'] !== '') ? (string) substr($uri, strlen($controller['prefix']) + 1) : $uri;

				$action = self::find_action($controller['actions'], $action_uri, $method);

				if ($action) {
					return new self($action['is_https'], $controller_name, $action['function'], $action['allowed_content_types'], $action['parameters']);
				}
			}
		}

		return null;
	}

	/**
	 * Try find action inside the controller and convert URI parameters settings (regex) to string values from URI.
	 *
	 * @param array $actions - actions inside the controller
	 * @param string $action_uri - URI part without controller prefix
	 * @param string $method - HTTP method
	 *
	 * @return array or null
	 */
	private static function find_action(array $actions, $action_uri, $method) {
		$decoded_uri = urldecode($action_uri);

		foreach ($actions as $action) {
			if ($method !== $action['method']) {
				continue;
			}

			$parameters = []; // will contain parameters from URI

			if (strpos($action['uri'], '<') === false) {
				// action without parameters, we need strong equivalence
				if ($action['uri'] !== $decoded_uri) {

					continue;
				}
			} else {
				// action with parameters, split URI on parts and check parts one by one
				$uri = $decoded_uri . '/';
				$action_parts = explode('/', $action['uri']);
				$count = count($action_parts);

				// check uri parts with action parts one by one
				for ($i = 0; $i < $count; $i++) {
					$action_part = $action_parts[$i];

					if ($action_part[0] !== '<') {
						// constant part
						$placeholder = null;
						$part_regex = $action_part;
					} else {
						// variable part
						$placeholder = trim($action_part, '<>');
						$part_regex = $action['parameters'][$placeholder];
					}

					$part_regex = str_replace('|', '\|', $part_regex);

					if (!preg_match("|^({$part_regex})/(.*)$|", $uri, $matches)) {
						// next action
						continue 2;
					}

					if ($placeholder) {
						$parameters[$placeholder] = $matches[1]; // collect parameters from URI
					}

					// cut off URI from found part and continue
					$uri = $matches[2];
				}

				if ($uri) {
					// all action parts are gone, but URi still have some data - next action
					continue;
				}
			}

			// action pass all checks
			$action['parameters'] = $parameters;

			return $action;
		}

		return null;
	}

	/**
	 * Route constructor.
	 *
	 * @param bool $is_https
	 * @param string $controller_name
	 * @param string $action
	 * @param array $allowed_content_types
	 * @param array $parameters
	 */
	protected function __construct($is_https, $controller_name, $action, array $allowed_content_types, array $parameters) {
		$this->_is_https = $is_https;
		$this->_controller_name = $controller_name;
		$this->_action = $action;
		$this->_allowed_content_types = $allowed_content_types;
		$this->_parameters = $parameters;
	}

	/**
	 * @param string $name
	 *
	 * @return mixed
	 * @throws InvalidArgumentException
	 */
	public function __get($name) {
		if (property_exists($this, "_{$name}")) {
			return $this->{"_{$name}"};
		}

		throw new InvalidArgumentException("Property '{$name}' does not exist in class " . __CLASS__);
	}
}
