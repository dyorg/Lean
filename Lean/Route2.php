<?php
namespace Lean;

class Route
{
	static private $instance;

	public static function singleton()
	{
		if(!isset(self::$instance))	self::$instance = new self;

		return self::$instance;
	}
	
	private static $route_controller_default = 'Index';
	
	private static $route_module_default = 'main';
	
	private static $route_default = '';
	
	private static $routes_path = null;
	
	private static $routes = array();

	
	public function register($uri, $action)
	{
		$this->routes[ Request::ANY ][ $uri ] = $action;
	}
	
	public function any($uri, $action)
	{
		$this->routes[ Request::ANY ][ $uri ] = $action;
	}

	public function get($uri, $action)
	{
		$this->routes[ Request::GET ][ $uri ] = $action;
	}
	
	public function delete($uri, $action)
	{
		$this->routes[ Request::DELETE ][ $uri ] = $action;
	}
	
	public function post($uri, $action)
	{
		$this->routes[ Request::POST ][ $uri ] = $action;
	}
	
	public function put($uri, $action)
	{
		$this->routes[ Request::PUT ][ $uri ] = $action;
	}
	
	
	
	/**
	 * @example {
	 * Route::alias('home', 'index');
	 * Route::alias(array('home', 'main'), 'index');
	 * }
	 * 
	 * @param (uri or array) $from
	 * @param uri $to
	 * @throws RouteException
	 */
	public function alias($from, $to)
	{
		if(!isset(self::$routes[$to])) throw new RouteException("route $to indefined");
		
		if (is_array($from)) {
			
			foreach ($from as $f) {
				
				self::set($f, self::$routes[$to]);
				
			}
			
		} else {
			
			self::set($from, self::$routes[$to]);
			
		}
	}
	
	public static function set_routes_path($path)
	{
		self::$routes_path = $path;
		
		include_once $path;
	}
	
	public static function get_routes_path()
	{
		return self::$routes_path;
	}
	
	public static function get_routes()
	{
		return self::$routes;
	}
	
	public static function set_route_controller_default($controller)
	{
		self::$route_controller_default = $controller;
	}
	
	public static function get_route_controller_default()
	{
		return self::$route_controller_default;
	}
	
	public static function set_route_module_default($module)
	{
		self::$route_module_default = $module;
	}
	
	public static function get_route_module_default()
	{
		return self::$route_module_default;
	}
	
	public static function set_route_default($route)
	{
		self::$route_default = $route;
	}
	
	public static function get_route_default()
	{
		return self::$route_default;
	}

}

class RouteException extends \Exception { }