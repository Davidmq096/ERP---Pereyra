<?php

use Symfony\Component\HttpFoundation\Request;

/** @var \Composer\Autoload\ClassLoader $loader */
$loader = require __DIR__.'/../app/autoload.php';
include_once __DIR__.'/../var/bootstrap.php.cache';

date_default_timezone_set('America/Mexico_City');
set_time_limit(300);
// Entorno de insitituo Lux 1 Ciencias 2
$fp = fopen("sistema.txt", "r");
$content = fread($fp, filesize("sistema.txt"));
fclose($fp);
$sistema = (int)$content;
define("ENTORNO",$sistema? $sistema : 2);

$kernel = new AppKernel('prod', false);
$kernel->loadClassCache();
//$kernel = new AppCache($kernel);

// When using the HttpCache, you need to call the method in your front controller instead of relying on the configuration parameter
//Request::enableHttpMethodParameterOverride();
$request = Request::createFromGlobals();
$response = $kernel->handle($request);
$response->send();
$kernel->terminate($request, $response);
