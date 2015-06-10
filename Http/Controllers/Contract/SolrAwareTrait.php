<?php

namespace Http\Controllers\Contract;

use Solarium\Client;

trait SolrAwareTrait {

    /**
     * @var \Solarium\Client
     */
    protected $_solr;

    /**
     * Initilise the Solr Client
     *
     * @param   array   $options
     */
    protected function _initialiseSolrClient(array $options = array()) {

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

        // Create the solr_client
        $this->_solr = new Client($solr_config);

        if(!empty($options)) {
            $this->_solr->setOptions($options);
        }
    }
}