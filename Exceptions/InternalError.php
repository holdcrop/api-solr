<?php

namespace Exceptions;

class InternalError extends \Exception{

    /**
     * @var string
     */
    protected $code = '500';

    /**
     * @var string
     */
    protected $message = 'Internal server error.';
}