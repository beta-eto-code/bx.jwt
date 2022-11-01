<?php

namespace Bx\JWT;

use Bitrix\Main\ArgumentException;
use Bitrix\Main\ObjectPropertyException;
use Bitrix\Main\SystemException;
use Bx\JWT\Interfaces\UserJWTContextInterface;
use Bx\Model\Interfaces\AccessStrategyInterface;
use Bx\Model\Interfaces\UserServiceInterface;
use Bx\Model\Models\User;
use Bx\JWT\Interfaces\TokenContextInterface;
use Bx\Model\Services\UserService;
use Exception;

class UserContext implements UserJWTContextInterface
{
    /**
     * @var TokenContextInterface
     */
    private $context;
    /**
     * @var User
     */
    private $user;
    /**
     * @var UserServiceInterface
     */
    private $userService;
    /**
     * @var AccessStrategyInterface
     */
    private $accessStrategy;

    /**
     * UserContext constructor.
     * @param TokenContextInterface $context
     * @param UserService $userService
     */
    public function __construct(TokenContextInterface $context, UserServiceInterface $userService)
    {
        $this->context = $context;
        $this->userService = $userService;
    }

    /**
     * @return User
     * @throws ArgumentException
     * @throws ObjectPropertyException
     * @throws SystemException
     * @throws Exception
     */
    public function getUser(): User
    {
        if ($this->user instanceof User) {
            return $this->user;
        }

        $user = $this->userService->getById($this->getUserId());
        if (empty($user)) {
            throw new Exception('user is not found');
        }

        if (!($user instanceof User)) {
            throw new Exception('invalid user model, excepted Bx\Model\Models\User');
        }

        return $this->user = $user;
    }

    /**
     * @return int
     */
    public function getUserId(): int
    {
        return (int)$this->context->getUid();
    }

    /**
     * @param int $operationId
     * @param string $scope
     * @return bool
     * @throws ArgumentException
     * @throws ObjectPropertyException
     * @throws SystemException
     */
    public function hasAccessOperation(int $operationId, string $scope = ''): bool
    {
        if ($this->accessStrategy instanceof AccessStrategyInterface) {
            return $this->accessStrategy->checkAccess($this->getUser(), $operationId, $scope);
        }

        return true;
    }

    /**
     * @return TokenContextInterface
     */
    public function getTokenContext(): TokenContextInterface
    {
        return $this->context;
    }

    /**
     * @param AccessStrategyInterface $accessStrategy
     */
    public function setAccessStrategy(AccessStrategyInterface $accessStrategy)
    {
        $this->accessStrategy = $accessStrategy;
    }
}
