<?php

namespace Youbs\ChargeIO\Model;

use Youbs\ChargeIO\ChargeIO;
use Youbs\ChargeIO\Connection;
use Youbs\ChargeIO\Credentials;

class Signature extends Object
{
    public static function findById($id)
    {
        return self::findByIdUsingCredentials(ChargeIO::getCredentials(), $id);
    }

    public static function findByIdUsingCredentials(Credentials $credentials, $id)
    {
        $conn = new Connection($credentials);
        $response = $conn->get('/signatures/'.$id);

        return new self($response, $conn);
    }
}
