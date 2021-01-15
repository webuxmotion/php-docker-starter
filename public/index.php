<?php

$query = $_SERVER['QUERY_STRING'];
$query = rtrim($query, '/');

require '../vendor/libs/functions.php';
require '../vendor/core/Router.php';
require '../app/controllers/Main.php';
require '../app/controllers/Posts.php';
require '../app/controllers/PostsNew.php';

Router::add('^$', ['controller' => 'Main', 'action' => 'index']);
Router::add('^(?P<controller>[a-z-]+)/?(?P<action>[a-z-]+)?$');

Router::dispatch($query);

debug(Router::getRoute());

