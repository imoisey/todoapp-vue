<?php

declare(strict_types=1);

namespace App\Task\Command\Modify;

use Symfony\Component\Validator\Constraints as Assert;

class Command
{
    /**
     * @Assert\NotBlank()
     * @Assert\Uuid()
     */
    public string $id = '';
    /**
     * @Assert\NotBlank()
     * @Assert\Length(min=3, max=255)
     */
    public string $name = '';

    public string $description = '';
}
