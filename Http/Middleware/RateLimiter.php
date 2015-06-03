<?php

namespace Http\Middleware;

use Exceptions\BadRequest;
use Exceptions\InternalError;
use Exceptions\TooManyRequests;
use Http\Middleware\Contract\MiddlewareContract;
use Http\Request\Request;

class RateLimiter extends Middleware {

    /**
     * @param   Request $request
     * @throws  InternalError
     */
    public function handle(Request $request) {

        $base_path = __DIR__ . $this->_config->offsetGet('rate_limiter')->offsetGet('storage_directory');

        // Check the cache directory exists
        if(!is_dir($base_path) || !is_writable($base_path)) {

            throw new InternalError();
        }

        $cache_key = $this->_getCacheKey($request);
        $date = new \DateTime('now');

        if(file_exists($base_path . '/' . $cache_key)) {
            // Already made a request
            $cache = json_decode(file_get_contents($base_path . '/' . $cache_key), true);

            // Set when the cache was due to expire
            $start_date = new \DateTime($cache['start']);
            $start_date->add(new \DateInterval('PT' . $this->_config->offsetGet('rate_limiter')->offsetGet('duration') . 'S'));

            if($date > $start_date) {
                // Cache expired, restart the cache
                $cache['start'] = $date->format('Y-m-d H:i:s');
                $cache['requests'] = 1;
            }
            else {
                // Check the limit, still within time frame
                if($cache['requests'] >= $this->_config->offsetGet('rate_limiter')->offsetGet('limit')) {

                    throw new TooManyRequests();
                }
                else {
                    // Ok, increment the cache
                    $cache['requests'] = $cache['requests'] + 1;
                }
            }
        }
        else {
            // Create a new cache
            $cache = array();

            $cache['start'] = $date->format('Y-m-d H:i:s');
            $cache['requests'] = 1;
        }

        file_put_contents($base_path . '/' . $cache_key, json_encode($cache));
    }

    /**
     * @param   Request $request
     * @return  string
     * @throws  BadRequest
     */
    private function _getCacheKey(Request $request) {

        $address = $request->getServer('REMOTE_ADDR');

        if(empty($address)) {

            $address = $request->getServer('HTTP_CLIENT_IP');
        }

        if(empty($address)) {

            $address = $request->getServer('HTTP_X_FORWARDED_FOR');
        }

        if(empty($address)) {

            throw new BadRequest();
        }

        return md5($address);
    }
}