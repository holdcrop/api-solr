<?php
/**
 * Created by PhpStorm.
 * User: pierce
 * Date: 02/06/15
 * Time: 14:15
 */

namespace Exceptions;


class BadRequest extends \Exception {

    /**
     * @var int
     */
    protected $_code = 400;
}