<?php

namespace Http\Middleware;

use Http\Request\Request;

abstract class Middleware {

    public function next(Request $request) {

    }
}