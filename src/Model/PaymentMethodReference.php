<?php

namespace Youbs\ChargeIO\Model;

use Youbs\ChargeIO\Utils;

class PaymentMethodReference extends Object implements PaymentMethod
{
    public function __get($prop)
    {
        switch ($prop) {
            default:
                $underscoredProp = Utils::underscore($prop);
                if (isset($this->attributes[$underscoredProp])) {
                    return $this->attributes[$underscoredProp];
                } else {
                    return;
                }
        }
    }
}
