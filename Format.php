<?php
namespace Lean;

class Format extends Singleton
{
	static private $instance;
	
	public static function singleton()
	{
		if(!isset(self::$instance))	self::$instance = new self;
		
		return self::$instance;
	}
	
	public function date()
	{
		return Format\Date::singleton();
	}
	
	public function money()
	{
		return Format\Money::singleton();
	}
	
	public function time()
	{
		return Format\Time::singleton();
	}
}