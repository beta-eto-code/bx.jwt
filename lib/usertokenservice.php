<?php

namespace Bx\JWT;

use Bx\JWT\Interfaces\DataPackerInterface;
use Bx\JWT\Interfaces\TokenContextInterface;
use Bx\JWT\Interfaces\UserTokenServiceInterface;
use Bx\JWT\Interfaces\TokenStrategyInterface;
use Bx\Model\Interfaces\UserContextInterface;
use Bx\Model\Interfaces\UserServiceInterface;
use Bx\Model\Services\UserService;

class UserTokenService implements UserTokenServiceInterface
{
    /**
     * @var TokenStrategyInterface
     */
    private $strategy;
    /**
     * @var DataPackerInterface
     */
    private $dataPacker;
    /**
     * @var UserServiceInterface
     */
    private $userService;

    public function __construct(
        TokenStrategyInterface $strategy,
        DataPackerInterface $dataPacker,
        UserServiceInterface $userService
    ) {
        $this->setStrategy($strategy);
        $this->setDataPacker($dataPacker);
        $this->userService = $userService;
    }

    /**
     * @param TokenStrategyInterface $strategy
     */
    public function setStrategy(TokenStrategyInterface $strategy)
    {
        $this->strategy = $strategy;
    }

    /**
     * @param DataPackerInterface $dataPacker
     */
    public function setDataPacker(DataPackerInterface $dataPacker)
    {
        $this->dataPacker = $dataPacker;
    }

    /**
     * @param $uid
     * @return TokenContextInterface
     */
    public function createToken($uid): TokenContextInterface
    {
        return $this->strategy->create($uid, $this->dataPacker);
    }

    /**
     * @param string $token
     * @return TokenContextInterface
     */
    public function readToken(string $token): TokenContextInterface
    {
        return $this->strategy->read($token);
    }

    /**
     * @param string $token
     * @return UserContextInterface
     */
    public function getUserContext(string $token): UserContextInterface
    {
        return new UserContext($this->readToken($token), $this->userService);
    }
}
