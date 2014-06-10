<?php
namespace Lean;

class App extends Singleton 
{				
	/**
	 * Verify either action is a method pre defined
	 * 
	 * <exemples>
	 * 
	 * $_REQUEST[action] = 'test'; 
	 * $this->test_action();
	 * 
	 * $_POST[action] = 'hello'; 
	 * $this->hello_action();
	 * 
	 * </exemples>
	 */
	public function __construct()
	{			
		if(!empty($this->request()->action))
		{
			$method_action = $this->request()->action . '_action';
			
			if(method_exists($this, $method_action))
			{
				$this->{$method_action}();
			}
		}
	}
	
	public function auth() {}
	
	public function format() 
	{ 
		return Format::singleton(); 
	}
	
	public function logger() 
	{	
		return Logger::singleton();
	}
	
	public function request() 
	{	
		return Request::singleton(); 
	}
	
	public function router() {}
	
	public function session() {}
	
	public function view() 
	{
		return View::singleton(get_class($this));
	}
}