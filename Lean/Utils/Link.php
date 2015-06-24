<?php

class Myapp_Element_Link
{
	static private $styles = array();
	
	static private $scripts = array();
	
	static public function addScript($path)
	{
		self::$scripts[]= "<script language=\"javascript\" src=\"".ROOT.$path."\" type=\"text/javascript\" ></script>";
	}
	
	static public function addStyle($path, $media = 'all')
	{
		self::$styles[] = "<link rel=\"stylesheet\" href=\"".ROOT.$path."\" type=\"text/css\" media=\"$media\">";
	}	
	
	static public function loadScripts()
	{
		echo implode('', self::$scripts);
	}
	
	static public function loadStyles()
	{
		echo implode('', self::$styles);
	}	
	
	static public function image($path, $alt = null, $title = null, $class= null)
	{
		echo "<img alt=\"$alt\" title=\"".$title."\" src=\"".ROOT.$path."\" class=\"$class\">";
	}
	
	static public function loadJQuery($version = '1.7', $env = null)
	{
		if(APPLICATION_ENV == 'development' || $env == 'development')
		{
			$output = "<script src=\"".ROOT."/scripts/jquery/jquery-$version.min.js\" type=\"text/javascript\"></script>";
		}
		else 
		{
			$output = "<script type=\"text/javascript\" src=\"https://ajax.googleapis.com/ajax/libs/jquery/$version/jquery.min.js\"></script>";
		}
		
		print $output;
	}
}