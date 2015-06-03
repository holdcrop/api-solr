<?php

namespace Http\Middleware;

use Exceptions\BadRequest;
use Http\Middleware\Contract\MiddlewareContract;
use Http\Request\Request;

class ContentType extends Middleware {

    /**
     * @param   Request $request
     * @throws  BadRequest
     */
	public function handle(Request $request) {

        if($request->getHeader('Content-type') !== 'application/json' && $request->getHeader('Content-Type') !== 'application/json') {

            throw new BadRequest();
        }
	}
}