<?php

namespace Youbs\ChargeIO\Model;

use Youbs\ChargeIO\ChargeIO;
use Youbs\ChargeIO\Connection;
use Youbs\ChargeIO\Credentials;

class Credit extends Transaction
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

        $response = $conn->post('/credits', $params);

        return new self($response, $conn);
    }
}
