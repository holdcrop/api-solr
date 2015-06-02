<?php
/**
 * Created by PhpStorm.
 * User: pierce
 * Date: 02/06/15
 * Time: 08:39
 */

namespace Http\Middleware\Contract;

use Http\Request\Request;

interface MiddlewareContract {

    public function handle(Request $request);

    public function next(Request $request);
}