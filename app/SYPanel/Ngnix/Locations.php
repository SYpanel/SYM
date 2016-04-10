<?php

namespace App\SYPanel\Ngnix;

class Locations extends \ArrayObject implements \ArrayAccess, \Countable, \IteratorAggregate {

	protected $actualLocations = [];

	public function getIterator() {
		return new \ArrayIterator($this->actualLocations);
	}


	public function offsetExists($key) {
		return array_key_exists($key, $this->actualLocations);
	}


	public function offsetGet($key) {
		if ($this->offsetExists($key)) {
			return $this->actualLocations[$key];
		} else {
			return $this->actualLocations[$key] = new Location();
		}
	}


	public function offsetSet($key, $value) {
		$this->actualLocations[$key] = $value;
	}


	public function offsetUnset($key) {
		unset($this->actualLocations[$key]);
	}

	public function count() {
		return count($this->actualLocations);
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