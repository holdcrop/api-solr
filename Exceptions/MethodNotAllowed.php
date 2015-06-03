<?php

namespace Exceptions;

class MethodNotAllowed extends \Exception {

    /**
     * @var int
     */
    protected $code = 405;

    /**
     * @var string
     */
    protected $message = 'The request method specified is not allowed.';
}