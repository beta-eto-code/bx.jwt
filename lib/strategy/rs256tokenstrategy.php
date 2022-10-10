<?php

namespace Bx\JWT\Strategy;

use Bitrix\Main\Web\JWT;
use Bx\JWT\Interfaces\DataPackerInterface;
use Bx\JWT\Interfaces\TokenContextInterface;
use Bx\JWT\TokenContext;
use Exception;

class RS256TokenStrategy extends BaseStrategy
{
    private const ALG = 'RS256';

    public function __construct(?string $privateKey = null, ?string $publicKey = null)
    {
        parent::__construct($privateKey, $publicKey);
        if (empty($this->getPublicKey())) {
            throw new Exception('JWT public key is empty');
        }
    }

    public function read(string $token): TokenContextInterface
    {
        $jwt = JWT::decode($token, $this->getPublicKey(), [static::ALG]);
        return new TokenContext($token, (array)$jwt);
    }

    public function create($uid, DataPackerInterface $dataPacker): TokenContextInterface
    {
        $data = $dataPacker->getData($uid);
        $token = JWT::encode($data, $this->getKey(), static::ALG);
        return new TokenContext($token, $data);
    }
}
