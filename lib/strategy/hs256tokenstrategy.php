<?php

namespace Bx\JWT\Strategy;

use Bitrix\Main\Web\JWT;
use Bx\JWT\Interfaces\DataPackerInterface;
use Bx\JWT\Interfaces\TokenContextInterface;
use Bx\JWT\Interfaces\TokenMaker;
use Bx\JWT\TokenContext;

class HS256TokenStrategy extends BaseStrategy
{
    const ALG = 'HS256';

    public function read(string $token): TokenContextInterface
    {
        $jwt = JWT::decode($token, $this->getKey(), [static::ALG]);

        return new TokenContext($token, (array)$jwt);
    }

    /**
     * @param $uid
     * @param DataPackerInterface $dataPacker
     * @return TokenContextInterface
     */
    public function create($uid, DataPackerInterface $dataPacker): TokenContextInterface
    {
        $data = $dataPacker->getData($uid);
        $token = JWT::encode($data, $this->getKey(), static::ALG);

        return new TokenContext($token, $data);
    }
}

