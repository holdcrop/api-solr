<?php

namespace Resources\Entities;

use Exceptions\BadRequest;
use Resources\Entities\Contract\APIMessageContract;

class APIMessage implements APIMessageContract, \JsonSerializable {

    /**
     * Required fields for the message
     *
     * @var array
     */
    protected $_required_fields = array(
        'userid',
        'currencyFrom',
        'currencyTo',
        'amountSell',
        'amountBuy',
        'rate',
        'timePlaced',
        'originatingCountry'
    );

    /**
     * @var int
     */
    protected $_userid;

    /**
     * @var string
     */
    protected $_currencyFrom;

    /**
     * @var string
     */
    protected $_currencyTo;

    /**
     * @var float
     */
    protected $_amountSell;

    /**
     * @var float
     */
    protected $_amountBuy;

    /**
     * @var float
     */
    protected $_rate;

    /**
     * @var \DateTime
     */
    protected $_timePlaced;

    /**
     * @var string
     */
    protected $_originatingCountry;

    /**
     * Constructor
     *
     * @param string $body
     */
    public function __construct($body) {

        $message = json_decode($body, true);

        // Validate the message properties
        if(!$this->_validate($message)) {

            throw new BadRequest('Message not properly formed.');
        }

        // Assign the message properties
        $this->setUserid($message['userid']);
        $this->setCurrencyFrom($message['currencyFrom']);
        $this->setCurrencyTo($message['currencyTo']);
        $this->setAmountSell($message['amountSell']);
        $this->setAmountBuy($message['amountBuy']);
        $this->setRate($message['rate']);
        $this->setTimePlaced($message['timePlaced']);
        $this->setOriginatingCountry($message['originatingCountry']);
    }

    /**
     * Validate the message
     *
     * @param   array   $message
     * @return  bool
     */
    private function _validate($message) {

        if(!is_array($message)) {

            return false;
        }

        return $this->_required_fields === array_keys($message);
    }

    /**
     * @return int
     */
    public function getUserid() {
        return $this->_userid;
    }

    /**
     * @param   int $userid
     * @throws  BadRequest
     */
    public function setUserid($userid) {
        if(ctype_digit($userid)) {
            $this->_userid = $userid;
        }
        else {
            throw new BadRequest('userid field is invalid.');
        }
    }

    /**
     * @return string
     */
    public function getCurrencyFrom() {
        return $this->_currencyFrom;
    }

    /**
     * @param   string $currencyFrom
     * @throws  BadRequest
     */
    public function setCurrencyFrom($currencyFrom) {
        if(strlen($currencyFrom) == 3) {
            $this->_currencyFrom = $currencyFrom;
        }
        else {
            throw new BadRequest('currencyFrom field is invalid.');
        }
    }

    /**
     * @return string
     */
    public function getCurrencyTo() {
        return $this->_currencyTo;
    }

    /**
     * @param   string $currencyTo
     * @throws  BadRequest
     */
    public function setCurrencyTo($currencyTo) {
        if(strlen($currencyTo) == 3) {
            $this->_currencyTo = $currencyTo;
        }
        else {
            throw new BadRequest('currencyTo field is invalid.');
        }
    }

    /**
     * @return float
     */
    public function getAmountSell() {
        return $this->_amountSell;
    }

    /**
     * @param   float $amountSell
     * @throws  BadRequest
     */
    public function setAmountSell($amountSell) {
        if(is_numeric($amountSell)) {
            $this->_amountSell = $amountSell;
        }
        else {
            throw new BadRequest('amountSell field is invalid.');
        }
    }

    /**
     * @return float
     */
    public function getAmountBuy() {
        return $this->_amountBuy;
    }

    /**
     * @param   float $amountBuy
     * @throws  BadRequest
     */
    public function setAmountBuy($amountBuy) {
        if(is_numeric($amountBuy)) {
            $this->_amountBuy = $amountBuy;
        }
        else {
            throw new BadRequest('amountBuy field is invalid.');
        }
    }

    /**
     * @return float
     */
    public function getRate() {
        return $this->_rate;
    }

    /**
     * @param   float $rate
     * @throws  BadRequest
     */
    public function setRate($rate) {
        if(is_numeric($rate)) {
            $this->_rate = $rate;
        }
        else {
            throw new BadRequest('rate field is invalid.');
        }
    }

    /**
     * @return datetime
     */
    public function getTimePlaced() {
        return $this->_timePlaced;
    }

    /**
     * @param   datetime $timePlaced
     * @throws  BadRequest
     */
    public function setTimePlaced($timePlaced) {
        try {
            $this->_timePlaced = new \DateTime($timePlaced);
        }
        catch(\Exception $e) {

            throw new BadRequest('timePlaced field is invalid.');
        }
    }

    /**
     * @return string
     */
    public function getOriginatingCountry() {
        return $this->_originatingCountry;
    }

    /**
     * @param   string $originatingCountry
     * @throws  BadRequest
     */
    public function setOriginatingCountry($originatingCountry) {
        if(strlen($originatingCountry) == 2) {
            $this->_originatingCountry = $originatingCountry;
        }
        else {
            throw new BadRequest('originatingCountry field is invalid.');
        }
    }

    /**
     * @return array
     */
    public function jsonSerialize() {

        return array(
            self::USER_ID_SOLR_FIELD                => $this->_userid,
            self::CURRENCY_FROM_SOLR_FIELD          => $this->_currencyFrom,
            self::CURRENCY_TO_SOLR_FIELD            => $this->_currencyTo,
            self::AMOUNT_SELL_SOLR_FIELD            => $this->_amountSell,
            self::AMOUNT_BUY_SOLR_FIELD             => $this->_amountBuy,
            self::RATE_SOLR_FIELD                   => $this->_rate,
            self::TIME_PLACED_SOLR_FIELD            => $this->_timePlaced->format('Y-m-d\TH:i:s\Z'),
            self::ORIGINATING_COUNTRY_SOLR_FIELD    => $this->_originatingCountry
        );
    }
}