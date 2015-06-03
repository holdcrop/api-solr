<?php

namespace Exceptions;


class TooManyRequests extends \Exception{

    /**
     * @var int
     */
    protected $code = 429;

    /**
     * @var string
     */
    protected $message = 'Too Many Requests.';
}