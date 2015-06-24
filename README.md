# Lean PHP Framework

Lean Framework is a micro PHP framework (~40KB). Modern frameworks are powerfull but so much complicated,
the mostly of resources you never gonna use, some functionality sounds good but if you don't really need it's a
only waste of time.
With Lean you can construct fast e lightweight softwares, with follows resources:

* Structure MVC, REST or both;
* Requests;
* Routes (automatic or custom);
* Namespaces;
* Class autoload;
* PHP code hidden;
* Basic template engine;

### Requirement

PHP 5.3+

### Basic structure

```php
-- rootdir
    -- app
        -- main (module)
            -- controllers
                -- HomeController.php
            -- models
            -- views
                -- home
                    -- index.phtml
        -- Bootstrap.php
        -- Routes.php
    -- public_html
        -- css
        -- js
        -- img
        -- index.php
        -- .htaccess
    -- vendor
        -- composer
        -- lean
        -- autoload.php
```

Create into your rootdir teh follows directories:

- **app**: You will write all your application php into app directory (controllers, models, views and configs), this way your application not stay exposed.

- **public_html**: Into public_html directory we have only **index.php** as file .php. You can put all yours public files, like css, javascripts, images, fonts, etc.

- **vendor**: Composer will create it and copy our lib to lean directory.

## Getting started

### Instalation

Install via [Composer](http://getcomposer.org "Composer")

```bash
composer require lean/lean
```

### Easy configuration

create file **index.php** into public_html directory

> Into index.php we have only one line, all of rest application php keep safe into app directory.

```php
<?php require_once '../app/Bootstrap.php'; ?>
 ```

create file **.htaccess** into public_html to custom urls

> Don't forget enable mod_rewrite on apache

```bash
RewriteEngine On
RewriteCond %{REQUEST_FILENAME} -s [OR]
RewriteCond %{REQUEST_FILENAME} -l [OR]
RewriteCond %{REQUEST_FILENAME} -d
RewriteRule ^.*$ - [NC,L]
RewriteRule ^.*$ index.php [NC,L]
```

create file **Bootstrap.php** into app directory

```php
<?php
require_once '../vendor/autoload.php';

/**
 * errors - use E_ALL only in development
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
 * Lean has some great Date and Hour classes, so keep it configured to use them
 */
date_default_timezone_set('America/Sao_Paulo');
setlocale(LC_ALL, 'pt_BR', 'pt_BR.iso-8859-1', 'pt_BR.utf-8', 'portuguese');

/**
 * init lean framework
 */
Lean\Launch::instance()->run();
```

Well done! It's all configuration necessary to run like a pro.


### Hello world! and first controller

regardless of whether their application is rest or not, I think is a good ideia keep your access logic always into controllers,
into Routes.php you keep only routes ;)

```php
<?php
namespace app\main\controllers;

class IndexController extends \Lean\App
{
	public function index() {
		echo 'Hello World!';
	}
}
```

It's work, access in your browser
http://localhost/rootdir/public_html

Remember, in your site type only **www.your-domain.com**, everything else php is hidden.


### Automatic route controller

http://localhost/rootdir/public_html/$1/$2/$3

$1 : Module - if not informed, use main module (main directory)
$2 : Controller - if not informed, instance indexController class
$1 : Method - if not informed, call index method

```php
<?php
namespace app\main\controllers;

class ProductController extends \Lean\App
{
    public function index() {
        echo 'About Product'
    }

	public function festures_list() {
		echo 'Product list';
	}

	public function buy_action() {
	    echo 'Processing your order...'
	}
}
```

To ProductController example, the result is:

uri: "/main/product" // result is 'About Product!'
uri: "/main/product/index" // result is 'About Product!'
uri: "/main/product/features-list" // result is 'Product list!'
uri: "/main/product/features_list" // result is 'Product list!'
uri: "/main/product/buy" // result is 'Processing your order...'
uri: "/main/product/buy-action" // result is 'Processing your order...'
uri: "/main/product/buy_action" // result is 'Processing your order...'

To IndexController example, the result is:

uri: "/" // result is 'Hello World!'
uri: "/main" // result is 'Hello World!'
uri: "/main/index" // result is 'Hello World!'
uri: "/main/index/index" // result is 'Hello World!'


## Custom routes

### Config routes file

In **app/Bootstrap.php** add file routes before init Lean

```php
...

/**
 * routes file
 */
Lean\Route::set_routes_path('app/Routes.php');

/**
 * init lean framework
 */
Lean\Launch::instance()->run();
```

### Basic route

create file **Routes.php** into app directory

```php
<?php
use Lean\Route;

Route::set('foo/bar', function() {
	echo 'Hi';
});
```

Url: http://your-site.com/foo/bar // result is 'Hi'

### Route to method in controller

```php
<?php
use Lean\Route;

Route::set('product', array(
	'controller' => 'product',
));

Route::set('resources', array(
	'controller' => 'product',
	'method' => 'resources_list'
));

Route::set('learn-more-about-product', array(
	'controller' => 'product',
	'method' => 'resources_list'
));
```

Url: http://your-site.com/product // result is 'About Product'
Url: http://your-site.com/resources // result is 'Product List'
Url: http://your-site.com/learn-more-about-product // result is 'Product List'

### Route to different module

```php
<?php
use Lean\Route;

Route::set('checkout', array(
    'module' => 'api'
	'controller' => 'payment',
));
```

### Simple route alias

```php
Route::alias('old-page-about-product', 'product');
```

### Multiple route alias

```php
Route::alias(array('old-page-about-product', 'foo', 'bar'), 'product');
```

## Request object

```php
<?php
namespace app\foo\controllers;

class ProductController extends \Lean\App
{
	public function index()
	{		
		/**
		 * get HTTP $_REQUEST
		 */
		$request = $this->request();
		$name = $request->name;
		$category = $request->category;
		$price = $request->price;
	
	
		/**
		 * get only $_POST
		 */
		$request = $this->request()->post();		

		
		/**
		 * get only $_GET
		 */
		$request = $this->request()->get();		

		
		/**
		 * get only $_FILE
		 */		 
		 $request = $this->request()->file();		
		 
		 
		/*
		 * your action here
		 */
	}
}
```

## Using Views

Create followings views **index.phtml** and **edit.phtml** into views

```php
-- app
	-- foo (module)
		-- controllers
			-- ProductController.php
		-- models
		-- views
			-- product
				-- index.phtml
				-- edit.phtml
			-- layout
				-- header.phtml
				-- footer.phtml
				-- template.html
```

Create **template.phtml** in layout directory, you can include header and footer parts here

```html
<html>
<head>
	<title>My new app</title>
</head>
<body>

	<? $this->app->view->render('layout.header') ?>

	<div id="container">
		<!--
		-- content page setted in controller will be render here
		-->
		<? $this->app->view->make('content') ?>
	</div>
	
	<? $this->app->view->render('layout.footer') ?>
	
</body>
</html>
```

Controllers shows yours views

```php
<?php
namespace app\foo\controllers;

class ProductController extends \Lean\App
{
	public function index()
	{	
		/**
		 * set the product/index.phtml to be render
		 */
		$this->view()->set('content', 'index');
		
		/*
		 * render the template
		 */
		$this->view()->render('layout.template');
	}
	
	public function edit()
	{	
		/**
		 * this render file "../views/product/edit.phtml"
		 */
		$this->view()->set('content', 'edit');
		
		$this->view()->render('layout.template');
	}
}
```

## License

Lean is released under MIT public license.

http://www.opensource.org/licenses/MIT

Copyright (c) 2014, Dyorg Almeida
<dyorg.almeida@gmail.com>