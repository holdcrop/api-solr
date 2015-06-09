<?php

use Http\Router;

Router::post('/convert', 'APIController', 'post', array('content-type'));

Router::get('/admin', 'AdminController', 'index');