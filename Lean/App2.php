<?php
namespace Lean;

class App2
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