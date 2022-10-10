<?php

namespace Bx\JWT\Interfaces;

interface TokenReaderInterface
{
    /**
     * TokenReader constructor.
     * @param string $token
     * @return TokenContextInterface
     */
    public function read(string $token): TokenContextInterface;
}
