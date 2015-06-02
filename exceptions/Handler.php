<?php

namespace Exceptions;

use Exception;

class Handler {

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $e
     * @return void
     */
    public function report(Exception $e) {

        switch(true) {
            case $e instanceof \Illuminate\Session\TokenMismatchException:
                return response()->view('errors.401');
                break;
            case $e instanceof \Symfony\Component\HttpKernel\Exception\NotFoundHttpException:
                return response()->view('errors.404');
                break;
            case $e instanceof \Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException:
                return response()->view('errors.405');
                break;
            case $e instanceof \Symfony\Component\Debug\Exception\FatalErrorException:
            case $e instanceof \ErrorException:
            case $e instanceof InvalidArgumentException:
            case $e instanceof \Illuminate\Database\QueryException:
                return response()->view('errors.500', array('debug_mode' => env('APP_DEBUG'), 'exception' => $e));
                break;
        }
    }
}