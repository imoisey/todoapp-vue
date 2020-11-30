<?php

declare(strict_types=1);

namespace App\Auth\Contract;

use App\Auth\Contract\Dto\UserDto;

interface ContractInterface
{
    public function getUserById(string $id): UserDto;
}
