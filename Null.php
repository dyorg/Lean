<?php
namespace Lean;

class Null
{
	static private $instance;

	public static function singleton()
	{
		if(!isset(self::$instance))	self::$instance = new self;

		return self::$instance;
	}

	private function __construct() {}
	
	final private function __clone() {}

	public function __get($var) { return $this; }

	public function __set($var, $value) { return $this; }

	public function __toString() { return ''; }

	public function __invoke() { return self::singleton(); }
	
	public function __call($var, $args) { return $this; }
}