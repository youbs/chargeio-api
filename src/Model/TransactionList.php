<?php

namespace Youbs\ChargeIO\Model;

use Youbs\ChargeIO\Exception\ChargeIOException;

class TransactionList extends List
{
    protected function parseResult($offset)
    {
        $transAttrs = $this->attributes['results'][$offset];
        try {
            return Transaction::parse($transAttrs, $this->connection);
        } catch(\Exception $ex) {
            throw new ChargeIOException('Unexpected transaction type ' . $transAttrs['type'] . ' at offset ' . $offset);
        }
    }
}
