<?php

namespace Http\Controllers;

use Http\Request\Request;
use Http\Response\Response;
use Solarium\Client;

class APIController {

    /**
     * @param   Request     $request
     * @param   Response    $response
     * @return  Response
     */
    public function convert(Request $request, Response $response) {

        //$solr = new Client();

        $response->setBody(array('message' => 'Here'));

        return $response;
    }
}