<?php

namespace Http;

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
	
	public function __construct() {

        $this->_request = new Request(
            $_SERVER,
            http_get_request_headers(),
            $_GET,
            $_POST,
            http_get_request_body()
        );

        $this->_response = new Response();
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

    public function run() {

    }
}