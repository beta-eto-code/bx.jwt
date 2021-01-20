<?php


namespace Bx\JWT;


use Bx\JWT\Interfaces\DataPackerInterface;
use Bx\Model\Services\UserService;
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
     * UserDataPacker constructor.
     * @param int $tokenTTL
     * @param UserService $userService
     */
    public function __construct(int $tokenTTL, UserService $userService)
    {
        $this->ttl = $tokenTTL;
        $this->userService = $userService;
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

        $userData['data'] = $user->getApiModel();
        $userData['uid'] = $uid;

        $unixTime = time();
        $userData['iat'] = $unixTime;
        $userData['exp'] = $unixTime + $this->ttl;

        return $userData;
    }
}
