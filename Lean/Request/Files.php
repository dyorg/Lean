<?php
namespace Lean\Request;

class Files extends Http
{
	static private $instance;

	public static function singleton()
	{
		if(!isset(self::$instance))	self::$instance = new self($_FILES);

		return self::$instance;
	}
}