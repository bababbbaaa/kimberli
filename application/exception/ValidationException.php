<?php

namespace rest\validation;

use RuntimeException;

class ValidationException extends RuntimeException {

	private $_errors;

	/**
	 * ValidationException constructor.
	 *
	 * @param errors $errors
	 */
	public function __construct(errors $errors) {
		$this->_errors = $errors;
	}

	public function getValidationError() {
		return $this->_errors;
	}
}