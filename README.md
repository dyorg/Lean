# Lean Framework PHP

Lean Framework is a tiny PHP framework.

## My structure 

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

```php
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

create file "bootstrap.php" into settings

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

