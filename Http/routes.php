<?php

use Http\Router;

Router::post('/convert', 'APIController', 'post', array('content-type', 'rate-limiter'));

Router::post('/refresh', 'AdminController', 'post');

Router::get('/', 'AdminController', 'index');