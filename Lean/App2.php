<?php
namespace Lean;

class App 
{					
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

	public function route()
	{
		
	}
}