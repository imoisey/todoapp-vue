<?php

declare(strict_types=1);

return [
    'config' => [
        'twig' => [
            'debug' => true,
            'cache_dir' => __DIR__ . '/../../var/cache/' . PHP_SAPI . '/twig',
        ],
    ],
];
