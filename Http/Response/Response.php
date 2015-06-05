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
     * @var string
     */
    protected $_view = null;

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
     * @param   string  $view
     * @param   array   $options
     */
    public function setView($view, array $options = array()) {
        // Start the output buffer
        ob_start();

        // Get the file
        require(__DIR__ . '/../../Resources/Views/' . $view);

        $this->_view = ob_get_clean();
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

        if($this->_view !== null) {

            $this->_sendHTML();
        }
        else {

            $this->_sendJSON();
        }
    }

    /**
     * Send JSON response
     */
    private function _sendJSON() {

        // Set the response code
        http_response_code($this->_status_code);

        // Set the headers
        foreach($this->_headers as $header => $value) {
            header($header . ':' . $value);
        }

        // Set the body
        echo $this->_body;

        // Send the response
        ob_flush();
    }

    /**
     * Send HTML response
     */
    private function _sendHTML() {

        // Start the output buffer
        ob_start();

        echo $this->_view;

        // Close the buffer
        ob_flush();
    }
}