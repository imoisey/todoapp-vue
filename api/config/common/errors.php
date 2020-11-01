<?php

declare(strict_types=1);

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Log\LoggerInterface;
use Slim\Interfaces\CallableResolverInterface;
use Slim\Middleware\ErrorMiddleware;

return [
    ErrorMiddleware::class => static function (ContainerInterface $container): ErrorMiddleware {
        /** @var CallableResolverInterface $callableResolver */
        $callableResolver = $container->get(CallableResolverInterface::class);
        /** @var ResponseFactoryInterface $responseFactory */
        $responseFactory = $container->get(ResponseFactoryInterface::class);

        /**
         * @psalm-suppress MixedArrayAccess
         * @psalm-var array{
         *     display_details:bool,
         *     log:bool
         * } $config
         */
        $config = $container->get('config')['errors'];

        /** @var LoggerInterface $logger */
        $logger = $container->get(LoggerInterface::class);

        return new ErrorMiddleware(
            $callableResolver,
            $responseFactory,
            $config['display_details'],
            $config['log'],
            true,
            $logger,
        );
    },

    'config' => [
        'errors' => [
            'display_details' => true,
            'log' => true,
        ],
    ],
];
