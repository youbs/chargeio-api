<?php

namespace Youbs\ChargeIO\Model;

class RecurringChargeList extends List
{
    protected function parseResult($offset)
    {
        $attrs = $this->attributes['results'][$offset];

        return new RecurringCharge($attrs, $this->connection);
    }
}
