<?php
namespace Lean;

/**
 * 
 * @author	Dyorg Almeida
 * @since	21/10/2014
 *
 */
class Mvc extends App 
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
	
	
	public function view()
	{
		return View::singleton(get_class($this));
	}
}