<?php

declare(strict_types=1);

namespace App\Task\Factory;

use App\Task\AntiCorruption\AuthService;
use App\Task\Entity\Task\Author\Author;
use App\Task\Entity\Task\Author\Email;
use App\Task\Entity\Task\Author\Id;

class AuthorFactory
{
    private AuthService $auth;

    public function __construct(AuthService $auth)
    {
        $this->auth = $auth;
    }

    public function create(string $id): Author
    {
        $userDto = $this->auth->getUserById($id);

        return new Author(new Id($id), new Email($userDto->email));
    }
}
