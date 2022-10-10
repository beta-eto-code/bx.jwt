<?php

namespace Bx\JWT;

use Bx\JWT\Interfaces\DataPackerInterface;
use Bx\Model\Models\User;
use Bx\Model\Services\UserService;
use Closure;
use Exception;

class UserDataPacker implements DataPackerInterface
{
    /**
     * @var int
     */
    private $ttl;
    /**
     * @var UserService
     */
    private $userService;
    /**
     * @var callable|Closure
     */
    private $fnMapperData;

    /**
     * UserDataPacker constructor.
     * @param int $tokenTTL
     * @param UserService $userService
     * @param callable|null $fnMapperData
     */
    public function __construct(int $tokenTTL, UserService $userService, callable $fnMapperData = null)
    {
        $this->ttl = $tokenTTL;
        $this->userService = $userService;
        $this->fnMapperData = $fnMapperData ?? function (User $user) {
            return [
                'id' => $user->getId(),
                'name' => $user->getName(),
                'last_name' => $user->getLastName(),
                'second_name' => $user->getSecondName(),
                'email' => $user->getEmail(),
            ];
        };
    }

    /**
     * @param $uid
     * @return array
     * @throws Exception
     */
    public function getData($uid): array
    {
        $user = $this->userService->getById((int)$uid);
        if (!$user) {
            return [];
        }

        $userData['data'] = ($this->fnMapperData)($user);
        $userData['uid'] = $uid;

        $unixTime = time();
        $userData['iat'] = $unixTime;
        $userData['exp'] = $unixTime + $this->ttl;

        return $userData;
    }
}
