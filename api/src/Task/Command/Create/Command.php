<?php

declare(strict_types=1);

namespace App\Task\Command\Create;

use Symfony\Component\Validator\Constraints as Assert;

class Command
{
    /**
     * @Assert\Uuid()
     */
    public string $author = '';

    /**
     * @Assert\NotBlank()
     * @Assert\Length(min=3, max=255)
     */
    public string $name = '';


    public string $description = '';
}
