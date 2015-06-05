<?php

namespace Http\Middleware;

use Exceptions\BadRequest;
use Http\Request\Request;

class ContentType extends Middleware {

    /**
     * @param   Request $request
     * @throws  BadRequest
     */
	public function handle(Request $request) {

        $header = $this->_config->offsetGet('headers')->offsetGet('content-type');

        if($request->getHeader('Content-Type') !== $header) {

            throw new BadRequest();
        }
	}
}