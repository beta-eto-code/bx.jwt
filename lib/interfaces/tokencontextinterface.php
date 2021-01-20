<?php


namespace Bx\JWT\Interfaces;


interface TokenContextInterface
{
    /**
     * @return bool
     */
    public function isExpired(): bool;

    /**
     * @return bool
     */
    public function isValid(): bool;

    /**
     * @return array
     */
    public function getData(): array;

    /**
     * @return UserContext|null
     */

    /**
     * @return mixed
     */
    public function getUid();

    /**
     * @return string
     */
    public function __toString();
}
