<?php

declare(strict_types=1);

namespace App\Task\AntiCorruption;

use App\Auth\Api\ApiInterface;
use App\Task\AntiCorruption\Dto\UserDto;
use DomainException;

class AuthService
{
    private ApiInterface $auth;

    public function __construct(ApiInterface $auth)
    {
        $this->auth = $auth;
    }

    /**
     * @param string $id
     * @return UserDto
     * @throws DomainException
     */
    public function getUserById(string $id): UserDto
    {
        $user = $this->auth->getUserById($id);

        $result = new UserDto();
        $result->id = $user->id;
        $result->date = $user->date;
        $result->email = $user->email;
        $result->status = $user->status;
        $result->role = $user->role;

        return $result;
    }
}
