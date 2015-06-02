<?php
/**
 * Created by PhpStorm.
 * User: pierce
 * Date: 02/06/15
 * Time: 14:48
 */

namespace Http\Response;

class Response {

    /**
     * @var array
     */
    protected $_headers = array();

    /**
     * @var string|null
     */
    protected $_body = null;

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
     * @param array|object $body
     */
    public function setBodyEncoded($body) {

        $this->_body = json_encode($body);
    }
}