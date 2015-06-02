<?php
/**
 * Created by PhpStorm.
 * User: pierce
 * Date: 02/06/15
 * Time: 13:58
 */

namespace Http\App\Middleware;

use Http\App\Request\Request;

abstract class Middleware {

    public function next(Request $request) {

    }
}