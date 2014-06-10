<?php
/**
 * @package LeanFramework
 */
namespace Lean;

/**
 * This implementation of the singleton pattern does not conform to the strong definition
 * given by the "Gang of Four." The __construct() method has not be privatized so that
 * a singleton pattern is capable of being achieved; however, multiple instantiations are also
 * possible. This allows the user more freedom with this pattern.
 * credits to ActiveRecord
 * 
 * @package LeanFramework
 */
abstract class Singleton
{
	/**
	 * Array of cached singleton objects.
	 *
	 * @var array
	 */
	private static $instances = array();

	/**
	 * Static method for instantiating a singleton object.
	 *
	 * @return object
	 */
	public static function singleton()
	{
		$class_name = get_called_class();

		if (!isset(self::$instances[$class_name]))
			self::$instances[$class_name] = new $class_name;

		return self::$instances[$class_name];
	}

	protected function __construct() {}
	
	/**
	 * Singleton objects should not be cloned.
	 *
	 * @return void
	 */
	final private function __clone() {}

	/**
	 * Similar to a get_called_class() for a child class to invoke.
	 *
	 * @return string
	 */
	final protected function get_called_class()
	{
		$backtrace = debug_backtrace();
    	return get_class($backtrace[2]['object']);
	}
	
	public function __get($var) {
		return $this->$var();	
	}
	
	//public function __call($method, $args) { return Null::singleton(); }
	public function __call($method, $args) { return null; }

}
?>