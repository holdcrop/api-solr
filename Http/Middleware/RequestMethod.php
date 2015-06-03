<?php

namespace Http\Middleware;

use Exceptions\MethodNotAllowed;
use Http\Middleware\Contract\MiddlewareContract;
use Http\Request\Request;

class RequestMethod extends Middleware implements MiddlewareContract {

    /**
     * Accepted Request Methods
     *
     * @var array
     */
    protected $_methods = array('POST');

    /**
     * @param   Request $request
     * @throws  MethodNotAllowed
     */
    public function handle(Request $request) {

        if(in_array($request->getServer('REQUEST_METHOD'), $this->_methods) != true) {

            throw new MethodNotAllowed();
        }
    }
}