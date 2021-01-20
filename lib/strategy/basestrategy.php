<?php


namespace Bx\JWT\Strategy;


use Bitrix\Main\Config\Option;
use Bx\JWT\Interfaces\TokenStrategyInterface;

abstract class BaseStrategy implements TokenStrategyInterface
{
    protected function getKey(): string
    {
        return (string)Option::get('bx.jwt', 'JWT_SECRET');
    }
}
