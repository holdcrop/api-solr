<?php

namespace Http\Controllers;

use Http\Controllers\Contract\SolrAwareTrait;
use Http\Request\Request;
use Http\Response\Response;
use Resources\Entities\APIMessage;

class APIController extends Controller {

    use SolrAwareTrait;

    /**
     * @param   Request     $request
     * @param   Response    $response
     * @return  Response
     */
    public function post(Request $request, Response $response) {

        $this->_initialiseSolrClient();

        $message = new APIMessage($request->getBody());

        // Create the update document
        $update = $this->_solr->createUpdate();
        $doc = $update->createDocument($message->jsonSerialize());

        $update->addDocument($doc);

        // Send the update
        $response->setBodyEncoded(array($this->_solr->update($update)->getResponse()));

        return $response;
    }
}