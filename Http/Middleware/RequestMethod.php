<?php

namespace Http\Middleware;

use Exceptions\MethodNotAllowed;
use Http\Middleware\Contract\MiddlewareContract;
use Http\Request\Request;

class RequestMethod extends Middleware {

    /**
     * @param   Request $request
     * @throws  MethodNotAllowed
     */
    public function handle(Request $request) {

        $methods = $this->_config->offsetGet('request_methods')->toArray();

        if(in_array($request->getServer('REQUEST_METHOD'), $methods) != true) {

            throw new MethodNotAllowed();
        }
    }
}