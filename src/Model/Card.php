<?php

namespace Youbs\ChargeIO\Model;

use Youbs\ChargeIO\ChargeIO;
use Youbs\ChargeIO\Connection;
use Youbs\ChargeIO\Credentials;

class Card extends Object implements PaymentMethod
{
    public function __construct($attributes = array(), Connection $connection = null)
    {
        parent::__construct($attributes, $connection);
        $this->connection = $connection;
        $this->attributes = array_merge($this->attributes, $attributes);
        $this->attributes['type'] = 'card';
    }

    public static function create($attributes = array())
    {
        return self::createUsingCredentials(ChargeIO::getCredentials(), $attributes);
    }

    public static function createUsingCredentials(Credentials $credentials, $attributes = array())
    {
        $conn = new Connection($credentials);

        $attributes['type'] = 'card';
        $response = $conn->post('/cards', $attributes);

        return new self($response, $conn);
    }

    public static function all($params = array())
    {
        return self::allUsingCredentials(ChargeIO::getCredentials(), $params);
    }

    public static function allUsingCredentials(Credentials $credentials, $params = array())
    {
        $conn = new Connection($credentials);
        $response = $conn->get('/cards', $params);

        return new CardList($response, $conn);
    }

    public static function findById($id)
    {
        return self::findByIdUsingCredentials(ChargeIO::getCredentials(), $id);
    }

    public static function findByIdUsingCredentials(Credentials $credentials, $id)
    {
        $conn = new Connection($credentials);
        $response = $conn->get('/cards/'.$id);

        return new self($response, $conn);
    }

    public function delete()
    {
        $response = $this->connection->delete('/cards/'.$this->id);
        $this->updateAttributes($response);
    }
}
