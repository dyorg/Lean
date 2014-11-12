<?php
namespace Lean\Http;

use Lean\Singleton;

class Request extends Singleton 
{
	const METHOD_DELETE = 'DELETE';
	const METHOD_GET = 'GET';
	const METHOD_HEAD = 'HEAD';
	const METHOD_OPTIONS = 'OPTIONS';
	const METHOD_PATCH = 'PATCH';
	const METHOD_POST = 'POST';
	const METHOD_PUT = 'PUT';
	
	static private $instance;
	
	public function __construct($http_method) {
		foreach ($http_method as $key => $value) {
			$this->{$key} = $value;
		}
	}
	
	public static function instance() {
		if(!isset(self::$instance))	self::$instance = new self($_REQUEST);
		return self::$instance;
	}
	
	public function decode($to = 'ISO-8859-1', $from = 'UTF-8') {
		foreach ($this as $key => $value) {
			$this->$key = mb_convert_encoding($value, $to, $from);
		}
		
		return $this;
	}
	
	public function post() {
		return POST::singleton();
	}
	
	public function get() {
		return GET::singleton();
	}
	
	public function delete() {
		return POST::singleton();
	}
	
	public function put() {
		return POST::singleton();
	}
	
	public function head() {
		return POST::singleton();
	}
}

class POST extends Request 
{
	public function __construct() {
		parent::__construct($_POST);
	}
}

class FILES extends Request 
{
	public function __construct() {
		parent::__construct($_FILES);
	}
}

class GET extends Request 
{
	public function __construct() {
		parent::__construct($_GET);
	}
}

