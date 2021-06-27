<?php

namespace KB\rest_server\routing;

use InvalidArgumentException;
use KB\network\http\request;

/**
 * Class for describing controller in routing table
 */
class controller_route extends base_route {
	/** @var string */
	private $_uri_prefix;

	/** @var action_route[] */
	private $_actions = [];

	/**
	 * ControllerRout constructor.
	 *
	 * @param string $uri_prefix
	 */
	public function __construct($uri_prefix) {
		$this->_uri_prefix = trim($uri_prefix, '/');
	}

	/**
	 * @param string $method
	 * @param string $uri
	 * @param string|null $action_function
	 *
	 * @return action_route
	 *
	 * @throws InvalidArgumentException
	 */
	public function add_action($method, $uri, $action_function) {
		#region Validate input properties
		if (!request::is_http_method_valid($method)) {
			throw new InvalidArgumentException('Invalid HTTP method!');
		}

		// Validate URI for double slashes
		if (strpos($uri, '//') !== false) {
			throw new InvalidArgumentException('URI cannot have double slashes!');
		}

		// Validate action_function
		if (empty($action_function)) {
			throw new InvalidArgumentException('Action function name cannot be empty!');
		}

		if (!preg_match("/^[a-z_]+[a-z0-9_]*$/i", $action_function)) {
			throw new InvalidArgumentException("Illegal characters in action function name: '{$action_function}'!");
		}
		#endregion

		/** @var action_route $action */
		$action = (new action_route($method, $uri, $action_function))->set_https_only($this->_is_https)
			->set_allowed_content_types($this->_allowed_content_types);

		$this->_actions[] = $action;

		return $action;
	}

	/**
	 * Convert object to array
	 *
	 * @return array
	 * [
	 *      'prefix' => string,
	 *      'actions' => [
	 *          [
	 *            'is_https' => bool,
	 *            'allowed_content_types' => string[],
	 *            'method' => string,
	 *            'uri' => string,
	 *            'parameters' => array,
	 *            'function' => string,
	 *          ],
	 *          ...
	 *      ],
	 * ]
	 */
	public function to_array() {
		$result = [
			'prefix' => $this->_uri_prefix,
			'actions' => [],
		];

		foreach ($this->_actions as $action) {
			$result['actions'][] = $action->to_array();
		}

		return $result;
	}
}
