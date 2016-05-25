<?php

namespace Youbs\ChargeIO\Model;

class RecurringChargeOccurrenceList extends List
{
    protected function parseResult($offset)
    {
        $attrs = $this->attributes['results'][$offset];

        return new RecurringChargeOccurrence($attrs, $this->connection);
    }
}
