<?php

namespace Bx\JWT\Interfaces;

use Bx\Model\Interfaces\UserContextInterface;

interface UserTokenServiceInterface extends TokenServiceInterface
{
    public function getUserContext(string $token): UserContextInterface;
}
