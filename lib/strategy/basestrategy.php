<?php

namespace Bx\JWT\Strategy;

use Bitrix\Main\Config\Option;
use Bx\JWT\Interfaces\TokenStrategyInterface;
use Exception;

abstract class BaseStrategy implements TokenStrategyInterface
{
    /**
     * @var string
     */
    private $key;

    /**
     * @param string|null $key
     * @throws Exception
     */
    public function __construct(?string $key = null)
    {
        $this->key = $key ?: (string)Option::get('bx.jwt', 'JWT_SECRET');
        if (empty($this->key)) {
            throw new Exception('JWT private key is empty');
        }
    }

    protected function getKey(): string
    {
        return $this->key;
    }
}
