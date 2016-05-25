<?php

namespace Youbs\ChargeIO\Model;

class CardList extends List
{
    protected function parseResult($offset)
    {
        $cardAttrs = $this->attributes['results'][$offset];

        return new Card($cardAttrs, $this->connection);
    }
}
