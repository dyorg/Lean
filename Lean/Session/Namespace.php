<?php

class Myapp_Session_Namespace extends Myapp_Session
{
	private $namespace;
	
	public function __construct($namespace = null)	
	{
		if (is_null($namespace)) $namespace = APPLICATION_ENV;
		
		$this->namespace = 'NAMESPACE_'.$namespace;
		
		parent::__construct();
	}
	
	static public function session($namespace)
	{
		return new Myapp_Session_Namespace($namespace);
	}
	
	public function getAttribute($key = null)
	{
		if ($key)
		{
			$ns = parent::getAttribute($this->namespace);
		
			if ($ns === null) return null;
			
			return $ns[$key];
		}
		else 
		{
			return self::session($this->namespace);
		}
	}
	
	public function setAttribute($key, $value)
	{
		parent::setAttribute($this->namespace,  array($key => $value));
	}
	
	public function unsetAttribute($key)
	{
		parent::setAttribute($this->namespace,  array($key => null));
	}
	
	public function isNamespace()
	{
		parent::isSession($this->namespace);
	}
	
	public function clear()
	{
		parent::unsetAttribute($this->namespace);
	}	
	
	public function destroy()
	{
		$this->clear();
	}
}