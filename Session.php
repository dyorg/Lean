<?php
namespace Lean;

class Session
{	
	static private $instance;
	
	const NAMESESSION_DEFAULT = 'DEFAULT';
	
	private $namesession;	
	
	static public function getSession($namesession = self::NAMESESSION_DEFAULT)
	{
		if(!isset(self::$instance))	self::$instance = new self;
	
		self::$instance->startSession();
		
		self::$instance->setNamesession($namesession);
		
		return self::$instance;
	}
	
	private function __construct() { }
	
	public function __destruct()
	{
		$this->closeSession();
	}
	
	private function startSession()
	{
		if (!isset($_SESSION))
		{
			session_start();
		}
	}
	
	public function closeSession()
	{
		if (!isset($_SESSION))
		{
			session_write_close();
		}
	}
	
	public function clear()
	{
		$this->destroy();
	}
	
	public function destroy()
	{
		unset($_SESSION[$this->namesession]);
		return true;
	}
	
	public function destroyAll()
	{
		if (isset($_SESSION)) session_destroy();
		return true;
	}
	
	public function getAttr($key = NULL)
	{
		if ($key === null)
		{
			return $_SESSION[$this->namesession];
		}
		else
		{
			if($this->isSession($key))
			{				
				return $_SESSION[$this->namesession][$key];
			}
			else
			{
				return null;
			} 
		}
	}
	
	public function isSession($key)
	{
		if(isset($_SESSION[$this->namesession][$key])) {
			return true;
		}
		else {
			return false;
		}
	}
	
	public function setAttr($key, $value)
	{
		$_SESSION[$this->namesession][$key] = $value;
	}
	
	public function unsetAttr($key)
	{
		unset($_SESSION[$this->namesession][$key]);
	}
	
	public function getNamesession()
	{
		return $this->namesession;
	}
	
	public function setNamesession($namesession)
	{
		$this->namesession = $namesession;
	}
}
