<?php

declare(strict_types=1);

namespace App\Auth\Api;

use App\Auth\Api\Dto\UserDto;
use App\Auth\Entity\User\Id;
use App\Auth\Entity\User\UserRepository;
use DomainException;

class Api implements ApiInterface
{
    private UserRepository $users;

    public function __construct(UserRepository $users)
    {
        $this->users = $users;
    }

    /**
     * @param string $id
     * @return UserDto
     * @throws DomainException
     */
    public function getUserById(string $id): UserDto
    {
        $user =  $this->users->get(new Id($id));

        $userDto = new UserDto();
        $userDto->id = $user->getId()->getValue();
        $userDto->date = $user->getDate();
        $userDto->email = $user->getEmail()->getValue();
        $userDto->status = $user->getStatus()->getName();
        $userDto->role = $user->getRole()->getName();

        return $userDto;
    }
}
