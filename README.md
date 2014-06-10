# Lean Framework PHP

Lean Framework is a tiny PHP framework, modern frameworks are powerfull but so much complicated.
With Lean I can construct apps really fast, using mvc, namespaces, autoloader, routes and more.

## Basic structure 

```php
-- app
	-- main (module)
		-- controllers
			-- BasicController.php
		-- models
		-- views
			-- basic
				-- index.phtml
	-- secondary (other module)
		-- controllers
		-- models
		-- views
-- public_html
	-- css
	-- js
	-- img
	-- index.php
	-- .htaccess
-- settings
	-- Bootstrap.php
-- vendor
	-- Lean
	-- Symfony (Symfony/Component/ClassLoader/*)
	-- autoloader.php
```

## Easy configuration

create file "index.php" into public_html

```php
<?php require_once '../settings/Bootstrap.php'; ?>
 ```

create file ".htaccess" into public_html to custom urls

```bash
RewriteEngine On
RewriteCond %{REQUEST_FILENAME} -s [OR]
RewriteCond %{REQUEST_FILENAME} -l [OR]
RewriteCond %{REQUEST_FILENAME} -d
RewriteRule ^.*$ - [NC,L]
RewriteRule ^.*$ index.php [NC,L]
```

create file "autoloader.php" into vendor, I'm using the Symfony Autoloader (Symfony/Component/ClassLoader/*)

```php
<?php

require_once __DIR__ . '/Symfony/Component/ClassLoader/UniversalClassLoader.php';

$loader = new Symfony\Component\ClassLoader\UniversalClassLoader();
$loader->registerNamespaces(array(
	'Lean'     => __DIR__,
    'Symfony'  => __DIR__,
));

$loader->useIncludePath(true);
$loader->register();
```

create file "Bootstrap.php" into settings

```php
<?php
require_once '../vendor/autoloader.php';


/**
 * errors
 */
error_reporting(E_ALL);


/**
 * include path
 */
set_include_path(
	PATH_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 
	PATH_SEPARATOR . get_include_path());


/** 
 * locale e zone 
 */
date_default_timezone_set('America/Sao_Paulo');
setlocale(LC_ALL, 'pt_BR', 'pt_BR.iso-8859-1', 'pt_BR.utf-8', 'portuguese');


/**
 * init lean framework
 */
Lean\Launch::instance()->run();
```

## Create a controller

It's work, access in your browser 
http://localhost/lean_project/public_html

```php
<?php
namespace app\main\controllers;

class IndexController extends \Lean\App
{
	public function index()
	{		
		echo 'HELLO WORLD';
	}
}
```

Call non-default module, controller and method, type in your browser
http://localhost/lean_project/public_html/foo/product/do-something

```php
<?php
namespace app\foo\controllers;

class ProductController extends \Lean\App
{
	public function do_something()
	{		
		/*
		 * your action here
		 */
	}
}
```

## using routes

add into bootstrap before launch Lean

```php
...

/*
 * routes
 */
Lean\Route::set_routes_path('settings/Routes.php');

/**
 * init lean framework
 */
Lean\Launch::instance()->run();
```

### Basic route

create file "Routes.php" into settings

```php
<?php
use Lean\Route;

Route::set('foo/bar', function() {
	echo 'Hi';
});
```

### Route to method in controller

```php
<?php
use Lean\Route;

Route::set('product/do', array(
	'module' => 'basic', 
	'controller' => 'product',
	'method' => 'do_something'
));
```

### Route to method in controller, same result as above but with clousure and call controller manually

```php
<?php
use Lean\Route;

Route::set('product/do', function() {
	new app/basic/controllers/ProductController::singleton->do_something();
});
```

### Simple alias

```php
<?php
Route::alias('do-something', 'product/do');
```

### Multiple alias

```php
<?php
Route::alias(array('do-something', 'do-something2', 'foo', 'bar'), 'product/do');
```