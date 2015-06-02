<?php

namespace Http;

use Http\Request\Request;

class App {

    /**
     * @var null|Request
     */
    protected $_request = null;



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
	}

    public function run() {

    }
}