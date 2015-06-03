<?php

namespace Http\Controllers;

use Http\Request\Request;
use Http\Response\Response;
use Resources\Entities\APIMessage;
use Solarium\Client;

class APIController extends Controller {

    /**
     * @param   Request     $request
     * @param   Response    $response
     * @return  Response
     */
    public function post(Request $request, Response $response) {

        $message = new APIMessage($request->getBody());

        $solr = new Client($this->_config->offsetGet('solr'));

        $response->setBody(array('message' => 'Here'));

        return $response;
    }
}