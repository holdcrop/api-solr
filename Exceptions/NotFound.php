<?php

namespace Exceptions;

class NotFound extends \Exception {

    /**
     * @var int
     */
    protected $code = 404;

    /**
     * @var string
     */
    protected $message = 'Page not found';
}