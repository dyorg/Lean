<?php
namespace Lean;

use Lean\Request\Files;

class Request2 extends Request\Http
{	
	const ANY 	= 'any';
	const DELETE = 'delete';
	const GET 	= 'get';
	const POST 	= 'post';
	const PUT 	= 'put';
	
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





