<?php
/**
 * Created by PhpStorm.
 * User: pierce
 * Date: 03/06/15
 * Time: 08:40
 */

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
     */
    public static function get($pattern, $controller, $action) {

        self::$_routes['get'][] = array(
            'pattern'       => $pattern,
            'controller'    => $controller,
            'action'        => $action
        );
    }

    /**
     * @param   string  $pattern
     * @param   string  $controller
     * @param   string  $action
     */
    public static function post($pattern, $controller, $action) {

        self::$_routes['post'][] = array(
            'pattern'       => $pattern,
            'controller'    => $controller,
            'action'        => $action
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
                    'action'        => $route['action']
                );
            }
        }

        throw new NotFound();
    }
}