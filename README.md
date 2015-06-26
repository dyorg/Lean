# Lean PHP Framework

Lean PHP Framework is a micro framework PHP (~40KB). Modern frameworks are powerfull but so much complicated,
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
* Date and Time manipulation;
* Easy configuration;

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

- `app`: You will write all your application php into app directory (controllers, models, views and configs), this way your application not stay exposed.

- `public_html`: Into public_html directory we have only **index.php** as file .php. You can put all yours public files, like css, javascripts, images, fonts, etc.

- `vendor`: Composer will create it and copy our lib to lean directory.

## Getting started

### Instalation

Install via [Composer](http://getcomposer.org "Composer")

```bash
composer require lean/lean
```

### Easy configuration

create file `index.php` into **public_html** directory

> Into index.php we have only one line, all of rest application php keep safe into app directory.

```php
<?php require_once '../app/Bootstrap.php'; ?>
 ```

create file `.htaccess` into **public_html** directory to custom urls works

> Don't forget enable mod_rewrite on apache

```bash
RewriteEngine On
RewriteCond %{REQUEST_FILENAME} -s [OR]
RewriteCond %{REQUEST_FILENAME} -l [OR]
RewriteCond %{REQUEST_FILENAME} -d
RewriteRule ^.*$ - [NC,L]
RewriteRule ^.*$ index.php [NC,L]
```

Create file `Bootstrap.php` into **app** directory

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

Regardless of whether their application is rest or not, I think is a good ideia keep your access logic always into controllers,
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

> Remember, in your site type only **www.your-domain.com**, everything else php is hidden.


### Automatic route controller

http://localhost/rootdir/public_html/`$1`/`$2`/`$3`

* `$1` : Module - if not informed, use main module (main directory)
* `$2` : Controller - if not informed, instance indexController class
* `$3` : Method - if not informed, call index method

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

> uri `/main/product` result is **About Product!**   
> uri `/main/product/index` result is **About Product!**  
> uri `/main/product/features-list` result is **Product list!**  
> uri `/main/product/features_list` result is **Product list!**  
> uri `/main/product/buy` result is **Processing your order...**  
> uri `/main/product/buy-action` result is **Processing your order...**  
> uri `/main/product/buy_action` result is **Processing your order...**  

To IndexController example, the result is:

> uri `/` result is **Hello World!**  
> uri `/main` result is **Hello World!**  
> uri `/main/index` result is **Hello World!**  
> uri `/main/index/index` result is **Hello World!**  


## Custom routes

### Config routes file

In `app/Bootstrap.php` add file routes before launch Lean

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

create file `Routes.php` into **app** directory

```php
<?php
use Lean\Route;

Route::set('foo/bar', function() {
	echo 'Hi';
});
```

> Url: http://your-site.com/foo/bar // result is 'Hi'

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

> Url `http://your-site.com/product` result is **About Product**  
> Url `http://your-site.com/resources` result is **Product List**  
> Url `http://your-site.com/learn-more-about-product` result is **Product List**  

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

Recovery request data in controllers

```php
<?php
namespace app\main\controllers;

class ProductController extends \Lean\App
{
	public function index()
	{		
	    ...
	    
		/**
		 * get all methods - same of variable $_REQUEST
		 */
		echo $this->request->name;
		echo $this->request->last_name;
		
		/**
		 * get only method post - same of variable $_POST
		 */
		echo $this->request()->post()->name;

		/**
         * get only method post - same of variable $_POST
         */
		echo $this->request()->get()->name;

		/**
         * get only method file - same of variable $_FILE
         */	 
		 $request = $this->request()->file()->name;		
		 
		 /**
		  * you can too instance request object
		  */
		 $request = new \Lean\Http\Request();
		 $request->name
		 
		 ...
	}
}
```

## Using Views

In views directory, you must create `product` and `layout` subdirectories with `.phtml` files.

```php
...
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
...
```

Create `template.phtml` in layout directory, you can include header and footer parts here

```html
<html>
<head>
	<title>My new app</title>
</head>
<body>

    <!-- include header.phtml from layout directory -->
	<? $this->app->view->render('layout.header') ?>

	<div id="container">
		<!-- include page setted in content variable via ProductController -->
		<? $this->app->view->make('content') ?>
	</div>
	
	<!-- include footer.phtml from layout directory
	<? $this->app->view->render('layout.footer') ?>
	
</body>
</html>
```

Rendering yours views

```php
<?php
namespace app\main\controllers;

class ProductController extends \Lean\App
{
	public function index()
	{	
		/**
		 * set which page will rendered by "content" variable in "template.html"
		 * by default, if informed only "index" will rendered .phtml file into product directory
		 */
		$this->view()->set('content', 'index');
		
		/*
		 * render template
		 */
		$this->view()->render('layout.template');
	}
	
	public function edit()
	{	
		/**
		 * this example will rendered "/product/edit.phtml" file
		 */
		$this->view()->set('content', 'edit');
		
		/*
         * render template
         */
		$this->view()->render('layout.template');
	}
}
```

## Date

### Available date formats

```php
Date::FORMAT_DATE = 'YYYY-mm-dd';
Date::FORMAT_DATE_TIME = 'YYYY-mm-dd HH:MM:SS';
Date::FORMAT_DATE_USER = 'dd/mm/YYYY';
Date::FORMAT_DATE_TIME_USER = 'dd/mm/YYYY HH:MM:SS';
Date::FORMAT_DATE_LONG = 'Sexta-feira, 30 de janeiro de 2015';
Date::FORMAT_DAY = 'dd';
Date::FORMAT_MONTH = 'mm';
Date::FORMAT_YEAR = 'YY';
Date::FORMAT_TIME = 'HH:MM:SS';
Date::FORMAT_TIME_SHORT = 'HH:MM';
Date::FORMAT_DATE_TIME_HASH = 'YYYYmmdd_HHMMSS';
```

* `YYYY` : Year 4 digits  
* `mm` : Month 2 digits  
* `dd` : Day 2 digits  
* `HH` : Hours 2 digits  
* `MM` : Minutes 2 digits  
* `SS` : Seconds 2 digits  

### Now

Print today date

```php
use Lean\Format\Date as Date;

echo Date::now() // "YYYY-mm-dd HH:MM:SS" 
echo Date::now(Date::FORMAT_DATE_USER) // "dd/mm/YYYY"
echo Date::now(Date::FORMAT_TIME) // "HH:MM:SS"
```

### format date

Format using constants date

```php
echo Date:format('2015-01-30 10:59:59', Date::FORMAT_DATE) // 2015-01-30
echo Date:format('2015-01-30 10:59:59', Date::FORMAT_DATE_TIME) // 2015-01-30 10:59:59 (nothing change)
echo Date:format('2015-01-30 10:59:59', Date::FORMAT_DATE_USER) // 30/01/2015
echo Date:format('2015-01-30 10:59:59', Date::FORMAT_DATE_TIME_USER) // 30/01/2015 10:59:59
echo Date:format('2015-01-30 10:59:59', Date::FORMAT_TIME_SHORT) // 10:59
```

Format to users

```php
echo Date:format_to_human('2015-01-30 10:59:59') // 30/01/30 10:59:59
echo Date:format_to_human('2015-01-30') // 30/01/30
echo Date:format_to_human('30/01/2015 10:59:59') // 30/01/30 10:59:59 (nothing change)
echo Date:format_to_human('30/01/2015') // 30/01/30 (nothing change)
echo Date:format_to_human('30/01/2015 10:59:59', Date::FORMAT_DATE_USER) // 30/01/30
echo Date:format_to_human('2015-01-30 10:59:59', Date::FORMAT_DATE_USER) // 30/01/30
```

Format to datebase

```php
echo Date:format_to_machine('2015-01-30 10:59:59') // 2015-01-30 10:59:59 (nothing change)
echo Date:format_to_machine('2015-01-30') // 2015-01-30 (nothing change)
echo Date:format_to_machine('30/01/2015 10:59:59') // 2015-01-30 10:59:59
echo Date:format_to_machine('30/01/2015') // 2015-01-30
echo Date:format_to_machine('30/01/2015 10:59:59', Date::FORMAT_DATE) // 2015-01-30
echo Date:format_to_machine('2015-01-30 10:59:59', Date::FORMAT_DATE) // 2015-01-30
```

### Validating date

Validate date format

```php
echo Date::validate('01/01/2015'); // true
echo Date::validate('01/01/2015 12:10:00'); // true
echo Date::validate('2015-01-01'); // true
echo Date::validate('2015-01-01 12:10:00'); // true
echo Date::validate('201-501-01'); // false
echo Date::validate('foo'); // false
```

Validate especific date user format (00/00/0000 00:00:00)

```php
echo Date::validate_format_human('01/01/2015'); // true
echo Date::validate_format_human('01/01/2015 12:10:00'); // true
echo Date::validate_format_human('2015-01-01'); // false
echo Date::validate_format_human('2015-01-01 12:10:00'); // false
echo Date::validate_format_human('201-501-01'); // false
echo Date::validate_format_human('foo'); // false
```

Validate especific date datebase format (0000-00-00 00:00:00)

```php
echo Date::validate_format_machine('01/01/2015'); // false
echo Date::validate_format_machine('01/01/2015 12:10:00'); // false
echo Date::validate_format_machine('2015-01-01'); // true
echo Date::validate_format_machine('2015-01-01 12:10:00'); // true
echo Date::validate_format_machine('201-501-01'); // false
echo Date::validate_format_machine('foo'); // false
```

## Time

### Available time formats

```php
Time::FORMAT_HOUR_MINUTES = 'HH:MM';
Time::FORMAT_HOUR_MINUTES_SECONDS = 'HH:MM:SS';
Time::FORMAT_HOUR = 'HH';
Time::FORMAT_MINUTES = 'MM';
Time::FORMAT_SECONDS = 'SS';
```

* `HH` : Hours 2 digits  
* `MM` : Minutes 2 digits  
* `SS` : Seconds 2 digits

### Now

Print time at moment

```php
use Lean\Format\Time as Time;

echo Time::now() // "HH:MM:SS" 
echo Time::now(Time::FORMAT_HOUR_MINUTES) // "HH:MM"
echo Time::now(Time::FORMAT_HOUR) // "HH"
```

### format time

Format time default

```php
echo Time::format('12:10') // 12:10:00
echo Time::format('122:10') // 122:10:00
echo Time::format('12') // 12:00:00
echo Time::format('12:60') // 12:59:00
echo Time::format('12:99:99') // 12:59:59
echo Time::format('1:1') // 01:01:00
echo Time::format('5:30') // 05:30:00
```

Format using constants time

```php
echo Time::format('12:10', Time::FORMAT_HOUR_MINUTES_SECONDS) // 12:10:00
echo Time::format('12:10:5', Time::FORMAT_HOUR_MINUTES_SECONDS) // 12:10:05
echo Time::format('12', Time::FORMAT_HOUR_MINUTES_SECONDS) // 12:00:00

echo Time::format('12:10:15', Time::FORMAT_HOUR_MINUTES) // 12:10
echo Time::format('12', Time::FORMAT_HOUR_MINUTES) // 12:00
echo Time::format('2:10:15', Time::FORMAT_HOUR_MINUTES) // 02:10
```

### Converter time

Convert time to seconds

```php
echo Time::time_to_seconds('01:30:00') // 5400
echo Time::time_to_seconds('01:15:00') // 4500
echo Time::time_to_seconds('00:01:15') // 75
echo Time::time_to_seconds('48:00:00') // 172800
```

Convert seconds to time

```php
echo Time::seconds_to_time('5400') // 01:30:00
echo Time::seconds_to_time('4500') // 01:15:00 
echo Time::seconds_to_time('75') // 00:01:15
echo Time::seconds_to_time('172800') // 48:00:00
```

### Calculate time

Sum time

```php
echo Time::sum('01:15:00', '02:30:05'); // 03:45:05
echo Time::sum('12:30:00', '07:00:00'); // 19:30:00
echo Time::sum('12:30:00', '12:00:00'); // 00:30:00
```

Subtract time

```php
echo Time::subtract('02:30:05', '01:15:00'); // 01:15:05
echo Time::subtract('12:30:00', '07:00:00'); // 05:30:00
echo Time::subtract('12:30:00', '13:00:00'); // 23:30:00
```

##Author

The Lean PHP framework was created by [Dyorg Almeida](http://facebook.com/dyorg.almeida "Dyorg Facebook page"), 
a full-stack web developer expert and entrepreneur.
Dyorg is founder and CEO of [Rabbiit](http://rabbiit.com "Rabbiit.com"), 
a brazilian startup that develops a simple productivity management and time tracking software.    

## License

The Lean PHP framework is released under MIT public license.
http://www.opensource.org/licenses/MIT
Copyright (c) 2015