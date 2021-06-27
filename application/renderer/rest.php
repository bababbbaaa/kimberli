<?php

namespace rest\renderer;

use KB\network\http\response;
use KB\network\http\response\renderer;
use rest\validation\ValidationException;

use Throwable;
use LogicException;
use Exception;

use ArrayObject;


class rest extends renderer {
	/**
	 * @var response $response
	 */
	private $_response;

	public function __construct(response $response) {
		$this->_response = $response;
	}

	protected function json() {

		$data = [
			'status' => $this->_response->get_code() === 200,
		];

		if (empty($this->_data)) {
			// empty response if success
			if ($this->_response->get_code() === 200) {
				$data['data'] = new ArrayObject();
			}

			$this->_data = $data;
		} else if (is_array($this->_data)) {
			$data['data'] = $this->_data;
			$this->_data = $data;
		} else if (is_scalar($this->_data)) {
			//is not binary
			if (preg_match('~[^\x20-\x7E\t\r\n]~', $this->_data) > 0) {
				return parent::binary();
			}

			// some undefined error
			$this->_data = [
				'status' => false,
				'message' => $this->_data,
			];
		} else if ($this->_data instanceof ValidationException) {
			$this->_data = [
				'status' => false,
				'validation' => $this->_data->getValidationError()->toArray(),
			];
		} else if ($this->_data instanceof LogicException) {
			$message = "ERROR: '{$this->_data->getMessage()}' in {$this->_data->getFile()}[{$this->_data->getLine()}]";
			$data['message'] = $message;

			$this->_data = $data;
		} else if ($this->_data instanceof Throwable) {
			// save error in log
			//application::log_error($this->_data);

			$message = "ERROR: '{$this->_data->getMessage()}' in {$this->_data->getFile()}[{$this->_data->getLine()}]";
			$data['message'] = $message;

			$this->_data = $data;
		} else {
			$this->_data = [
				'status' => false,
				'error_message' => $this->_data,
			];
		}

		return parent::json();
	}
}
