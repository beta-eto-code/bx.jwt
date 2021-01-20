<?php

namespace Bx\JWT\Interfaces;

interface TokenMakerInterface
{
    /**
     * @param $uid
     * @param DataPackerInterface $dataPacker
     * @return TokenContextInterface
     */
    public function create($uid, DataPackerInterface $dataPacker): TokenContextInterface;
}
