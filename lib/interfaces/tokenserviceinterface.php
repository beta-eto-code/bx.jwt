<?php


namespace Bx\JWT\Interfaces;


interface TokenServiceInterface
{
    /**
     * @param TokenStrategyInterface $strategy
     * @return void
     */
    public function setStrategy(TokenStrategyInterface $strategy);

    /**
     * @param DataPackerInterface $dataPacker
     * @return void
     */
    public function setDataPacker(DataPackerInterface $dataPacker);

    /**
     * @param $uid
     * @return TokenContextInterface
     */
    public function createToken($uid): TokenContextInterface;

    /**
     * @param string $token
     * @return TokenContextInterface
     */
    public function readToken(string $token): TokenContextInterface;
}
