<?php

namespace KB\rest_server\routing;

use InvalidArgumentException, LogicException;
use KB\network\http\content_type;

/**
 * Base class for routing description
 */
class base_route {
	/** @var bool */
	protected $_is_https;

	/** @var string[] */
	protected $_allowed_content_types = [content_type::JSON];

	private function __wakeup() {
	}

	private function __sleep() {
	}

	private function __clone() {
	}

	/**
	 * @param mixed $value - it can be TRUE, "Yes", "On" for positive value and anything else will be negative
	 *
	 * @return base_route
	 */
	public function set_https_only($value) {
		$this->_is_https = (bool) filter_var($value, FILTER_VALIDATE_BOOLEAN);

		return $this;
	}

	/**
	 *
	 * @param $content_types
	 *
	 * @return base_route
	 * @throws \InvalidArgumentException
	 */
	public function set_allowed_content_types($content_types) {
		if (!is_array($content_types)) {
			$content_types = func_get_args();
		}

		foreach ($content_types as $content_type) {
			if (!content_type::is_valid($content_type)) {
				throw new InvalidArgumentException("Invalid content type provided: '{$content_type}'");
			}
		}

		$this->_allowed_content_types = array_unique($content_types);

		return $this;
	}

	/**
	 * Convert object to array
	 *
	 * @return array
	 * [
	 *      'is_https' => bool,
	 *      'allowed_content_types' => string[],
	 * ]
	 *
	 * @throws LogicException
	 */
	public function to_array() {
		if (!isset($this->_is_https)) {
			throw new LogicException('The property "is_https" is not set!');
		}

		if (!isset($this->_allowed_content_types)) {
			throw new LogicException('The property "_allowed_content_types" is not set!');
		}

		return [
			'is_https' => $this->_is_https,
			'allowed_content_types' => $this->_allowed_content_types,
		];
	}
}
