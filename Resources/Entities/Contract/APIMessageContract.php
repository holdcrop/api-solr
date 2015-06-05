<?php

namespace Resources\Entities\Contract;


interface APIMessageContract {

    /**
     * @var string
     */
    const USER_ID_SOLR_FIELD = 'userid_i';

    /**
     * @var string
     */
    const CURRENCY_FROM_SOLR_FIELD = 'currencyFrom_s';

    /**
     * @var string
     */
    const CURRENCY_TO_SOLR_FIELD = 'currencyTo_s';

    /**
     * @var string
     */
    const AMOUNT_SELL_SOLR_FIELD = 'amountSell_f';

    /**
     * @var string
     */
    const AMOUNT_BUY_SOLR_FIELD = 'amountBuy_f';

    /**
     * @var string
     */
    const RATE_SOLR_FIELD = 'rate_f';

    /**
     * @var string
     */
    const TIME_PLACED_SOLR_FIELD = 'timePlaced_dt';

    /**
     * @var string
     */
    const ORIGINATING_COUNTRY_SOLR_FIELD = 'originatingCountry_s';
}