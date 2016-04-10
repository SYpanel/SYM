<?php

namespace App\SYPanel\Ngnix;

class Server extends \ArrayObject implements \ArrayAccess, \Countable, \IteratorAggregate
{

	/**
	 * @var Locations
	 * @since 1.0
	 */
	public $locations;

	/**
	 * @var array
	 * @since 1.0
	 */
	public $directives = [];

	/**
	 * Server constructor.
	 */
	public function __construct()
	{
		$this->locations = new Locations();
	}

	/**
	 * @param $pathOrString
	 *
	 * @return Server[]
	 * @since 1.0
	 */
	public static function fileOrContent($pathOrString)
	{
		$isPath = stristr($pathOrString, DIRECTORY_SEPARATOR) || file_exists($pathOrString);
		if($isPath)
		{
			$scope = Scope::fromFile($pathOrString);
		}
		else
		{
			$scope = Scope::fromString($pathOrString);
		}
		$results = [];
		foreach($scope->getDirectives() as $directive)
		{
			if($directive->getName() === 'server' && $directive->getChildScope() !== null)
			{
				$tmp = new static;
				$tmp->iterateDirectives($directive->getChildScope()->getDirectives());
				$results[] = $tmp;
			}
		}

		return $results;
	}

	/**
	 * @param Directive[] $directives
	 *
	 * @since 1.0
	 */
	protected function iterateDirectives($directives)
	{
		foreach($directives as $directive)
		{
			if($directive->getChildScope() && $directive->getName() !== 'location')
			{
				//recursion...
				$this->iterateDirectives($directive->getChildScope()->getDirectives());
			}
			if($directive->getName() == 'location')
			{
				$this->locations[$directive->getValue()] = Location::fromDirective($directive);
				continue;
			}
			if($directive->getValue())
			{
				$this->directives[$directive->getName()] = $directive->getValue();
			}
		}
	}

	public function getIterator()
	{
		return new \ArrayIterator($this->directives);
	}

	public function offsetExists($key)
	{
		return array_key_exists($key, $this->directives) || array_key_exists($key, $this->locations);
	}

	public function offsetGet($key)
	{
		if(array_key_exists($key, $this->directives))
		{
			return $this->directives[$key];
		}
		if(isset($this->locations[$key]))
		{
			return $this->locations[$key];
		}

		return null;
	}

	public function offsetSet($key, $value)
	{
		$this->directives[$key] = $value;
	}

	public function offsetUnset($key)
	{
		if(array_key_exists($key, $this->directives))
		{
			unset($this->directives[$key]);

			return;
		}
		if(array_key_exists($key, $this->locations))
		{
			unset($this->locations[$key]);
		}
	}

	public function count()
	{
		return count($this->directives);
	}

	public function toFile($path)
	{
		try
		{
			file_put_contents($path, (string)$this);
		}
		catch(\Exception $ex)
		{
			if(stripos($ex->getMessage(), 'Denied')){
				$file = sys_get_temp_dir().DIRECTORY_SEPARATOR.rand(1,999999).time();
				file_put_contents($file,(string)$this);
				sy_exec("mv {$file} {$path}");
				return;
			}

			throw $ex;
		}
	}

	public function __toString()
	{
		$server     = Directive::create('server');
		$childScope = Scope::create();
		foreach($this->directives as $key => $value)
		{
			$childScope->addDirective(Directive::create($key, $value));
		}
		$server->setChildScope($childScope);
		foreach($this->locations as $url => $location)
		{
			if($location === null || !($location instanceof Location))
			{
				throw new \RuntimeException(sprintf('expected %s but got %s', Location::class, gettype($location)));
			}
			$directive          = Directive::create('location', $url);
			$locationChildScope = Scope::create();
			foreach($location as $key => $value)
			{
				if(!is_array($value))
				{
					$locationChildScope->addDirective(Directive::create($key, $value));
					continue;
				}
				foreach($value as $item)
				{
					$locationChildScope->addDirective(Directive::create($key, $item));
				}
			}
			$directive->setChildScope($locationChildScope);
			$childScope->addDirective($directive);
		}

		return (string)Scope::create()->addDirective($server);
	}

	function __get($key)
	{
		return $this[$key];
	}

	function __set($key, $value)
	{
		$this[$key] = $value;
	}

	function __isset($key)
	{
		return isset($this[$key]);
	}

	function __unset($key)
	{
		unset($this[$key]);
	}


}