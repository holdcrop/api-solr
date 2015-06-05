<?php

return array(
    // Rate Limiting
    'rate_limiter'      => array(
        'limit'             => 1000,                        // Number of requests
        'duration'          => 60,                          // Duration for limit in seconds
        'storage_directory' => '/../../storage/rate_limits' // Directory to write rate limit counters
    ),
    // Accepted Request Methods
    'request_methods'   => array(
        'POST',
        'GET'
    ),
    // Headers
    'headers'           => array(
        'content-type'      => 'application/json'
    ),
    // Solr
    'solr'              => array(
        'endpoint'  => 'localhost',
        'host'      => '127.0.0.1',
        'port'      => 8983,
        'path'      => '/solr/currency_fair',
        'timeout'   => 500
    )
);