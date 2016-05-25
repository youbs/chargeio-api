<?php

namespace Youbs\ChargeIO\Model;

use Youbs\ChargeIO\ChargeIO;
use Youbs\ChargeIO\Connection;
use Youbs\ChargeIO\Credentials;

class OneTimeToken extends Object implements PaymentMethod
{
    public function __construct($attributes = array(), Connection $connection = null)
    {
        parent::__construct($attributes, $connection);
        $this->connection = $connection;
        $this->attributes = array_merge($this->attributes, $attributes);
        $this->attributes['type'] = 'card';
    }

    public static function createOneTimeCard($attributes = array())
    {
        return self::createOneTimeCardUsingCredentials(ChargeIO::getCredentials(), $attributes);
    }

    public static function createOneTimeCardUsingCredentials(Credentials $credentials, $attributes = array())
    {
        $conn = new Connection($credentials);

        $attributes['type'] = 'card';
        $response = $conn->post('/tokens', $attributes);

        return new self($response, $conn);
    }

    public static function createOneTimeBank($attributes = array())
    {
        return self::createOneTimeBankUsingCredentials(ChargeIO::getCredentials(), $attributes);
    }

    public static function createOneTimeBankUsingCredentials(Credentials $credentials, $attributes = array())
    {
        $conn = new Connection($credentials);

        $attributes['type'] = 'bank';
        $response = $conn->post('/tokens', $attributes);

        return new self($response, $conn);
    }
}
