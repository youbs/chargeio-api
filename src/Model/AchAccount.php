<?php

namespace Youbs\ChargeIO\Model;

use Youbs\ChargeIO\Connection;

class AchAccount extends Object
{
    public function __construct($attributes = array(), Connection $connection = null)
    {
        parent::__construct($attributes, $connection);
        $this->connection = $connection;
        $this->attributes = array_merge($this->attributes, $attributes);
    }

    public function update($attributes = array())
    {
        $accountAttrs = array_merge($this->attributes, $attributes);
        $response = $this->connection->put('/ach-accounts/'.$this->id, $accountAttrs);
        $this->updateAttributes($response);
    }
}
