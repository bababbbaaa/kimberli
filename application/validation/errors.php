<?php

namespace rest\validation;

use ArrayAccess;
use InvalidArgumentException;
use Iterator;
use Countable;


class errors implements ArrayAccess, Iterator, Countable {
	private $_errors = [];

	public function toArray() {
		return (array) $this->_errors;
	}

	public static function create(array $errors) {
		$object = new self();

		foreach ($errors as $field => $error) {
			$object->add($field, $error);
		}

		return $object;
	}

	public function add($field, $error) {
		$this->_errors[$field] = $error;

		return $this;
	}

	public function exists($field) {
		return isset($this->_errors[$field]);
	}

	public function current()
	{
		$uid = $this->key();

		return $this->_errors[$uid];
	}

	public function next()
	{
		next($this->_errors);
	}

	public function key()
	{
		return key($this->_errors);
	}

	public function valid()
	{
		return current($this->_errors) !== false;
	}

	public function rewind()
	{
		reset($this->_errors);
	}

	public function offsetExists($offset)
	{
		return $this->exists($offset);
	}

	public function offsetGet($offset)
	{
		return isset($this->_errors[$offset]) ? $this->_errors[$offset] : null;
	}

	public function offsetSet($offset, $value)
	{
		if (empty($value)) {
			return;
		}

		if (null === $offset) {
			throw new InvalidArgumentException('Field name cannot be empty!');
		}

		if (isset($this->_errors[$offset])) {
			throw new InvalidArgumentException("Error for the field '{$offset}' already set!");
		}

		$this->_errors[$offset] = $value;
	}

	public function offsetUnset($offset)
	{
		unset($this->_errors[$offset]);
	}

	public function count()
	{
		return count($this->_errors);
	}
}