<?php

namespace KB\network\http;

use ReflectionClass;

/**
 * HTTP Content Type
 */
abstract class content_type {
	const JSON = 'application/json';
	const XML = 'application/xml';
	const TEXT = 'text/plain';
	const HTML = 'text/html';
	const CSV = 'text/csv';
	const JPG = 'image/jpeg';
	const PNG = 'image/png';
	const GIF = 'image/gif';
	const PDF = 'application/pdf';
	const EXCEL = 'application/vnd.ms-excel';
	const WORD = 'application/vnd.ms-word';
	const BINARY = 'application/octet-stream';

	/**
	 * Cached list of the constants
	 *
	 * @var string[]
	 */
	private static $content_types;

	/**
	 * Check if content type string is a valid and allowed content type
	 *
	 * @param $content_type
	 *
	 * @return bool
	 */
	public static function is_valid($content_type) {
		$content_types = self::get_list();

		return in_array($content_type, $content_types);
	}

	/**
	 * Check is content type text type
	 *
	 * @param string $content_type
	 *
	 * @return bool
	 *
	 * @codeCoverageIgnore
	 */
	public static function is_text($content_type) {
		switch ($content_type) {
			case self::HTML:
			case self::CSV:
			case self::TEXT:
			case self::XML:
			case self::JSON:
				return true;
			default:
				return false;
		}
	}

	/**
	 * Check is content type image format
	 *
	 * @param string $content_type
	 *
	 * @return bool
	 *
	 * @codeCoverageIgnore
	 */
	public static function is_image($content_type) {
		switch ($content_type) {
			case self::JPG:
			case self::PNG:
			case self::GIF:
				return true;
			default:
				return false;
		}
	}

	/**
	 * Check is content type document
	 *
	 * @param string $content_type
	 *
	 * @return bool
	 *
	 * @codeCoverageIgnore
	 */
	public static function is_document($content_type) {
		switch ($content_type) {
			case self::WORD:
			case self::EXCEL:
			case self::PDF:
				return true;
			default:
				return false;
		}
	}

	/**
	 * Check is content type binary format
	 *
	 * @param string $content_type
	 *
	 * @return bool
	 *
	 * @codeCoverageIgnore
	 */
	public static function is_binary($content_type) {
		switch ($content_type) {
			case self::BINARY:
				return true;
			default:
				return false;
		}
	}

	/**
	 * Get list of all content types announced in this class
	 *
	 * @return array|string[]
	 */
	public static function get_list() {
		if (!isset(self::$content_types)) {
			// build a list of all allowed content types from constants of the class
			$class = new ReflectionClass(__CLASS__);
			self::$content_types = $class->getConstants();
		}

		return self::$content_types;
	}
}
