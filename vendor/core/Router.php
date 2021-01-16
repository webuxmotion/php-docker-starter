<?php

namespace vendor\core;

class Router {
    protected static $routes = [];
    protected static $route = [];
    protected static $controllerObj;

    public static function add($regexp, $route = []) {
        self::$routes[$regexp] = $route;
    }

    public static function dispatch($url) {
        $url = self::removeQueryString($url);

        if (self::matchRoute($url)) {

            $controllerName = self::getControllerName();
            self::loadController($controllerName);

            if (self::$controllerObj) {
                $actionName = self::getActionName();
                self::callAction($actionName);

                debug(self::$route);
            }
        } else {
            http_response_code(404);
            include '404.html';
        }
    }

    public static function getRoutes() {
        return self::$routes;
    }

    public static function getRoute() {
        return self::$route;
    }

    protected static function matchRoute($url) {
        
        foreach (self::$routes as $pattern => $route) {
            if (preg_match("#$pattern#i", $url, $matches)) {
                
                foreach ($matches as $k => $v) {
                    if (is_string($k)) {
                        $route[$k] = $v;
                    }
                }

                if (!isset($route['action'])) {
                    $route['action'] = 'index';
                }

                $route['controller'] = upperCamelCase($route['controller']);

                self::$route = $route;
                return true;
            }
        }
        
        return false;
    }

    protected static function getControllerName() {
        $name = self::$route['controller'];
        $name = 'app\controllers\\' . $name;

        return $name;
    }

    protected static function getActionName() {
        $name = self::$route['action'];
        $name = lowerCamelCase($name);
        $name = $name . 'Action';

        return $name;
    }

    protected static function loadController($name) {
        if (class_exists($name)) {
            self::$controllerObj = new $name(self::$route);
        } else {
            debug("Controller <b>$name</b> not found");
        }
    }

    protected static function callAction($name) {
        if (method_exists(self::$controllerObj, $name)) {
            self::$controllerObj->$name();
        } else {
            debug("Action <b>$name</b> not found");
        }
    }

    protected static function removeQueryString($url) {
        
        if ($url) {
            $params = explode('&', $url);
            $urlCandidate = $params[0];

            if (false === strpos($urlCandidate, '=')) {
                return rtrim($urlCandidate, '/');
            }
        }

        return '';
    }
}