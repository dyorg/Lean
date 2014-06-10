<?php

use Lean\Launch;

if (!defined('PHP_VERSION_ID') || PHP_VERSION_ID < 50300)
	die('PHP Lean Framework requires PHP 5.3 or higher');

define('PHP_LEANFRAMEWORK_VERSION_ID','0.1');

function lean_initialize()
{
	$launch = new \Lean\Launch();
	$launch->run();	
}

