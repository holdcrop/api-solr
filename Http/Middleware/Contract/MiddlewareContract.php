<?php

namespace Http\Middleware\Contract;

use Config\ConfigManager;
use Http\Request\Request;

interface MiddlewareContract {

    public function __construct(ConfigManager $config);

    public function handle(Request $request);
}