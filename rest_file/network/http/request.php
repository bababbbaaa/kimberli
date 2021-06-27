<?php

namespace KB\network\http;

use InvalidArgumentException, RuntimeException;

/**
 * Contains request properties and data.
 *
 * @property string $http_method;
 * @property string[] $headers;
 * @property bool $is_https;
 * @property string $base_url;
 * @property string $uri;
 * @property string $uri_prefix;
 * @property string $uri_prefix_pattern;
 * @property string[] $accept_content_types;
 * @property string[] $accept_languages;
 * @property string $content_type;
 * @property string $client_browser;
 * @property array $data_get;
 * @property array $data_post;
 * @property array $data_files;
 * @property string $origin
 * @property string[] $http_server_vars
 */
class request
{
	const GET = 'GET';
	const POST = 'POST';
	const PUT = 'PUT';
	const PATCH = 'PATCH';
	const DELETE = 'DELETE';
	const OPTIONS = 'OPTIONS';
	const DEFAULT_CONTENT_TYPE = content_type::HTML;

	#region properties
	/**
	 * Primary request object
	 *
	 * @var request
	 */
	protected static $primary_request;

	/** @var bool */
	protected $_is_primary = false;

	/** @var string */
	protected $_http_method;

	/** @var array */
	protected $_headers;

	/** @var bool */
	protected $_is_https;

	/**
	 * As minimum "/" or base path to the application input point covered with slashes
	 *
	 * @var string
	 */
	protected $_base_url;

	/**
	 * Requested URI without base URL and wrapped slashes. As minimum empty string.
	 *
	 * @var string
	 */
	protected $_uri;

	/**
	 * Requested original URI with prefix
	 *
	 * @var string
	 */
	protected $_original_uri;

	/**
	 * Pattern for URI prefix
	 *
	 * @var string
	 */
	protected $_uri_prefix_pattern;

	/**
	 * URI prefix
	 *
	 * @var string
	 */
	protected $_uri_prefix;

	/** @var string[] */
	protected $_accept_content_types;

	/** @var string[] */
	protected $_accept_languages;

	/** @var string */
	protected $_content_type;

	/** @var string */
	protected $_client_browser;

	/** @var array */
	protected $_data_get;

	/** @var array */
	protected $_data_post;

	/** @var array */
	protected $_data_files;

	/** @var string */
	protected $_origin;

	/** @var array */
	protected $_http_server_vars;
	#endregion

	/**
	 * Get request instance
	 *
	 * @param string $url_prefix
	 * @param array|null $http_server_vars
	 *
	 * @return http\request
	 */
	public static function create($url_prefix = null, array $http_server_vars = null)
	{
		if (null !== self::$primary_request && (empty($http_server_vars) || !is_array($http_server_vars))) {
			throw new InvalidArgumentException('You need define "http_server_vars" property for child request');
		}

		if (null === $http_server_vars) {
			$http_server_vars = $_SERVER;
		}

		$object = new self($http_server_vars);

		if (null !== $url_prefix) {
			$object->set_prefix_pattern($url_prefix);
		}

		$object->init();

		if (null === self::$primary_request) {
			$object->_is_primary = true;

			// primary request
			self::$primary_request = $object;
		}

		return $object;
	}

	/**
	 * Check if request is primary
	 *
	 * @return bool
	 */
	public function is_primary()
	{
		return $this->_is_primary;
	}

	/**
	 * Get the list with all HTTP methods
	 *
	 * @return string[]
	 */
	public static function all_http_methods()
	{
		return [
			self::GET,
			self::POST,
			self::PUT,
			self::PATCH,
			self::DELETE,
			self::OPTIONS,
		];
	}

	/**
	 * Check if $method is a valid HTTP method
	 *
	 * @param string $method
	 *
	 * @return bool
	 */
	public static function is_http_method_valid($method)
	{
		return in_array($method, self::all_http_methods(), true);
	}

	/**
	 * Checking is it ajax request or not
	 *
	 * @return bool
	 */
	public function is_ajax()
	{
		if (!empty($this->_http_server_vars['HTTP_X_REQUESTED_WITH']) && strtolower($this->_http_server_vars['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
			return true;
		}

		return false;
	}

	/**
	 * @return string
	 * @codeCoverageIgnore
	 */
	protected function input_stream_content()
	{
		return file_get_contents("php://input");
	}

	/**
	 * Private constructor to prevent create a new instance
	 * @codeCoverageIgnore
	 *
	 * @param $http_server_vars
	 */
	protected function __construct(array $http_server_vars = null)
	{
		$this->_http_server_vars = $http_server_vars;
	}

	/** @noinspection PhpUnusedPrivateMethodInspection */
	/** @codeCoverageIgnore */
	private function __sleep()
	{
	}

	/** @noinspection PhpUnusedPrivateMethodInspection */
	/** @codeCoverageIgnore */
	private function __wakeup()
	{
	}

	/** @noinspection PhpUnusedPrivateMethodInspection */
	/** @codeCoverageIgnore */
	private function __clone()
	{
	}

	/**
	 * @param string $name
	 *
	 * @return mixed
	 * @throws \InvalidArgumentException
	 */
	public function __get($name)
	{
		$property = "_{$name}";

		if (property_exists($this, $property)) {
			return $this->$property;
		}

		throw new InvalidArgumentException("The property '{$name}' does not exist in the class " . __CLASS__);
	}

	/**
	 * Get one or all $_GET parameters
	 *
	 * @param string $name - if null return full $_GET array
	 * @param mixed $default_value
	 *
	 * @return mixed
	 */
	public function get($name = null, $default_value = null)
	{
		if (empty($name)) {
			return $this->_data_get;
		}

		if (isset($this->_data_get[$name])) {
			return $this->_data_get[$name];
		}

		return $default_value;
	}

	/**
	 * Get one or all $_POST parameters
	 *
	 * @param string $name - if null return full $_POST array
	 * @param mixed $default_value
	 *
	 * @return mixed
	 */
	public function post($name = null, $default_value = null)
	{
		if (empty($name)) {
			return $this->_data_post;
		}

		if (isset($this->_data_post[$name])) {
			return $this->_data_post[$name];
		}

		return $default_value;
	}

	/**
	 * Get one or all $_FILES parameters
	 *
	 * @param string $name - if null return full $_FILES array
	 * @param mixed $default_value
	 *
	 * @return mixed
	 */
	public function files($name = null, $default_value = null)
	{
		if (empty($name)) {
			return $this->_data_files;
		}

		if (isset($this->_data_files[$name])) {
			return $this->_data_files[$name];
		}

		return $default_value;
	}

	/**
	 * Collect request properties
	 */
	protected function init()
	{
		$this->_http_method = isset($this->_http_server_vars['REQUEST_METHOD']) ? $this->_http_server_vars['REQUEST_METHOD'] : self::GET;
		$this->_is_https = $this->is_request_secure();
		$this->_headers = $this->headers();
		$this->_accept_content_types = $this->accept_content_types();
		$this->_accept_languages = $this->accept_languages();
		$this->_content_type = $this->content_type();
		$this->_client_browser = isset($this->_http_server_vars['HTTP_USER_AGENT']) ? $this->_http_server_vars['HTTP_USER_AGENT'] : '';
		$this->_origin = isset($this->_http_server_vars['HTTP_ORIGIN']) ? $this->_http_server_vars['HTTP_ORIGIN'] : '';

		$this->parse_url(); // detect URI and Base URL

		switch ($this->_content_type) {
			case content_type::JSON:
				$this->_data_post = json_decode($this->input_stream_content(), true);

				break;
			case content_type::XML:
				$xml = simplexml_load_string($this->input_stream_content());

				if ($xml != false) {
					$json = json_encode($xml);
					$this->_data_post = json_decode($json, true);
				}

				break;
			default:
				if ($this->_http_method === self::PUT || $this->_http_method === self::PATCH || $this->_http_method === self::DELETE) {
					parse_str($this->input_stream_content(), $this->_data_post);
				} else {
					$this->_data_post = empty($_POST) ? [] : $_POST;
				}
		}

		$this->_data_get = empty($_GET) ? [] : $_GET;
		$this->_data_files = empty($_FILES) ? [] : $_FILES;

		// prevent using global variables
		//unset($_POST, $_GET, $_FILES);
	}

	/**
	 * @param string $pattern
	 */
	protected function set_prefix_pattern($pattern)
	{
		if (!is_string($pattern) || empty($pattern)) {
			throw new InvalidArgumentException('The property "pattern" can\'t be empty');
		}

		$this->_uri_prefix_pattern = filter_var($pattern, FILTER_SANITIZE_STRING);
	}

	/**
	 * Check if request is secure (https)
	 *
	 * @return bool
	 */
	protected function is_request_secure()
	{
		if (php_sapi_name() === 'cli') {
			return false;
		}

		// check $_SERVER['HTTPS'], if set, we trust this value
		if (!empty($this->_http_server_vars['HTTPS'])) {
			return filter_var($this->_http_server_vars['HTTPS'], FILTER_VALIDATE_BOOLEAN);
		}

		// possible load balancer option
		if (!empty($this->_http_server_vars['HTTP_USESSL'])) {
			return filter_var($this->_http_server_vars['HTTP_USESSL'], FILTER_VALIDATE_BOOLEAN);
		}

		// one more option of load balancer
		if (!empty($this->_http_server_vars['HTTP_X_FORWARDED_PROTO'])) {
			return $this->_http_server_vars['HTTP_X_FORWARDED_PROTO'] === 'https';
		}

		// and one more option for balancer
		if (!empty($this->_http_server_vars['HTTP_X_FORWARDED_SSL'])) {
			return filter_var($this->_http_server_vars['HTTP_X_FORWARDED_SSL'], FILTER_VALIDATE_BOOLEAN);
		}

		// if nothing help - check the port. It does not guaranty SSL connection, check application settings.
		return ($this->_http_server_vars['SERVER_PORT'] === 443);
	}

	/**
	 * Return a list of accepted content types in quality order.
	 * If accept request header is not set, returns empty array.
	 *
	 * @return string[]
	 */
	protected function accept_content_types()
	{
		$default = [self::DEFAULT_CONTENT_TYPE];
		$header = isset($this->_http_server_vars['HTTP_ACCEPT']) ? $this->_http_server_vars['HTTP_ACCEPT'] : '';

		if (empty($header)) {
			return $default;
		}

		$content_types = [];
		$types = explode(',', $header);

		foreach ($types as $type) {
			$parts = explode(';', $type);
			$type = strtolower(trim(array_shift($parts)));
			$quality = 1.0;

			foreach ($parts as $part) {
				if (strpos($part, '=') === false) {
					continue;
				}

				list ($key, $value) = explode('=', trim($part));

				if ($key === 'q') {
					$quality = (float)trim($value);
				}
			}

			if (content_type::is_valid($type)) {
				$content_types[$type] = $quality;
			} else if ($type === '*/*') {
				$all_content_types = content_type::get_list();

				if (empty($all_content_types)) {
					if (!isset($content_types[self::DEFAULT_CONTENT_TYPE])) {
						$content_types[self::DEFAULT_CONTENT_TYPE] = $quality;
					}
				} else {
					foreach ($all_content_types as $_content_type) {
						if (isset($content_types[$_content_type])) {
							continue;
						}

						$content_types[$_content_type] = $quality;
					}
				}
			} else if ($type === 'text/*') {
				$content_types[content_type::TEXT] = $quality;
			} else if ($type === 'image/*') {
				$content_types[content_type::JPG] = $quality;
			}
		}

		arsort($content_types);

		return empty($content_types) ? $default : array_keys($content_types);
	}

	/**
	 * Return a list of accepted languages.
	 * If Accept-Language request header is not set, returns empty array.
	 *
	 * @return string[]
	 */
	protected function accept_languages()
	{
		$header = isset($this->_http_server_vars['HTTP_ACCEPT_LANGUAGE']) ? strtolower($this->_http_server_vars['HTTP_ACCEPT_LANGUAGE']) : '';

		if (empty($header)) {
			return [];
		}

		$languages = [];
		$types = explode(',', $header);

		foreach ($types as $type) {
			$parts = explode(';', $type);
			$type = trim(array_shift($parts));
			$quality = 1.0;

			foreach ($parts as $part) {
				if (strpos($part, '=') === false) {
					continue;
				}

				list ($key, $value) = explode('=', trim($part));

				if ($key === 'q') {
					$quality = (float)trim($value);
				}
			}

			if (strpos($type, '-') !== false) {
				$parts = explode('-', $type);
				$type = array_shift($parts);
			}

			if (!isset($languages[$type]) || $languages[$type] < $quality) {
				$languages[$type] = $quality;
			}
		}

		arsort($languages);

		return empty($languages) ? [] : array_keys($languages);
	}

	/**
	 * Get input data content type
	 *
	 * @return string
	 */
	protected function content_type()
	{
		$content_type_row = isset($this->_http_server_vars['CONTENT_TYPE']) ? $this->_http_server_vars['CONTENT_TYPE'] : (isset($this->_http_server_vars['HTTP_CONTENT_TYPE']) ? $this->_http_server_vars['HTTP_CONTENT_TYPE'] : '');

		if (empty($content_type_row)) {
			return '';
		}

		$content_type = explode(';', $content_type_row);

		/*
		 TODO charset, boundary
		 Content-Type: text/html; charset=UTF-8
		 Content-Type: multipart/form-data; boundary=something
		 */

		return isset($content_type[0]) ? trim($content_type[0]) : '';
	}

	/**
	 * Return a list of requested headers
	 *
	 * @return array
	 */
	protected function headers()
	{
		$headers = [];

		foreach ($this->_http_server_vars as $key => $value) {
			if (strpos($key, 'HTTP_') === 0) {
				// HTTP_X_REQUESTED_WITH -> X-Requested-With
				// HTTP_CONTENT_TYPE -> Content-Type
				$header = str_replace(' ', '-', ucwords(str_replace('_', ' ', strtolower(substr($key, 5)))));
				$headers[$header] = $value;
			}
		}

		return $headers;
	}

	/**
	 * Get url information.
	 * NOTE: base path has leading "/" and closing "/", or can be just "/"
	 *        uri is trimmed with "/"
	 *
	 * @throws \Exception
	 *      - if cannot get URI from: PATH_INFO, REQUEST_URI, PHP_SELF
	 */
	protected function parse_url()
	{
		$uri = $this->find_uri();


		#region _uri_prefix
		if (null !== $this->_uri_prefix_pattern) {
			$uri_prefix = strstr(ltrim($uri, '/'), '/', true);

			if (!empty($uri_prefix) && preg_match($this->_uri_prefix_pattern, $uri_prefix)) {
				$uri_prefix = '/' . $uri_prefix;
				$uri = substr($uri, strlen($uri_prefix));
			} else {
				$uri_prefix = '';
			}

			if (!empty($uri_prefix)) {
				$this->_uri_prefix = $uri_prefix;
			}
		}
		#endregion

		// delete query part
		$pos = strpos($uri, '?');

		if ($pos !== false) {
			$uri = substr($uri, 0, $pos);
		}

		$this->_base_url = '/';

		// if we are not in the root, try to determine the base path
		if (!empty($this->_http_server_vars['SCRIPT_NAME'])) {
			$index_position = strpos($this->_http_server_vars['SCRIPT_NAME'], 'index.php');

			if ($index_position !== false) {
				$this->_base_url = substr($this->_http_server_vars['SCRIPT_NAME'], 0, $index_position);

				if (strpos($uri, $this->_base_url) === 0) {
					$uri = substr($uri, strlen($this->_base_url));
				}
			}
		}

		$this->_uri = trim($uri, '/');
	}

	/**
	 * Get requested URI from application properties
	 *
	 * @return string
	 * @throws \RuntimeException
	 */
	protected function find_uri()
	{
		// try get requested URI
		if (isset($this->_http_server_vars['PATH_INFO']) && !empty($this->_http_server_vars['PATH_INFO'])) {
			return $this->_http_server_vars['PATH_INFO'];
		}

		if (isset($this->_http_server_vars['REQUEST_URI']) && !empty($this->_http_server_vars['REQUEST_URI'])) {
			return $this->_http_server_vars['REQUEST_URI'];
		}

		if (isset($this->_http_server_vars['PHP_SELF']) && !empty($this->_http_server_vars['PHP_SELF'])) {
			$uri = $this->_http_server_vars['PHP_SELF'];

			// delete index.php from uri
			if (strpos($uri, '/index.php') !== false) {
				$uri = substr_replace($uri, '', strpos($uri, '/index.php'), strlen('/index.php'));
			}

			return $uri;
		}

		throw new RuntimeException('Cannot find URI in: PATH_INFO, REQUEST_URI, PHP_SELF');
	}
}
