<?php

namespace Http\Controllers;

use Http\Controllers\Contract\SolrAwareTrait;
use Http\Request\Request;
use Http\Response\Response;
use Resources\Entities\Contract\APIMessageContract;

class AdminController extends Controller {

    use SolrAwareTrait;

    /**
     * @param   Request $request
     * @param   Response $response
     * @return  Response
     */
    public function index(Request $request, Response $response) {

        $this->_initialiseSolrClient();

        $params = array();

        // Create a Select Query
        $query = $this->_solr->createSelect();

        // Get the total number of conversions
        $query->setQuery('*:*');
        $result_set = $this->_solr->select($query);
        $params['total_conversions'] = $result_set->getNumFound();

        // Total sum of amountSell
        $query = $this->_solr->createSelect();
        $grouping = $query->getGrouping();
        $grouping->addField(APIMessageContract::AMOUNT_SELL_SOLR_FIELD);
        $result_set = $this->_solr->select($query);

        // Loop out the result for the grouping
        $groups = $result_set->getGrouping();

        foreach($groups as $groupkey => $field_group) {

            foreach($field_group as $value_group) {
                $params['total_amount_sell'] = $value_group->getValue();
            }
        }

        // Total sum of amountBuy
        $query = $this->_solr->createSelect();
        $grouping = $query->getGrouping();
        $grouping->addField(APIMessageContract::AMOUNT_BUY_SOLR_FIELD);
        $result_set = $this->_solr->select($query);

        // Loop out the result for the grouping
        $groups = $result_set->getGrouping();

        foreach($groups as $groupkey => $field_group) {

            foreach($field_group as $value_group) {
                $params['total_amount_buy'] = $value_group->getValue();
            }
        }

        $response->setView('admin.php', $params);

        return $response;
    }
}