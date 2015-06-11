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
        $params['total_conversions'] = $this->_getTotalConversions();

        // Total sum of amountSell & amountBuy
        $params = array_merge($params, $this->_totalAmounts());

        // Get the chart
        $params['chart'] = $this->_buildChart();

        $response->setView('admin.php', $params);

        return $response;
    }

    /**
     * @param Request $request
     * @param Response $response
     * @return Response
     */
    public function post(Request $request, Response $response) {

        $time_frame = $request->getInput('time_frame');

        $this->_initialiseSolrClient(array('headers' => array('Content-type' => 'application/x-www-form-urlencoded; charset=utf-8')));

        $params = array(
            'time_frame'    => $time_frame
        );

        // Get the total number of conversions
        $params['total_conversions'] = $this->_getTotalConversions();

        // Total sum of amountSell & amountBuy
        $params = array_merge($params, $this->_totalAmounts());

        // Get the chart
        $params['chart'] = $this->_buildChart($time_frame);

        $response->setView('admin.php', $params);

        return $response;
    }

    /**
     * @return int
     */
    private function _getTotalConversions() {

        $query = $this->_solr->createSelect();
        $query->setQuery('*:*');
        $query->setRows(0);
        $result_set = $this->_solr->select($query);

        return $result_set->getNumFound();
    }

    /**
     * @param   int $time_frame
     * @return  Highchart
     */
    private function _buildChart($time_frame = 60) {

        // Set the time frame string
        switch($time_frame) {
            case 60:
                $time_frame = '1 hour ago';
                break;
            case 30:
            case 20:
            case 10:
            case 5:
                $time_frame = $time_frame . ' minutes ago';
                break;
            case 1:
                $time_frame = '1 minute ago';
                break;
            default:
                $time_frame = '1 hour ago';
                break;
        }

        // Get data for the time frame
        $past = new \DateTime($time_frame);
        $today = new \DateTime('now');

        // Get the sum of amountSell and amountBuy per timePlaced
        $query = $this->_solr->createSelect();
        $query->setQuery(APIMessageContract::TIME_PLACED_SOLR_FIELD . ':[' . $past->format('Y-m-d\TH:i:s\Z') . ' TO '  . $today->format('Y-m-d') . 'T23:59:59Z]');
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
        $chart->title->text = 'Traffic for ' . $time_frame;

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
        $chart->xAxis->title->text = 'Time Placed';

        $chart->yAxis->min = 0;
        $chart->yAxis->title->text = 'Amount';

        $amount_sell = array('name' => 'Amount Sell', 'data' => array());
        $amount_buy = array('name' => 'Amount Buy', 'data' => array());

        foreach($stats_result as $stat) {

            $field = $stat->getName();

            foreach($stat->getFacets() as $facets) {

                switch($field) {
                    case APIMessageContract::AMOUNT_SELL_SOLR_FIELD:
                        foreach($facets as $facet) {
                            $date = new \DateTime($facet->getValue());
                            $date = $date->format('Y') . ', ' . ((int) $date->format('m') - 1) . ', ' . $date->format('d, H, i, s');

                            $amount_sell['data'][] = array(
                                new HighchartJsExpr("Date.UTC(" . $date . ")"),
                                $facet->getSum()
                            );
                        }
                        break;
                    case APIMessageContract::AMOUNT_BUY_SOLR_FIELD:
                        foreach($facets as $facet) {
                            $date = new \DateTime($facet->getValue());
                            $date = $date->format('Y') . ', ' . ((int) $date->format('m') - 1) . ', ' . $date->format('d, H, i, s');

                            $amount_buy['data'][] = array(
                                new HighchartJsExpr("Date.UTC(" . $date . ")"),
                                $facet->getSum()
                            );
                        }
                        break;
                }
            }
        }

        $chart->series[] = $amount_sell;
        $chart->series[] = $amount_buy;

        return $chart;
    }

    /**
     * @return array
     */
    private function _totalAmounts() {

        $totals = array();

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
                    $totals['total_amount_buy'] = $field->getSum();
                    break;
                case APIMessageContract::AMOUNT_SELL_SOLR_FIELD:
                    $totals['total_amount_sell'] = $field->getSum();
                    break;
            }
        }

        return $totals;
    }
}