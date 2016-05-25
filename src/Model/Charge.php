<?php

namespace Youbs\ChargeIO\Model;

use Youbs\ChargeIO\ChargeIO;
use Youbs\ChargeIO\Connection;
use Youbs\ChargeIO\Credentials;

class Charge extends Transaction
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

        $response = $conn->post('/charges', $params);

        return new self($response, $conn);
    }

    public static function authorize($paymentMethod, $amount, $params = array())
    {
        return self::authorizeUsingCredentials(ChargeIO::getCredentials(), $paymentMethod, $amount, $params);
    }

    public static function authorizeUsingCredentials(Credentials $credentials, $paymentMethod, $amount, $params = array())
    {
        return self::createUsingCredentials($credentials, $paymentMethod, $amount, array_merge($params, array('auto_capture' => false)));
    }

    public function refund($amount, $params = array())
    {
        $params['amount'] = $amount;
        $response = $this->connection->post('/charges/'.$this->id.'/refund', $params);

        return new Refund($response, $this->connection);
    }

    public function capture($amount, $params = array())
    {
        $params['amount'] = $amount;
        $response = $this->connection->post('/charges/'.$this->id.'/capture', $params);
        $this->updateAttributes($response);
    }

    public static function allHolds($params = array())
    {
        return self::allHoldsUsingCredentials(ChargeIO::getCredentials(), $params);
    }

    public static function allHoldsUsingCredentials(Credentials $credentials, $params = array())
    {
        $conn = new Connection($credentials);
        $response = $conn->get('/charges/holds', $params);

        return new TransactionList($response, $conn);
    }
}
