<?php

namespace Youbs\ChargeIO\Model;

use Youbs\ChargeIO\ChargeIO;
use Youbs\ChargeIO\Connection;
use Youbs\ChargeIO\Credentials;
use Youbs\ChargeIO\Exception\ChargeIOException;

class Transaction extends Object
{
    public static function all($params = array())
    {
        return self::allUsingCredentials(ChargeIO::getCredentials(), $params);
    }

    public static function allUsingCredentials(Credentials $credentials, $params = array())
    {
        $conn = new Connection($credentials);
        $response = $conn->get('/transactions', $params);

        return new TransactionList($response, $conn);
    }

    public static function findById($id)
    {
        return self::findByIdUsingCredentials(ChargeIO::getCredentials(), $id);
    }

    public static function findByIdUsingCredentials(Credentials $credentials, $id)
    {
        $conn = new Connection($credentials);
        $response = $conn->get('/transactions/'.$id);

        return self::parse($response, $conn);
    }

    public static function parse($attributes, Connection $connection = null)
    {
        switch ($attributes['type']) {
            case 'CHARGE':
                return new Charge($attributes, $connection);
            case 'REFUND':
                return new Refund($attributes, $connection);
            case 'CREDIT':
                return new Credit($attributes, $connection);
        }

        throw new ChargeIOException('Unexpected transaction type '.$attributes['type']);
    }

    public function void($params = array())
    {
        $response = $this->connection->post('/transactions/'.$this->id.'/void', $params);
        $this->updateAttributes($response);
    }

    public function sign($signature, $gratuity = null, $mimeType = 'chargeio/jsignature', $params = array())
    {
        $params['data'] = $signature;
        $params['mime_type'] = $mimeType;
        if ($gratuity) {
            $params['gratuity'] = $gratuity;
        }
        $response = $this->connection->post('/transactions/'.$this->id.'/sign', $params);
        $this->updateAttributes($response);
    }
}
