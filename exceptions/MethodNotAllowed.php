<?php
/**
 * Created by PhpStorm.
 * User: pierce
 * Date: 02/06/15
 * Time: 14:18
 */

namespace exceptions;

class MethodNotAllowed extends \Exception {

    /**
     * @var int
     */
    protected $_code = 405;
}