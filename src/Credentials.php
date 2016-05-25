<?php

namespace Youbs\ChargeIO;

class Credentials
{
    private $publicKey;
    private $secretKey;

    public function __construct($publicKey, $secretKey)
    {
        $this->publicKey = $publicKey;
        $this->secretKey = $secretKey;
    }

    public function getPublicKey()
    {
        return $this->publicKey;
    }

    public function getSecretKey()
    {
        return $this->secretKey;
    }
}
