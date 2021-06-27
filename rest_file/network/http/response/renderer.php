<?php

namespace KB\network\http\response;

use ErrorException;
use InvalidArgumentException, BadFunctionCallException;
use KB\network\http\content_type;
use SimpleXMLElement;

/**
 * Class for render different content types into response string
 *
 * @property-read mixed $data
 * @property-read int $size;
 */
class renderer {
	/** @var mixed */
	protected $_data;

	/** @var int */
	protected $_size;

	/**
	 * Getter
	 *
	 * @param string $name
	 *
	 * @return mixed
	 * @throws \InvalidArgumentException
	 */
	public function &__get($name) {
		switch ($name) {
			case 'data':
				return $this->_data;
			case 'size':
				return $this->_size;
			default:
				throw new InvalidArgumentException("The property '{$name}' does not exist in the class!");
		}
	}

	/**
	 * isset() checked
	 *
	 * @param $name
	 *
	 * @return bool
	 */
	public function __isset($name) {
		$name = "_${name}";

		return isset($this->$name);
	}

	/**
	 * Perform transforming data into string for output in HTTP response
	 *
	 * @param mixed $data
	 * @param string $content_type
	 *
	 * @return string
	 * @throws \InvalidArgumentException
	 */
	final public function render(&$data, $content_type) {
		if (is_resource($data)) {
			$resource_type = get_resource_type($data);

			if ('stream' === $resource_type) {
				$this->_data = stream_get_contents($data);
			} else {
				throw new InvalidArgumentException("Invalid resource! Resource type 'stream' is allowed, '{$resource_type}' has been provided.");
			}
		} else if (is_object($data)) {
			$this->_data = $data;
		} else if (is_array($data)) {
			$this->_data = &$data;
		} else {
			$this->_data = (string) $data;
		}

		switch ($content_type) {
			case content_type::JSON:
				$response = $this->json();
				break;
			case content_type::XML:
				$response = $this->xml();
				break;
			case content_type::HTML:
				$response = $this->html();
				break;
			case content_type::TEXT:
				$response = $this->text();
				break;
			case content_type::JPG:
				$response = $this->jpg();
				break;
			case content_type::GIF:
				$response = $this->gif();
				break;
			case content_type::PNG:
				$response = $this->png();
				break;
			case content_type::CSV:
				$response = $this->csv();
				break;
			case content_type::PDF:
				$response = $this->pdf();
				break;
			case content_type::EXCEL:
				$response = $this->excel();
				break;
			case content_type::WORD:
				$response = $this->word();
				break;
			case content_type::BINARY:
				$response = $this->binary();
				break;
			default:
				throw new InvalidArgumentException('Invalid content type provided');
		}

		$this->_size = strlen($response);

		return $response;
	}

	/**
	 * JSON parser
	 *
	 * @return string
	 *
	 * @throws \InvalidArgumentException
	 */
	protected function json() {
		$options =  JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES;

		if (is_array($this->_data)) {
			return json_encode($this->_data, $options);
		}

		if (is_scalar($this->_data)) {
			return json_encode(['message' => &$this->_data], $options);
		}

		throw new InvalidArgumentException('Cannot render an object!');
	}

	/**
	 * XML parser
	 *
	 * @return string
	 *
	 * @throws \InvalidArgumentException
	 */
	protected function xml() {
		if (is_array($this->_data)) {
			$xml = new SimpleXMLElement('<root/>');
			array_walk_recursive($this->_data, array ($xml, 'addChild'));

			return $xml->asXML();
		}

		if (is_scalar($this->_data)) {
			try {
				simplexml_load_string($this->_data); // validation is Xml

				return $this->_data;
			} catch (ErrorException $e) {
				$xml = new SimpleXMLElement('<root/>');
				$xml->addChild('message', (string) $this->_data);

				return $xml->asXML();
			}
		}

		throw new InvalidArgumentException('Cannot render an object!');
	}

	/**
	 * HTML parser
	 *
	 * @return string
	 * @throws \BadFunctionCallException
	 */
	protected function html() {
		if (is_string($this->_data)) {
			return $this->_data;
		}

		// implement this logic for child class for specific needs
		throw new BadFunctionCallException('Method is not implemented!');
	}

	/**
	 * Text parser
	 *
	 * @return string
	 * @throws \BadFunctionCallException
	 */
	protected function text() {
		if (is_string($this->_data)) {
			return $this->_data;
		}

		// implement this logic for child class for specific needs
		throw new BadFunctionCallException('Method is not implemented!');
	}

	/**
	 * CSV parser
	 *
	 * @return string
	 * @throws \BadFunctionCallException
	 */
	protected function csv() {
		if (is_string($this->_data)) {
			return $this->_data;
		}

		// implement this logic for child class for specific needs
		throw new BadFunctionCallException('Method is not implemented!');
	}

	/**
	 * @return string
	 * @throws \BadFunctionCallException
	 */
	protected function jpg() {
		if (is_string($this->_data)) {
			return $this->_data;
		}

		// implement this logic for child class for specific needs
		throw new BadFunctionCallException('Method is not implemented!');
	}

	/**
	 * @return string
	 * @throws \BadFunctionCallException
	 */
	protected function png() {
		if (is_string($this->_data)) {
			return $this->_data;
		}

		// implement this logic for child class for specific needs
		throw new BadFunctionCallException('Method is not implemented!');
	}

	/**
	 * @return string
	 * @throws \BadFunctionCallException
	 */
	protected function gif() {
		if (is_string($this->_data)) {
			return $this->_data;
		}

		// implement this logic for child class for specific needs
		throw new BadFunctionCallException('Method is not implemented!');
	}

	/**
	 * @return string
	 * @throws \BadFunctionCallException
	 */
	protected function pdf() {
		if (is_string($this->_data)) {
			return $this->_data;
		}

		// implement this logic for child class for specific needs
		throw new BadFunctionCallException('Method is not implemented!');
	}

	/**
	 * @return string
	 * @throws \BadFunctionCallException
	 */
	protected function excel() {
		if (is_string($this->_data)) {
			return $this->_data;
		}

		// implement this logic for child class for specific needs
		throw new BadFunctionCallException('Method is not implemented!');
	}

	/**
	 * @return string
	 * @throws \BadFunctionCallException
	 */
	protected function word() {
		if (is_string($this->_data)) {
			return $this->_data;
		}

		// implement this logic for child class for specific needs
		throw new BadFunctionCallException('Method is not implemented!');
	}

	/**
	 * @return string
	 * @throws \BadFunctionCallException
	 */
	protected function binary() {
		if (is_string($this->_data)) {
			return $this->_data;
		}

		// implement this logic for child class for specific needs
		throw new BadFunctionCallException('Method is not implemented!');
	}
}
