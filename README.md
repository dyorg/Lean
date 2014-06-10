# Lean Framework PHP

Lean Framework is a tiny PHP framework.

## My structure 

```php
-- app
	-- main (module)
		-- controllers
		-- models
		-- views
	-- secondary (other module)
		-- controllers
		-- models
		-- views
-- public_html
	-- css
	-- js
	-- img
-- settings
	-- Bootstrap.php
-- vendor
	-- Lean
	-- Symfony (Symfony/Component/ClassLoader/*)
	-- autoloader.php
```

## Start with simple config

create file "autoloader.php", I'm using the Symfony Autoloader

```php
<?php

require_once __DIR__ . '/Symfony/Component/ClassLoader/UniversalClassLoader.php';

$loader = new Symfony\Component\ClassLoader\UniversalClassLoader();
$loader->registerNamespaces(array(
	'Lean'     => __DIR__,
    'Guzzle'   => __DIR__,
    'Symfony'  => __DIR__,
));

$loader->useIncludePath(true);
$loader->register();
```

create file "bootstrap.php"

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
 * lean configs
 */
Lean\View::set_header_default('app/main/views/layout/header.phtml');
Lean\View::set_footer_default('app/main/views/layout/footer.phtml');


/**
 * init lean framework
 */
Lean\Launch::instance()->run();
```

