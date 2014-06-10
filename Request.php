<?php
namespace Lean;

use Lean\Request\Files;

class Request extends Request\Http
{	
	static private $instance;
	
	public static function singleton()
	{
		if(!isset(self::$instance))	self::$instance = new self($_REQUEST);
	
		return self::$instance;
	}
	
	public function post() { return Request\Post::singleton(); }
	
	public function get() { return Request\Get::singleton(); }
	
	public function files() { return Request\Files::singleton(); }
	
}





