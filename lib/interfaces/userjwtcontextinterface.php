<?php

namespace Bx\JWT\Interfaces;

use Bx\Model\Interfaces\UserContextInterface;

interface UserJWTContextInterface extends UserContextInterface
{
    /**
     * @return TokenContextInterface
     */
    public function getTokenContext(): TokenContextInterface;
}
