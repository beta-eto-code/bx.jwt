<?php

namespace Bx\JWT\Strategy;

use Bitrix\Main\Web\JWT;
use Bx\JWT\Interfaces\DataPackerInterface;
use Bx\JWT\Interfaces\TokenContextInterface;
use Bx\JWT\TokenContext;

class RS256TokenStrategy extends BaseStrategy
{
    private const ALG = 'RS256';

    public function read(string $token): TokenContextInterface
    {
        $jwt = JWT::decode($token, $this->getKey(), [static::ALG]);
        return new TokenContext($token, (array)$jwt);
    }

    public function create($uid, DataPackerInterface $dataPacker): TokenContextInterface
    {
        $data = $dataPacker->getData($uid);
        $token = JWT::encode($data, $this->getKey(), static::ALG);
        return new TokenContext($token, $data);
    }
}
