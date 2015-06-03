<?php
/**
 * Created by PhpStorm.
 * User: pierce
 * Date: 03/06/15
 * Time: 14:38
 */

namespace Http\Middleware;

use Config\ConfigManager;

abstract class Middleware {

    /**
     * @var ConfigManager
     */
    protected $_config = null;

    public function __construct(ConfigManager $config) {

        $this->_config = $config;
    }
}