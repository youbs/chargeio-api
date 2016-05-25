<?php

namespace Youbs\ChargeIO\Model;

class BankList extends List
{
    protected function parseResult($offset)
    {
        $bankAttrs = $this->attributes['results'][$offset];

        return new Bank($bankAttrs, $this->connection);
    }
}
