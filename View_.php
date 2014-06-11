<?php
namespace Lean;

class View
{
	private $footer = array();
	
	private $header = array();
	
	private $view = array();
	
	private $page = array();
	
	public $lean;
	
	static private $instance;
	
	static private $extension_default = '.phtml'; 
	
	static private $footer_default = null;
	
	static private $header_default = null;
	
	
	public static function singleton($classname)
	{
		if(!isset(self::$instance))	self::$instance = new self($classname);
	
		return self::$instance;
	}
	
	public static function set_extension_default($extension)
	{
		self::$extension_default = $extension;
	}
	
	/**
	 * Set a default page footer 
	 * 
	 * <code>
	 * View::set_footer_default('app/main/views/layout/footer.phtml');
	 * View::set_footer_default('app/layout/footer.phtml');
	 * </code>
	 * 
	 * @param string $path_header Full file path 
	 */
	public static function set_footer_default($path_footer)
	{
		self::$footer_default = $path_footer;
	}
	
	/**
	 * Set a default page header 
	 * 
	 * <code>
	 * View::set_header_default('app/main/views/layout/header.phtml');
	 * View::set_header_default('app/layout/header.phtml');
	 * </code>
	 * 
	 * @param string $path_header Full file path 
	 */
	public static function set_header_default($path_header)
	{
		self::$header_default = $path_header;
	}
	
	public static function unset_footer_default()
	{
		self::$footer_default = null;
	}
	
	public static function unset_header_default()
	{
		self::$header_default = null;
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
		 * render header page
		 */
		$this->render_header();
		
		/**
		 * render content page
		 */
		$this->set_options_views('view', $options);
		$this->render_exe('view');
		
		/**
		 * render footer page
		 */
		$this->render_footer();
	}

	
	public function render2($options = 'index')
	{
		/**
		 * render content page
		*/
		$this->render2 = array();
		$this->set_options_views('render2', $options);
		$this->render_exe('render2');
		
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
	
	public function redirect($url) 
	{
		header('location:' . $url); die();
	}
		
	private function render_exe($var = 'view')
	{	
		include_once $this->{$var}['app'] . DIRECTORY_SEPARATOR . $this->{$var}['module'] . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . $this->{$var}['directory'] . DIRECTORY_SEPARATOR . $this->{$var}['page'] . $this->{$var}['extension'];
	}
	
	private function render_footer()
	{
		if(!empty($this->footer))
		{
			$this->render_exe('footer');
		}
		elseif (!is_null(self::$footer_default))
		{
			include_once self::$footer_default;
		}
	}
	
	private function render_header()
	{
		if(!empty($this->header))
		{
			$this->render_exe('header');
		}
		elseif (!is_null(self::$header_default))
		{
			include_once self::$header_default;
		}
	}
	
	public function render_page($options = 'index')
	{
		$this->set_options_views('page', $options);
		
		$this->render_exe('page');
	}
	
	public function set_footer($options = 'footer')
	{
		$this->set_options_views('footer', $options);
	}
	
	public function set_header($options = 'header')
	{
		$this->set_options_views('header', $options);
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