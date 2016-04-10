<?php

namespace App\SYPanel\Ngnix;

class Location implements \ArrayAccess, \Countable, \IteratorAggregate {

	protected $data = [];

	public static $arrayFields = [
		'fastcgi_param',
	];

	public static function fromDirective(Directive $directive) {
		$results = new static;
		foreach ($directive->getChildScope()->getDirectives() as $subDirective) {
			$results[$subDirective->getName()] = $subDirective->getValue();
		}

		return $results;
	}

	public function getIterator() {
		return new \ArrayIterator($this->data);
	}


	public function offsetExists($key) {
		return array_key_exists($key, $this->data);
	}


	public function offsetGet($key) {
		return $this->offsetExists($key) ? $this->data[$key] : null;
	}


	public function offsetSet($key, $value) {
		if (!in_array($key, static::$arrayFields)) {
			$this->data[$key] = $value;

			return;
		}
		$this->data[$key][] = $value;
	}


	public function offsetUnset($key) {
		unset($this->data[$key]);
	}


	public function count() {
		return count($this->data);
	}

	function __get($key) {
		return $this[$key];
	}

	function __set($key, $value) {
		$this[$key] = $value;
	}

	function __isset($key) {
		return isset($this[$key]);
	}

	function __unset($key) {
		unset($this[$key]);
	}
}