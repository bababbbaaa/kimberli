<?php

namespace rest\controller;

use KB\network\http\response;
use KB\network\http\content_type;
use rest\renderer\rest;
use KB\rest_server\controller;
use rest\validation\ValidationException;

use Throwable;

/**
 * Base controller for business logic layer. All controllers with application logic MUST inherit from this one.
 * Provide Cross-Domain support and set answer standards for all actions.
 *
 * @property int resellerId
 * @property int $requestLogId
 */
abstract class base_controller extends controller {
	/**
	 * @throws \Exception
	 */
	protected function execute_before_action() {
		$this->response->set_content_type(content_type::JSON);
		$this->response->set_renderer(new rest($this->response));

	}

	/**
	 * Common logic after every action in the controller
	 */
	protected function execute_after_action() {
		// if action is success completed, add allow origin header for cross domain requests
		$this->response->set_header('Access-Control-Allow-Origin', '*');
		$this->response->set_header('Vary', empty($this->request->headers['Vary']) ? 'Origin' : $this->request->headers['Vary'] . ', Origin');
	}

	/**
	 * Execute action logic. Rewrite parent method to format response by application standards
	 */
	public function execute() {
		$answer = null;

		try {
			parent::execute();
		} catch (ValidationException $answer) {
			$this->response->set_code(response::BAD_REQUEST);
		} catch (Throwable $answer) {
			$this->response->set_code(response::INTERNAL_SERVER_ERROR);
		}

		if (null !== $answer) {
			$this->response->set($answer);
		}

		$this->response->set_header('Cache-Control', 'no-cache, no-store, must-revalidate');
		$this->response->set_header('Pragma', 'no-cache');
		$this->response->set_header('Expires', '0');

		return $this->response;
	}
}
