<?php

namespace Http\Controllers;

use Ghunti\HighchartsPHP\Highchart;
use Ghunti\HighchartsPHP\HighchartJsExpr;
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

        $this->_initialiseSolrClient(array('headers' => array('Content-type' => 'application/x-www-form-urlencoded; charset=utf-8')));

        $params = array();

        // Get the total number of conversions
        $query = $this->_solr->createSelect();
        $query->setQuery('*:*');
        $query->setRows(0);
        $result_set = $this->_solr->select($query);
        $params['total_conversions'] = $result_set->getNumFound();

        // Get data for the last 10 days
        $ten_days_ago = new \DateTime('10 days ago');
        $today = new \DateTime('now');

        // Get the sum of amountSell and amountBuy per timePlaced
        $query = $this->_solr->createSelect();
        $query->setQuery(APIMessageContract::TIME_PLACED_SOLR_FIELD . ':[' . $ten_days_ago->format('Y-m-d') . 'T00:00:00Z TO '  .$today->format('Y-m-d') . 'T23:59:59Z]');
        $query->setRows(0);

        $stats_component = $query->getStats();
        $stats_component->addFacet(APIMessageContract::TIME_PLACED_SOLR_FIELD);
        $stats_component->createField(APIMessageContract::AMOUNT_BUY_SOLR_FIELD);
        $stats_component->createField(APIMessageContract::AMOUNT_SELL_SOLR_FIELD);

        $result_set = $this->_solr->select($query);
        $stats_result = $result_set->getStats();

        // Create a new HighChart
        $chart = new Highchart();

        $chart->chart = array(
            'renderTo'  => 'highchart',
            'type'      => 'column'
        );

        $chart->legend = array(
            'layout'        => 'vertical',
            'align'         => 'right',
            'verticalAlign' => 'top',
            'x'             => 0,
            'y'             => 100,
            'borderWidth'   => 0
        );

        $chart->xAxis->type = "datetime";
        $chart->xAxis->dateTimeLabelFormats->month = "%e. %b";

        $chart->yAxis->min = 0;

        $amount_sell = array('name' => 'Amount Sell', 'data' => array());
        $amount_buy = array('name' => 'Amount Buy', 'data' => array());

        foreach($stats_result as $stat) {

            foreach($stat->getFacets() as $field => $facets) {
                switch($field) {
                    case APIMessageContract::AMOUNT_SELL_SOLR_FIELD:
                        foreach($facets as $facet) {
                            print("<pre>" . print_r($facet, true) . "</pre>");
                            die;
                        }
                        break;
                    case APIMessageContract::AMOUNT_BUY_SOLR_FIELD:
                        foreach($facets as $facet) {
                            print("<pre>" . print_r($facet, true) . "</pre>");
                            die;
                        }
                        break;
                }
            }
        }

            $date = new \DateTime($document->{APIMessageContract::TIME_PLACED_SOLR_FIELD});
            $date = $date->format('Y') . ', ' . ((int) $date->format('m') - 1) . ', ' . $date->format('d, H, i, s');

            $rate['data'][] = array(
                new HighchartJsExpr("Date.UTC(" . $date . ")"),
                $document->{APIMessageContract::RATE_SOLR_FIELD}
            );

            $amount_sell['data'][] = array(
                new HighchartJsExpr("Date.UTC(" . $date . ")"),
                $document->{APIMessageContract::AMOUNT_SELL_SOLR_FIELD}
            );

            $amount_buy['data'][] = array(
                new HighchartJsExpr("Date.UTC(" . $date . ")"),
                $document->{APIMessageContract::AMOUNT_BUY_SOLR_FIELD}
            );


        $chart->series[] = $rate;
        $chart->series[] = $amount_sell;
        $chart->series[] = $amount_buy;



        // Total sum of amountSell & amountBuy
        $query = $this->_solr->createSelect();
        $query->setRows(0);
        // Add stats setting
        $stats = $query->getStats();
        $stats->createField(APIMessageContract::AMOUNT_BUY_SOLR_FIELD);
        $stats->createField(APIMessageContract::AMOUNT_SELL_SOLR_FIELD);

        $result_set = $this->_solr->select($query);
        $stats_result = $result_set->getStats();

        foreach($stats_result as $field) {

            switch($field->getName()) {
                case APIMessageContract::AMOUNT_BUY_SOLR_FIELD:
                    $params['total_amount_buy'] = $field->getSum();
                    break;
                case APIMessageContract::AMOUNT_SELL_SOLR_FIELD:
                    $params['total_amount_sell'] = $field->getSum();
                    break;
            }
        }


        $params['chart'] = $chart;

        $response->setView('admin.php', $params);

        return $response;
    }
}