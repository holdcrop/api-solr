<?php
/**
 * Created by PhpStorm.
 * User: pierce
 * Date: 02/06/15
 * Time: 14:41
 */

namespace http\middleware;

use Http\App\Middleware\Contract\MiddlewareContract;
use Http\App\Middleware\Middleware;
use Http\App\Request\Request;

class RateLimiter extends Middleware implements MiddlewareContract {

    /**
     * Number of requests for limit
     */
    CONST LIMIT = 1000;

    /**
     * Duration for limit in seconds
     */
    CONST DURATION = 60;

    /**
     * Directory to write rate limit counters
     */
    CONST STORAGE_DIRECTORY = '/../../storage/rate_limits';

    public function handle(Request $request) {


    }
}