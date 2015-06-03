<?php

namespace Http\Controllers;

use Config\ConfigManager;
use Http\Controllers\Contract\ControllerContract;

abstract class Controller implements ControllerContract {

    /**
     * @var ConfigManager
     */
    protected $_config = null;

    public function __construct(ConfigManager $config) {

        $this->_config = $config;
    }
}