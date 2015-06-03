<?php

namespace Exceptions;

use Exception;
use Http\App;

class Handler {

    /**
     * @var App
     */
    protected $_app;

    /**
     * @param App $app
     */
    public function __construct(App $app) {

        $this->_app = $app;
    }

    /**
     * Report an exception.
     *
     * @param  \Exception  $e
     * @return void
     */
    public function report(Exception $e) {

        $this->_app->getResponse()->setStatusCode($e->getCode());
        $this->_app->getResponse()->setBodyEncoded(array('message' => $e->getMessage()));
        $this->_app->getResponse()->send();
        $this->_app->terminate();
    }
}