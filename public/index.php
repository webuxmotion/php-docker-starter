<?php
error_reporting(-1);

use vendor\core\Router;

$query = $_SERVER['QUERY_STRING'];
$query = rtrim($query, '/');

define('WWW', __DIR__);
define('ROOT', dirname(__DIR__));
define('CORE', ROOT . '/vendor/core');
define('APP', ROOT . '/app');

require '../vendor/libs/functions.php';

spl_autoload_register(function($class) {
  $file = ROOT . '/' . str_replace('\\', '/', $class) . '.php';
  
  if (is_file($file)) {
    require_once $file;
  }
});

Router::add('^page/(?P<action>[a-z-]+)/(?P<alias>[a-z-]+)$', ['controller' => 'Posts']);
Router::add('^page/(?P<alias>[a-z-]+)$', ['controller' => 'Posts', 'action' => 'view']);

Router::add('^$', ['controller' => 'Main', 'action' => 'index']);
Router::add('^(?P<controller>[a-z-]+)/?(?P<action>[a-z-]+)?$');

Router::dispatch($query);