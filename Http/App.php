<?php

namespace Http;

use Config\ConfigManager;
use Http\Middleware\Middleware as MiddlewareAbstract;
use Http\Request\Request;
use Http\Response\Response;

class App {

    /**
     * @var null|Request
     */
    protected $_request = null;

    /**
     * @var null|Response
     */
    protected $_response = null;

    /**
     * @var array
     */
    protected $_middleware = array();

    /**
     * ConfigManager
     */
    protected $_config = null;
	
	public function __construct() {

        // Exception handler
        $handler = new \Exceptions\Handler($this);
        set_exception_handler(function(\Exception $e) use ($handler) {
            $handler->report($e);
        });

        // Config
        $this->_config = new ConfigManager(array());

        // Request
        $this->_request = new Request(
            $_SERVER,
            apache_request_headers(),
            $_GET,
            $_POST,
            file_get_contents('php://input')
        );

        // Middleware
        $this->_middleware['app'] = array(
            new Middleware\RequestMethod($this->_config)
        );

        // Response
        $this->_response = new Response();

        // Router
        $this->_router = new Router();
	}

    /**
     * @return Request|null
     */
    public function getRequest() {
        return $this->_request;
    }

    /**
     * @return Response|null
     */
    public function getResponse() {
        return $this->_response;
    }

    /**
     * Execute the request
     */
    public function run() {

        // Check the route
        $route_details = $this->_determineRoute();

        // Run the middleware
        $this->_runMiddleware($route_details);

        // Create the controller
        $controller = 'Http\\Controllers\\' . $route_details['controller'];
        $controller = new $controller($this->_config);

        // Perform the action
        $controller->{$route_details['action']}($this->_request, $this->_response);

        // Return the result
        $this->_response->send();

        $this->terminate();
    }

    /**
     * Apply any middleware
     *
     * @param   array   $route
     */
    private function _runMiddleware(array $route) {

        // Apply the App middleware first
        foreach($this->_middleware['app'] as $middleware) {

            $middleware->handle($this->_request);
        }

        // Now apply any middleware for the route
        foreach($route['middleware'] as $middleware_alias) {

            switch($middleware_alias) {
                case 'content-type':
                    $middleware = new Middleware\ContentType($this->_config);
                    break;
                case 'rate-limiter':
                    $middleware = new Middleware\RateLimiter($this->_config);
                default:
                    $middleware = null;
                    break;
            }

            if($middleware instanceof MiddlewareAbstract) {

                $middleware->handle($this->_request);
            }
        }
    }

    /**
     * @return  array
     * @throws  \Exceptions\NotFound
     */
    private function _determineRoute() {

        return Router::getRoute($this->_request->getServer('REQUEST_METHOD'), $this->_request->getServer('REQUEST_URI'));
    }

    /**
     * Terminate the application
     */
    public function terminate() {

        die;
    }
}