<?php

namespace Http\Response;

class Response {

    /**
     * @var array
     */
    protected $_headers = array(
        'Content-type'  => 'application/json'
    );

    /**
     * @var string|null
     */
    protected $_body = null;

    /**
     * @var int
     */
    protected $_status_code;

    /**
     * @param array $headers
     */
    public function setHeaders($headers) {
        $this->_headers = $headers;
    }

    /**
     * @param string $header
     * @param string $content
     */
    public function setHeader($header, $content) {
        $this->_headers[$header] = $content;
    }

    /**
     * @param null|string $body
     */
    public function setBody($body) {
        $this->_body = $body;
    }

    /**
     * @param array|object $body
     */
    public function setBodyEncoded($body) {
        $this->_body = json_encode($body);
    }

    /**
     * @param int $status_code
     */
    public function setStatusCode($status_code) {
        $this->_status_code = $status_code;
    }

    /**
     * Send the response
     */
    public function send() {

        // Set the response code
        http_response_code($this->_status_code);

        // Set the headers
        foreach($this->_headers as $header => $value) {
            header($header . ': ' . $value);
        }

        // Set the body
        http_send_data($this->_body);

        ht
    }
}