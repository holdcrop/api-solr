<?php
/**
 * Created by PhpStorm.
 * User: pierce
 * Date: 02/06/15
 * Time: 14:41
 */

namespace Http\Middleware;

use Http\Middleware\Contract\MiddlewareContract;
use Http\Request\Request;

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