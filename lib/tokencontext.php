<?php


namespace Bx\JWT;


use Bx\JWT\Interfaces\TokenContextInterface;

class TokenContext implements TokenContextInterface
{
    /**
     * @var string
     */
    private $token;
    /**
     * @var array
     */
    private $data;

    public function __construct(string $token, array $data)
    {
        $this->token = $token;
        $this->data = $data;
    }

    public function isExpired(): bool
    {
        $unixTime = (int)$this->data['ttl'];
        return $unixTime <= time();
    }

    public function isValid(): bool
    {
        return !$this->isExpired();
    }

    public function getData(): array
    {
        return $this->data;
    }

    public function getUid()
    {
        return $this->data['uid'];
    }

    public function __toString()
    {
        return $this->token;
    }
}
