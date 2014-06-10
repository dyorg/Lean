<?php

namespace Lean;

class Config
{
	final public function __construct() {}
	
	private static $root_path = 'webroot';
	
	private static $application_path = '\app';
	
	private static $module_prefixe = '';
	
	private static $route_controller_default = 'Index';
	
	private static $route_module_default = 'main';
	
	private static $route_default = '';
	
	private static $routes_path = null;
	
	public static function set_application_path($application_path)
	{
		self::$application_path = $application_path;
	}
	
	public static function get_application_path()
	{
		return self::$application_path;
	}
	
	public static function set_module_prefixe($module_prefixe)
	{
		self::$module_prefixe = $module_prefixe;
	}
	
	public static function get_module_prefixe()
	{
		return self::$module_prefixe;
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
	
	public static function set_routes_path($routes)
	{
		self::$routes_path = $routes;
	}
	
	public static function get_routes_path()
	{
		return self::$routes_path;
	}
	
	public static function get_routes()
	{
		if(self::$routes_path)
			return include_once self::$routes_path;
		else
			return array();
	}
	
	public static function set_root_path($path)
	{
		self::$root_path = $path;
	}
	
	public static function get_root_path()
	{
		return self::$root_path;
	}
}