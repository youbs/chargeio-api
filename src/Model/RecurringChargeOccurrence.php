<?php

namespace Youbs\ChargeIO\Model;

class RecurringChargeOccurrence extends Object
{
    public function pay($params = array())
    {
        $response = $this->connection->post('/recurring/charges/'.$this->recurring_charge_id.'/occurrences/'.$this->id.'/pay', $params);
        $this->updateAttributes($response);
    }

    public function ignore($params = array())
    {
        $response = $this->connection->post('/recurring/charges/'.$this->recurring_charge_id.'/occurrences/'.$this->id.'/ignore', $params);
        $this->updateAttributes($response);
    }
}
