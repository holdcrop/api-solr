<?php

namespace Http;

use Exceptions\NotFound;

class Router {

    /**
     * @var array
     */
    static $_routes = array();

    /**
     * @param   string  $pattern
     * @param   string  $controller
     * @param   string  $action
     * @param   array   $middleware
     */
    public static function get($pattern, $controller, $action, array $middleware = array()) {

        self::$_routes['get'][] = array(
            'pattern'       => $pattern,
            'controller'    => $controller,
            'action'        => $action,
            'middleware'    => $middleware
        );
    }

    /**
     * @param   string  $pattern
     * @param   string  $controller
     * @param   string  $action
     * @param   array   $middleware
     */
    public static function post($pattern, $controller, $action, array $middleware = array()) {

        self::$_routes['post'][] = array(
            'pattern'       => $pattern,
            'controller'    => $controller,
            'action'        => $action,
            'middleware'    => $middleware
        );
    }

    /**
     * @param   string  $method
     * @param   string  $pattern
     * @return  array
     */
    public static function getRoute($method, $pattern) {

        $method = strtolower($method);

        if(!array_key_exists($method, self::$_routes)) {
            throw new NotFound();
        }

        // Check the pattern against the named routes
        foreach(self::$_routes[$method] as $route) {

            if($route['pattern'] == $pattern) {

                return array(
                    'controller'    => $route['controller'],
                    'action'        => $route['action'],
                    'middleware'    => $route['middleware']
                );
            }
        }

        throw new NotFound();
    }
}