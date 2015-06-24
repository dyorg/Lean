<?php
namespace Lean;

use Lean\Http\Request;

class Launch
{
	private $action_method_to_launch;
	
	private $path_class_to_launch;
	
	static public function instance()
	{
		return new self;
	}
	
	public function run()
	{
		$this->process();		
	}
	
	private function dispache($module, $controller, $method, array $params = null)
	{
		if(empty($module)) {
			$module = Route::get_route_module_default();
		}
		
		if(empty($controller)) {
			$controller = Route::get_route_controller_default();
		}
		
		if(empty($method)) {
			$method = 'index';
		}
		
		$class = Config::get_application_path() . "\\" . Config::get_module_prefixe() . $module . "\\controllers\\" . $controller . "Controller";

        if ($params) {
            $num_param = 0;
            $set_params = rtrim(str_repeat('$params[$num_param++],', count($params)), ',');
        }
        else {
            $set_params = '';
        }

        eval($class.'::singleton()->'.$method.'('.$set_params.');');
	}
	
	private function get_info()
	{
		/* verifica url com index.php */
		preg_match('/(.*)\/index.php(.*)/', $_SERVER["PHP_SELF"], $matches);

		/* relative uri base */
		$relative_uri_base = $matches[1];

		/* route path information */
		$path_info = $matches[2];

		$url = Request::singleton()->getUrl();

		/* verifica url sem index.php */
		if(!preg_match('/index.php/', $url->getPath()))	{
			$path_info = str_replace($relative_uri_base, '', $url->getPath());
		}
		
		/* define url root */
		define(strtoupper(Config::get_root_path()), $relative_uri_base.'/');

		$path_info = trim($path_info, '/');

		return $path_info;
	}
	
	private function process()
	{		
		
		$info = self::get_info();		

		/*
		 * rotas
		 */
		if($routes = Route::get_routes())
		{
			if(array_key_exists($info, $routes))
			{
				$route = $routes[$info];
				
				if(is_object($route))
				{
					$route();
				}
				elseif(is_array($route))
				{
					$module = isset($route['module']) ? $route['module'] : NULL;
					$controller = isset($route['controller']) ? $route['controller'] : NULL;
					$method = isset($route['method']) ? $route['method'] : NULL;
                    $params = isset($route['params']) ? (array) $route['params'] : NULL;
					
					$this->dispache($module, $controller, $method, $params);

				}

				return true;
			}
		}
		
		
		/*
		 * rota padrão caso info seja vazio 
		 */
		if(empty($info)) 
		{
			$route_default = Route::get_route_default();
			if(!empty($route_default)) $info = $route_default; 
		}
		

		/*
		 * explode info
		 */
		if(isset($info)) 
		{
			$url_string =  explode('/', strtolower(trim($info, '/')));
			if($url_string[0] == '') $url_string = null;
		}
	
		
		/*
		 * valida e dispara método
		 */
		$module = isset($url_string[0]) ? $url_string[0] : null;
	
		$controller = isset($url_string[1]) ? (str_replace(' ', '', ucwords(str_replace('-', ' ', $url_string[1])))) : null;		
		
		$method = isset($url_string[2]) ? str_replace('-', '_', $url_string[2]) : null;
		
		$this->dispache($module, $controller, $method);
		
	}
	
	
}