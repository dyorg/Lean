<?php
namespace Lean;

class View
{
	private $view = array();
	
	public $lean;
	
	static private $instance;
	
	static private $extension_default = '.phtml'; 
	
	public static function singleton($classname)
	{
		if(!isset(self::$instance))	self::$instance = new self($classname);
	
		return self::$instance;
	}
	
	public static function set_extension_default($extension)
	{
		self::$extension_default = $extension;
	}

	private function __construct($classname) 
	{			
		if ($lastnspos = strripos($classname, '\\')) 
		{
			$namespace = substr($classname, 0, $lastnspos);
			
			$classname = substr($classname, $lastnspos + 1);
			
			$this->view['directory'] = $this->view['class'] = strtolower(str_replace('Controller', '', $classname));
			
			$namespace = explode('\\', $namespace);
			
			$this->view['app'] = $namespace[0];
			
			$this->view['module'] = $namespace[1];
		}		
		
		$this->lean = $this->app = App::singleton();
	}
		
	public function render($options = 'index')
	{
		/**
		 * render content page
		*/
		$this->temp = array();
		$this->set_options_views('temp', $options);
		$this->make('temp');
		
		return $this;
	}
	
	public function set($name, $options = 'index')
	{
		$this->$name = array();
		$this->set_options_views($name, $options);
		return $this;
	}
	
	private function set_options_views($var, $options)
	{				
		$this->{$var}['app'] = $this->view['app'];
		$this->{$var}['module'] = $this->view['module'];
		$this->{$var}['directory'] = $this->view['directory'];
		$this->{$var}['extension'] = self::$extension_default;
		
		if(is_string($options)) 
		{				
			$options = array_reverse(explode('.', $options));
			
			$pos = array('page', 'directory', 'module', 'app');
			
			foreach ($options as $key => $option) 
			{	
				$this->{$var}[$pos[$key]] = $option;
			}
		}
		elseif(is_array($options))
		{
			if (isset($options['page'])) {
				$this->{$var}['page'] = $options['page'];
			}
			
			if (isset($options['app'])) {
				$this->{$var}['app'] = $options['app'];
			}
			
			if (isset($options['module'])) {
				$this->{$var}['module'] = $options['module'];
			}
			
			if (isset($options['directory'])) {
				$this->{$var}['directory'] = $options['directory'];
			}
			
			if (isset($options['extension'])) {
				$this->{$var}['extension'] = $options['extension'];
			}
		}
	}
			
	public function make($name)
	{
		include_once $this->{$name}['app'] . DIRECTORY_SEPARATOR . $this->{$name}['module'] . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . $this->{$name}['directory'] . DIRECTORY_SEPARATOR . $this->{$name}['page'] . $this->{$name}['extension'];
	}
		
	public function get_property($name = null)
	{		
		if(array_key_exists($name, $this->view)) 
		{
			return $this->view[$name];
		} 
		else 
		{
			return null;
		}
	}
	
	public function __get($var) { return Null::singleton(); }
}