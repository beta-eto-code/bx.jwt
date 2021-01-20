<?php


namespace Bx\JWT;


use Bitrix\Main\ArgumentException;
use Bitrix\Main\ObjectPropertyException;
use Bitrix\Main\SystemException;
use Bx\JWT\Interfaces\UserJWTContextInterface;
use Bx\Model\Interfaces\AccessStrategyInterface;
use Bx\Model\Models\User;
use Bx\JWT\Interfaces\TokenContextInterface;
use Bx\Model\Services\UserService;

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
     * @var UserService
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
    public function __construct(TokenContextInterface $context, UserService $userService)
    {
        $this->context = $context;
        $this->userService = $userService;
    }

    /**
     * @return User
     * @throws ArgumentException
     * @throws ObjectPropertyException
     * @throws SystemException
     */
    public function getUser(): User
    {
        if ($this->user instanceof User) {
            return $this->user;
        }

        return $this->user = $this->userService->getById($this->getUserId());
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
     * @return bool
     * @throws ArgumentException
     * @throws ObjectPropertyException
     * @throws SystemException
     */
    public function hasAccessOperation(int $operationId): bool
    {
        if ($this->accessStrategy instanceof AccessStrategyInterface) {
            return $this->accessStrategy->checkAccess($this->getUser(), $operationId);
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
