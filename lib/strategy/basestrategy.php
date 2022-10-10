<?php

namespace Bx\JWT\Strategy;

use Bitrix\Main\Config\Option;
use Bx\JWT\Interfaces\TokenStrategyInterface;

abstract class BaseStrategy implements TokenStrategyInterface
{
    /**
     * @var string
     */
    private $key;

    public function __construct(?string $key = null)
    {
        $this->key = $key ?? (string)Option::get('bx.jwt', 'JWT_SECRET');
    }

    protected function getKey(): string
    {
        return $this->key;
    }
}
