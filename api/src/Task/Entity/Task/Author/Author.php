<?php

declare(strict_types=1);

namespace App\Task\Entity\Task\Author;

class Author
{
    private Id $id;

    private Email $email;

    public function __construct(Id $id, Email $email)
    {
        $this->id = $id;
        $this->email = $email;
    }

    public function getId(): Id
    {
        return $this->id;
    }

    public function getEmail(): Email
    {
        return $this->email;
    }
}
