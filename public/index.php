<?php

$query = $_SERVER['QUERY_STRING'];
$query = rtrim($query, '/');

define('WWW', __DIR__);
define('ROOT', dirname(__DIR__));
define('CORE', ROOT . '/vendor/core');
define('APP', ROOT . '/app');

require '../vendor/libs/functions.php';
require '../vendor/core/Router.php';

spl_autoload_register(function($class) {
  $file = APP . "/controllers/$class.php";
  
  if (is_file($file)) {
    require_once $file;
  }
});

Router::add('^pages/?(?P<action>[a-z-]+)?$', ['controller' => 'Posts']);

Router::add('^$', ['controller' => 'Main', 'action' => 'index']);
Router::add('^(?P<controller>[a-z-]+)/?(?P<action>[a-z-]+)?$');

Router::dispatch($query);

debug(Router::getRoute());

