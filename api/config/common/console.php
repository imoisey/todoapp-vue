<?php

declare(strict_types=1);

use App\Console\Command\HelloCommand;

return [
    'config' => [
        'console' => [
            'commands' => [
                HelloCommand::class
            ]
        ]
    ]
];
