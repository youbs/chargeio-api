<?php

namespace Youbs\ChargeIO\Model;

use Youbs\ChargeIO\Connection;
use Youbs\ChargeIO\Utils;

abstract class Object
{
    protected $connection;
    public $attributes = array();

    public function __construct($attributes = array(), Connection $connection = null)
    {
        $this->connection = $connection;
        $this->attributes = array_merge($this->attributes, $attributes);
    }

    public function __get($prop)
    {
        $underscoredProp = Utils::underscore($prop);
        if (isset($this->attributes[$underscoredProp])) {
            return $this->attributes[$underscoredProp];
        } else {
            return;
        }
    }

    public function __set($prop, $value)
    {
        $underscoredProp = Utils::underscore($prop);
        $this->attributes[$underscoredProp] = $value;
    }

    public function updateAttributes($attributes = array())
    {
        foreach ($attributes as $key => $value) {
            if ($value !== '' || !isset($this->attributes[$key])) {
                $this->attributes[$key] = $value;
            }
        }
    }
}
