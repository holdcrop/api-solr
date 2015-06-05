<?php

namespace Http\Request;

class Request {

    /**
     * Server variables
     *
     * @var array
     */
    protected $_servers = array();

    /**
     * Request headers
     *
     * @var array
     */
    protected $_headers = array();

    /**
     * GET/POST params
     *
     * @var array
     */
    protected $_inputs = array();

    /**
     * Request body
     *
     * @var string|null
     */
    protected $_body = null;

    /**
     * @param array     $server
     * @param array     $headers
     * @param array     $get
     * @param array     $post
     * @param string    $body
     */
    public function __construct(array $server, array $headers, array $get, array $post, $body) {

        $this->_servers = $server;
        $this->_headers = $headers;

        $this->_inputs = array_merge($get, $post);

        $this->_body = $body;
    }

    /**
     * @return array
     */
    public function getServers() {
        return $this->_servers;
    }

    /**
     * @return array
     */
    public function getHeaders() {
        return $this->_headers;
    }

    /**
     * @return array
     */
    public function getInputs() {
        return $this->_inputs;
    }

    /**
     * @return null|string
     */
    public function getBody() {
        return $this->_body;
    }

    /**
     * Get a server variable by name
     *
     * @param   string  $server_name
     * @return  null
     */
    public function getServer($server_name) {

        if(array_key_exists($server_name, $this->_servers)) {

            return $this->_servers[$server_name];
        }

        return null;
    }

    /**
     * Get an input by name
     *
     * @param   string  $input_name
     * @return  null
     */
    public function getInput($input_name) {

        if(array_key_exists($input_name, $this->_inputs)) {

            return $this->_inputs[$input_name];
        }

        return null;
    }

    /**
     * Get a header by name
     *
     * @param   string  $header_name
     * @return  null
     */
    public function getHeader($header_name) {

        if(array_key_exists($header_name, $this->_headers)) {

            return $this->_headers[$header_name];
        }

        return null;
    }
}