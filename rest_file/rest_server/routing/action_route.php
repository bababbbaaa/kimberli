<?php

namespace KB\rest_server\routing;

use InvalidArgumentException;

/**
 * Class for describing Action in routing table
 */
class action_route extends base_route {
	/** @var string */
	private $_method;

	/** @var string */
	private $_uri;

	/** @var string */
	private $_action_function;

	/** @var string[] */
	private $_parameters;

	/**
	 * Action constructor.
	 *
	 * @param string $method - GET, POST, PUT, DELETE, OPTION
	 * @param string $uri
	 * @param string $action_function
	 */
	public function __construct($method, $uri, $action_function) {
		$this->_method = $method;
		$this->_uri = trim($uri, '/');
		$this->_action_function = $action_function;
		$this->_parameters = [];
	}

	/**
	 * Describe URI parameter
	 *
	 * @param string $placeholder
	 * @param string $pattern
	 *
	 * @throws InvalidArgumentException
	 *        - if placeholder name is empty
	 *        - if $pattern is invalid regex
	 *        - if $placeholder is not found in URI
	 *
	 * @return $this
	 */
	public function parameter($placeholder, $pattern = '.+') {
		#region Check input data
		if (empty($placeholder)) {
			throw new InvalidArgumentException('The placeholder cannot be an empty string.');
		}

		if (strpos($placeholder, '>') !== false || strpos($placeholder, '<') !== false) {
			throw new InvalidArgumentException("The placeholder cannot contain '<' or '>' characters");
		}

		// normalize the pattern
		$pattern = str_replace('/', '\/', str_replace('\/', '/', $pattern));

		if (@preg_match("/{$pattern}/", '') === false) {
			throw new InvalidArgumentException("The supplied regex pattern '$pattern' is invalid.");
		}

		if (strpos($this->_uri, "<{$placeholder}>") === false) {
			throw new InvalidArgumentException("The supplied parameter '<{$placeholder}>' was not found in the path pattern '{$this->_uri}'.");
		}
		#endregion

		$this->_parameters[$placeholder] = $pattern;

		return $this;
	}

	/**
	 * Convert object to array
	 *
	 * @return array
	 * [
	 *      'is_https' => bool,
	 *      'allowed_content_types' => string[],
	 *      'method' => string,
	 *      'uri' => string,
	 *      'parameters' => array,
	 *      'function' => string,
	 * ]
	 *
	 * @throws InvalidArgumentException
	 *      - URI contains variable part, but this part does not have parameter declaration
	 */
	public function to_array() {
		// check all variable URI parts has parameter declaration
		foreach (explode('/', $this->_uri) as $part) {
			if (strpos($part, '<') !== 0) {
				continue;
			}

			$placeholder = trim($part, '<>');

			if (!isset($this->_parameters[$placeholder])) {
				throw new InvalidArgumentException("Variable URI part '{$part}' does not have parameter declaration. Action function is '{$this->_action_function}'.");
			}
		}

		$result = parent::to_array();
		$result['method'] = $this->_method;
		$result['uri'] = $this->_uri;
		$result['parameters'] = $this->_parameters;
		$result['function'] = $this->_action_function;

		return $result;
	}
}
