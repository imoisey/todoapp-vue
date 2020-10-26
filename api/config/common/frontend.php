<?php

declare(strict_types=1);

use App\Frontend\UrlGenerator;
use Psr\Container\ContainerInterface;

return [
    UrlGenerator::class => static function (ContainerInterface $container) {
        /**
         * @psalm-suppress MixedArrayAccess
         * @psalm-var array{url:string} $config
         */
        $config = $container->get('config')['frontend'];

        return new UrlGenerator($config['url']);
    },

    'config' => [
        'frontend' => [
            'url' => getenv('FRONTEND_URL'),
        ],
    ],
];
