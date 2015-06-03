<?php

namespace Config;

class ConfigManager implements \Iterator, \Countable, \ArrayAccess {

    /**
     * Config file
     */
    CONST CONFIG_FILE = 'config.php';

    /**
     * @var array
     */
    protected $_config = array();

    /**
     * Constructor
     *
     * @param array $config
     */
    public function __construct(array $config) {

        if(empty($config)) {
            $config = require_once(__DIR__ . '/' . self::CONFIG_FILE);
        }

        foreach($config as $key => $value) {

            if(is_array($value) && !empty($value)) {

                $this->_config[$key] = new static($value);
            }
            else {

                $this->_config[$key] = $value;
            }
        }
    }

    /**
     * @return array
     */
    public function getRateLimterConfig() {

        return $this->_config['rate_limiter'];
    }

    /**
     * @return array
     */
    public function getSolrConfig() {

        return $this->_config['solr'];
    }

    /**
     * offsetGet(): defined by ArrayAccess interface.
     *
     * @param  mixed $offset
     * @return mixed
     */
    public function offsetGet($offset) {
        
        return $this->__get($offset);
    }

    /**
     * Magic function so that $obj->value will work.
     *
     * @param  string $name
     * @return mixed
     */
    public function __get($name) {

        return $this->get($name);
    }

    /**
     * Retrieve a value and return $default if there is no element set.
     *
     * @param  string $name
     * @param  mixed  $default
     * @return mixed
     */
    public function get($name, $default = null) {

        if(array_key_exists($name, $this->_config)) {

            return $this->_config[$name];
        }

        return $default;
    }

    /**
     * @return mixed
     */
    public function current() {

        return current($this->_config);
    }

    /**
     * @return mixed
     */
    public function next() {

        return next($this->_config);
    }

    /**
     * @return mixed
     */
    public function key() {

        return key($this->_config);
    }

    /**
     * @return bool
     */
    public function valid() {

        return key($this->_config) !== null;
    }

    /**
     * @return mixed
     */
    public function rewind() {

        return reset($this->_config);
    }

    /**
     * @return int
     */
    public function count() {

        return count($this->_config);
    }

    /**
     * @param   mixed $offset
     * @return  bool
     */
    public function offsetExists($offset) {

        return array_key_exists($offset, $this->_config);
    }

    /**
     * @param mixed $offset
     * @param mixed $value
     */
    public function offsetSet($offset, $value) {

    }

    /**
     * @param mixed $offset
     */
    public function offsetUnset($offset) {

    }

    /**
     * @return array
     */
    public function toArray() {

        return (array) current($this->_config);
    }
}