<?php

declare(strict_types=1);

use Doctrine\Migrations\Tools\Console\Command;

return [
    'config' => [
        'console' => [
            'commands' => [
                Command\DiffCommand::class,
                Command\GenerateCommand::class,
            ],
        ],
    ],
];
