<?php

namespace Http\Controllers\Contract;

use Config\ConfigManager;

interface ControllerContract {

    public function __construct(ConfigManager $config);
}