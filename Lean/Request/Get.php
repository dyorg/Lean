<?php
namespace Lean\Request;

class Get extends Http
{
	static private $instance;

	public static function singleton()
	{
		if(!isset(self::$instance))	self::$instance = new self($_GET);

		return self::$instance;
	}
}