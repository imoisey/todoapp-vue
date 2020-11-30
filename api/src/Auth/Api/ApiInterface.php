<?php

declare(strict_types=1);

namespace App\Auth\Api;

use App\Auth\Api\Dto\UserDto;

interface ApiInterface
{
    public function getUserById(string $id): UserDto;
}
