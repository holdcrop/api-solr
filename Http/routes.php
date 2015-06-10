<?php

use Http\Router;

Router::post('/convert', 'APIController', 'post', array('content-type', 'rate-limiter'));

Router::get('/', 'AdminController', 'index');