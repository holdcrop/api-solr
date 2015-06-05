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

        // Get the config
        $solr_config = $this->_config->offsetGet('solr')->getConfig();

        // Create the Solarium Config array
        $solr_config = array(
            'endpoint'   => array(
                $solr_config['endpoint']    => array(
                    'host'      => $solr_config['host'],
                    'port'      => $solr_config['port'],
                    'path'      => $solr_config['path'],
                    'timeout'   => $solr_config['timeout'],
                )
            )
        );

        $solr = new Client($solr_config);

        $update = $solr->createUpdate();
        $doc = $update->createDocument($message->jsonSerialize());

        $update->addDocument($doc);
        $update->addCommit();

        $response->setBodyEncoded(array('success' => $solr->update($update)->getResponse()));

        return $response;
    }
}