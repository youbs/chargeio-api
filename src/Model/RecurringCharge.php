<?php

namespace Youbs\ChargeIO\Model;

use Youbs\ChargeIO\ChargeIO;
use Youbs\ChargeIO\Connection;
use Youbs\ChargeIO\Credentials;

class RecurringCharge extends Object
{
    public static function create($paymentMethod, $amount, $params = array())
    {
        return self::createUsingCredentials(ChargeIO::getCredentials(), $paymentMethod, $amount, $params);
    }

    public static function createUsingCredentials(Credentials $credentials, $paymentMethod, $amount, $params = array())
    {
        $conn = new Connection($credentials);

        $params['amount'] = $amount;
        if ($paymentMethod instanceof PaymentMethodReference) {
            $params['method'] = $paymentMethod->id;
        } else {
            $params['method'] = $paymentMethod->attributes;
        }

        $response = $conn->post('/recurring/charges', $params);

        return new self($response, $conn);
    }

    public static function all($params = array())
    {
        return self::allUsingCredentials(ChargeIO::getCredentials(), $params);
    }

    public static function allUsingCredentials(Credentials $credentials, $params = array())
    {
        $conn = new Connection($credentials);
        $response = $conn->get('/recurring/charges', $params);

        return new RecurringChargeList($response, $conn);
    }

    public static function findById($id)
    {
        return self::findByIdUsingCredentials(ChargeIO::getCredentials(), $id);
    }

    public static function findByIdUsingCredentials(Credentials $credentials, $id)
    {
        $conn = new Connection($credentials);
        $response = $conn->get('/recurring/charges/'.$id);

        return new self($response, $conn);
    }

    public function update($params = array())
    {
        $response = $this->connection->patch('/recurring/charges/'.$this->id, $params);
        $this->updateAttributes($response);
    }

    public function cancel($params = array())
    {
        $response = $this->connection->post('/recurring/charges/'.$this->id.'/cancel', $params);
        $this->updateAttributes($response);
    }

    public function delete($params = array())
    {
        $response = $this->connection->delete('/recurring/charges/'.$this->id, $params);
        $this->updateAttributes($response);
    }

    public function occurrences($params = array())
    {
        $response = $this->connection->get('/recurring/charges/'.$this->id.'/occurrences', $params);

        return new RecurringChargeOccurrenceList($response, $this->connection);
    }

    public function findOccurrenceById($occurrenceId)
    {
        $response = $this->connection->get('/recurring/charges/'.$this->id.'/occurrences/'.$occurrenceId);

        return new RecurringChargeOccurrence($response, $this->connection);
    }
}
