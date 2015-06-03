<?php

return array(
    // Rate Limiting
    'rate_limiter'  => array(
        'limit'             => 1000,                        // Number of requests
        'duration'          => 60,                          // Duration for limit in seconds
        'storage_directory' => '/../../storage/rate_limits' // Directory to write rate limit counters
    ),
    // Content type
    'content-type'  => array(

    ),
    // Solr
    'solr'          => array(
        'endpoint' => array(
            'localhost' => array(
                'host'      => '127.0.0.1',
                'port'      => 8983,
                'path'      => '/solr/currency',
                'timeout'   => 500
            )
        )
    )
);