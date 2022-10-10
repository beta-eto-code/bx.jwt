<?php

namespace Bx\JWT\Interfaces;

interface DataPackerInterface
{
    public function getData($uid): array;
}
