<?php

namespace Exceptions;


class BadRequest extends \Exception {

    /**
     * @var int
     */
    protected $code = 400;

    /**
     * @var string
     */
    protected $message = 'Incorrect content-type header specified.';
}