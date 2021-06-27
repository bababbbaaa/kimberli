<?php

namespace KB\network\http;

use InvalidArgumentException, BadMethodCallException;

use KB\network\http\response\renderer;

/**
 * response object
 *
 * @property-read string $content_type
 * @property-read renderer $renderer
 */
class response {
	#region HTTP Codes Constants
	const OK = 200;
	const CREATED = 201; // The resource has been created success.
	const ACCEPTED = 202; // The request has been accepted for processing, but the processing has not been completed.
	const PERMANENTLY = 301; // This and all future requests should be directed to the given.
	const SEE_OTHER = 303; // The response to the request can be found under another URI using the GET method.
	const BAD_REQUEST = 400; // The application cannot or will not process the request because provided data are invalid.
	const UNAUTHORIZED = 401; // Authentication is required and has failed or has not yet been provided.
	const PAYMENT_REQUIRED = 402; // The resource is available but limited due exceeded payed limit or content is payable.
	const FORBIDDEN = 403; // The user might not have the necessary permissions for a resource
	const NOT_FOUND = 404; // The requested resource could not be found but may be available in the future.
	const METHOD_NOT_ALLOWED = 405; // A request HTTP method is not supported for the requested resource.
	const NOT_ACCEPTABLE = 406; // The requested resource is capable of generating only content not acceptable according to the Accept headers sent in the request.
	const TOO_MANY_REQUESTS = 429; // The user has sent too many requests in a given amount of time.
	const INTERNAL_SERVER_ERROR = 500; // A generic error message, given when an unexpected condition was encountered and no more specific message is suitable.
	const NOT_IMPLEMENTED = 501; // The method is not implemented yet and will be available later.
	#endregion

	/**
	 * @var request
	 */
	protected $_request;

	/**
	 * response headers
	 * @type array
	 */
	protected $_headers = [];

	/**
	 * response content type
	 * @var string
	 */
	protected $_content_type;

	/**
	 * response renderer
	 *
	 * @var renderer
	 */
	protected $_renderer;

	/** HTTP_CODE
	 *
	 * @var int
	 */
	protected $_http_code;

	/**
	 * response data
	 * @var mixed
	 */
	protected $_data;

	/**
	 * @param request $request
	 *
	 * @return response
	 */
	public static function create(request $request) {
		// by default we use first requested text content type or HTML. Later we might redefine it based on routing settings.
		$default_content_type = content_type::HTML;

		foreach ($request->accept_content_types as $content_type) {
			if (content_type::is_text($content_type)) {
				$default_content_type = $content_type;

				break;
			}
		}

		return new self($default_content_type, $request);
	}

	/**
	 * Response constructor.
	 *
	 * @param string $content_type
	 * @param request $request
	 */
	protected function __construct($content_type, request $request) {
		$this->_content_type = $content_type;
		$this->_request = $request;
		$this->_http_code = self::OK;
	}

	/**
	 * Getter
	 *
	 * @param string $name
	 *
	 * @return mixed
	 * @throws \InvalidArgumentException
	 */
	public function __get($name) {
		switch ($name) {
			case 'http_code':
				return $this->_http_code;
			case 'headers':
				return $this->_headers;
			case 'content_type':
				return $this->_content_type;
			case 'renderer':
				return $this->_renderer;
			default:
				throw new InvalidArgumentException('Undefined property!');
		}
	}

	/**
	 * Inject modified renderer with specific content type support
	 *
	 * @param response\renderer $renderer
	 */
	public function set_renderer(renderer $renderer) {
		$this->_renderer = $renderer;
	}

	/**
	 * @param string $header
	 * @param string $value
	 *
	 * @return response
	 *
	 * @throws \InvalidArgumentException
	 */
	public function set_header($header, $value) {
		$header = rtrim($header, ':');
		$value = ltrim($value, ':');

		if (empty($header)) {
			throw new InvalidArgumentException('Parameter header name cannot be empty');
		}

		if (!preg_match('/^[a-z][a-z0-9-]+$/i', $header)) {
			throw new InvalidArgumentException('Header name contains not acceptable character!');
		}

		$this->_headers[$header] = $value;

		return $this;
	}

	/**
	 * @param int $http_code
	 *
	 * @return response
	 *
	 * @throws \InvalidArgumentException
	 */
	public function set_code($http_code) {
		if (empty($http_code) || !is_numeric($http_code)) {
			throw new InvalidArgumentException('HTTP Code is invalid!');
		}

		if (599 < $http_code || $http_code < 200) {
			throw new InvalidArgumentException("HTTP Code is invalid: '{$http_code}'!");
		}

		$this->_http_code = $http_code;

		if ($this->_request->is_primary()) {
			http_response_code($http_code);
		}

		return $this;
	}

	/**
	 * @return int $http_code
	 */
	public function get_code() {
		return $this->_http_code;
	}

	/**
	 * @param string $content_type
	 *
	 * @return response
	 *
	 * @throws \InvalidArgumentException
	 */
	public function set_content_type($content_type) {
		if (!content_type::is_valid($content_type)) {
			throw new InvalidArgumentException("Invalid content type provided: '{$content_type}'!");
		}

		$this->_content_type = $content_type;

		return $this;
	}

	/**
	 * Set response data
	 *
	 * @param mixed $response_data
	 *
	 * @return response
	 */
	public function set($response_data) {
		$this->_data = $response_data;

		return $this;
	}

	/**
	 * Get response data
	 *
	 * @param string $key
	 *
	 * @return mixed
	 */
	public function get($key) {
		if (!is_string($key) || empty($key)) {
			throw new BadMethodCallException('The property "key" must be not empty string');
		}

		return isset($this->_data[$key]) ? $this->_data[$key] : null;
	}

	/**
	 * Merge response data (only array)
	 *
	 * @param array $response_data
	 *
	 * @return http\response
	 */
	public function merge(array $response_data) {
		if (null === $this->_data) {
			$this->_data = $response_data;

			return $this->set($response_data);
		}

		if (!is_array($this->_data)) {
			throw new BadMethodCallException('Data already sent, and it is not array!');
		}

		$this->_data = array_merge($this->_data, $response_data);

		return $this;
	}

	/**
	 * Merge response data recursive, according with array_merge_recursive() logic
	 * DSP18-28085: Created to extend possibilities of merge method
	 *
	 * @param array $response_data
	 *
	 * @return http\response
	 */
	public function merge_recursive(array $response_data) {
		if (null === $this->_data) {
			$this->_data = $response_data;

			return $this->set($response_data);
		}

		if (!is_array($this->_data)) {
			throw new BadMethodCallException('Data already sent, and it is not array!');
		}

		$this->_data = array_merge_recursive($this->_data, $response_data);

		return $this;
	}

	/**
	 * Set element of the response array by path
	 *
	 * @param string $path
	 *        Dot separated path of the property into response array
	 * @param mixed $value
	 *        Value of the property
	 *
	 * @return  http\response
	 *
	 * @throws \BadMethodCallException
	 *        - response is a string
	 */
	public function set_by_path($path, $value) {
		if (!isset($this->_data)) {
			$this->_data = [];
		} else {
			if (!is_array($this->_data)) {
				throw new BadMethodCallException('The response data is already set and it is not an array!');
			}
		}

		$this->_data[$path] = $value;

		return $this;
	}

	/**
	 * Parse response data in string and return
	 *
	 * @return string
	 */
	public function render() {
		if (!isset($this->_renderer)) {
			// if render logic was not provided - use default renderer
			$this->_renderer = new renderer();
		}

		$response = $this->_renderer->render($this->_data, $this->_content_type);
		$this->_headers['Content-Length'] = $this->_renderer->size;

		return $response;
	}

	/**
	 * Send headers and echo response
	 *
	 * return string
	 */
	public function send() {
		$response = $this->render();
		$this->send_headers();

		echo $response;
	}

	/**
	 * Send headers to the requester
	 *
	 * @throws \BadMethodCallException
	 *      - if headers have been already sent
	 */
	public function send_headers() {
		if (!isset($this->_headers)) {
			throw new BadMethodCallException('Headers have been already sent!');
		}

		if (!array_key_exists('Access-Control-Allow-Origin', $this->_headers)) {
			$this->_headers['Access-Control-Allow-Origin'] = '*';
		}

		$this->_headers['Content-Type'] = $this->_content_type . '; charset=utf-8';

		if ($this->_request->is_primary()) {
			foreach ($this->_headers as $header => $value) {
				if (headers_sent()) {
					return;
				}

				header("{$header}: {$value}");
			}
		}

		unset($this->_headers);
	}

	/**
	 * Redirect
	 *
	 * @param string $url
	 * @param int $code
	 *
	 * @throws \InvalidArgumentException
	 *      - if $url is empty string
	 */
	public function redirect($url, $code = self::PERMANENTLY) {
		#region Check input data
		if (empty($url)) {
			throw new InvalidArgumentException('URL cannot be an empty string!');
		}

		if ($code != self::PERMANENTLY && $code != self::SEE_OTHER) {
			throw new InvalidArgumentException('Redirect code can be only PERMANENTLY or SEE_OTHER, the provide value is: ' . $code);
		}
		#endregion

		$this->_headers['Location'] = $url;

		$this->set_code($code);
		$this->send_headers();
		exit();
	}

	/**
	 * Set headers for cross domain requests
	 *
	 * @link https://developer.mozilla.org/en-US/docs/Web/HTTP/CORS#Preflighted_requests
	 *
	 * @param array $allowed_methods
	 * @param array $allowed_headers
	 * @param int $cache
	 *
	 * @throws InvalidArgumentException
	 *      - allowed methods list is empty
	 *      - cache is zero or negative
	 */
	public function allow_cross_domain(array $allowed_methods, array $allowed_headers, $cache) {
		if (empty($allowed_methods)) {
			throw new InvalidArgumentException('The list of allowed HTTP methods for cross domain cannot be empty!');
		}

		foreach ($allowed_methods as $method) {
			if (!is_string($method) || !request::is_http_method_valid($method)) {
				throw new InvalidArgumentException('One of provided HTTP methods is invalid!');
			}
		}

		if (empty($allowed_headers)) {
			throw new InvalidArgumentException('The list of allowed HTTP headers for cross domain cannot be empty!');
		}

		foreach ($allowed_headers as $header) {
			if (!is_string($header) || !preg_match('/[a-z][a-z0-9-]+/i', $header)) {
				throw new InvalidArgumentException('One of provided headers is invalid!');
			}
		}

		if ($cache < 1) {
			throw new InvalidArgumentException('Cache time for cross domain cannot be zero or negative!');
		}

		$this->set_header('Access-Control-Allow-Methods', implode(', ', $allowed_methods));
		$this->set_header('Access-Control-Allow-Headers', implode(', ', $allowed_headers));
		$this->set_header('Access-Control-Max-Age', (string) $cache);
	}

	#region Low level HTTP Errors
	/**
	 * 404 Not Found
	 */
	public function resource_not_found() {
		$this->set_code(self::NOT_FOUND);

		$this->send();
		exit();
	}

	/**
	 * 400 Bad Request
	 * Use if the incoming GET or POST parameters are invalid
	 */
	public function bad_request() {
		$this->set_code(self::BAD_REQUEST);
		$this->send();
		exit();
	}

	/**
	 * 401 Unauthorized
	 * Use this error if request does not provide the required authorization
	 */
	public function unauthorized() {
		$this->set_code(self::UNAUTHORIZED);
		$this->send();
		exit();
	}

	/**
	 * 403 Forbidden
	 * Use this error if request must be secure but use HTTP, instead of HTTPS
	 * or if you want limit access for customer by IP, county or other
	 */
	public function forbidden() {
		$this->set_code(self::FORBIDDEN);
		$this->send();
		exit();
	}

	/**
	 * 406 Not Acceptable
	 * Use this error if requested content type is not acceptable
	 *
	 * @param array $allowed_content_types
	 *            allowed content types for the requested API method
	 */
	public function not_acceptable(array $allowed_content_types) {
		$this->set_code(self::NOT_ACCEPTABLE)
			->set_header('Accept', implode(',', $allowed_content_types));

		$this->send();
		exit();
	}
	#endregion
}
