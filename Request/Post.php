<?php
namespace Lean\Request;

class Post extends Http
{
	static private $instance;

	public static function singleton()
	{
		if(!isset(self::$instance))	self::$instance = new self($_POST);

		return self::$instance;
	}
}