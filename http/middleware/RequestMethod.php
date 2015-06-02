<?php
/**
 * Created by PhpStorm.
 * User: pierce
 * Date: 02/06/15
 * Time: 14:19
 */

namespace http\middleware;


use exceptions\MethodNotAllowed;
use Http\App\Middleware\Contract\MiddlewareContract;
use Http\App\Middleware\Middleware;
use Http\App\Request\Request;

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

            throw new MethodNotAllowed('The request method specified is not allowed.');
        }

        $this->next($request);
    }
}