<?php

namespace Http\Middleware;

use Exceptions\BadRequest;
use Http\Middleware\Contract\MiddlewareContract;
use Http\Request\Request;

class ContentType extends Middleware implements MiddlewareContract {

    /**
     * @param   Request $request
     * @throws  BadRequest
     */
	public function handle(Request $request) {

        if($request->getHeader('Content-type') !== 'application/json') {

            throw new BadRequest('Incorrect content-type header specified.');
        }

        $this->next($request);
	}
}