<?php

namespace Youbs\ChargeIO\Model;

use Youbs\ChargeIO\ChargeIO;
use Youbs\ChargeIO\Connection;
use Youbs\ChargeIO\Credentials;

class Merchant extends Object
{
    public function __construct($attributes = array(), Connection $connection = null)
    {
        parent::__construct($attributes, $connection);
        $this->connection = $connection;
        $this->attributes = array_merge($this->attributes, $attributes);
    }

    public static function findCurrent()
    {
        return self::findCurrentUsingCredentials(ChargeIO::getCredentials());
    }

    public static function findCurrentUsingCredentials(Credentials $credentials)
    {
        $conn = new Connection($credentials);
        $response = $conn->get('/merchant');

        return new self($response, $conn);
    }

    public function update($attributes = array())
    {
        $merchantAttrs = array_merge($this->attributes, $attributes);
        unset($merchantAttrs['merchant_accounts']);
        unset($merchantAttrs['ach_accounts']);
        $response = $this->connection->put('/merchant', $merchantAttrs);
        $this->updateAttributes($response);
    }

    public function merchantAccounts()
    {
        $accounts = array();

        if (array_key_exists('merchant_accounts', $this->attributes)) {
            foreach ($this->attributes['merchant_accounts'] as $accountAttrs) {
                array_push($accounts, new MerchantAccount($accountAttrs, $this->connection));
            }
        }

        return $accounts;
    }

    public function achAccounts()
    {
        $accounts = array();

        if (array_key_exists('ach_accounts', $this->attributes)) {
            foreach ($this->attributes['ach_accounts'] as $accountAttrs) {
                array_push($accounts, new AchAccount($accountAttrs, $this->connection));
            }
        }

        return $accounts;
    }
}
