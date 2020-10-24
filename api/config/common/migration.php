<?php

declare(strict_types=1);

use Doctrine\Migrations\Configuration\EntityManager\ExistingEntityManager;
use Doctrine\Migrations\Configuration\Migration\ConfigurationArray;
use Doctrine\Migrations\DependencyFactory;
use Doctrine\Migrations\Tools\Console\Command;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Container\ContainerInterface;

return [
    DependencyFactory::class => static function (ContainerInterface $container): DependencyFactory {
        /**
         * @psalm-suppress MixedArrayAccess
         * @psalm-var array{
         *     table_storage:array,
         *     migrations_paths:array,
         *     all_or_nothing:bool,
         *     check_database_platform:bool
         * } $settings
         */
        $settings = $container->get('config')['console']['migration'];
        $configuration = new ConfigurationArray($settings);

        /** @var EntityManagerInterface $entityManager */
        $entityManager = $container->get(EntityManagerInterface::class);

        return DependencyFactory::fromEntityManager($configuration, new ExistingEntityManager($entityManager));
    },

    'Doctrine\Migrations\Tools\Console\Command\*Command' => DI\autowire()
        ->constructorParameter('dependencyFactory', DI\get(DependencyFactory::class)),

    'config' => [
        'console' => [
            'commands' => [
                Command\ExecuteCommand::class,
                Command\MigrateCommand::class,
                Command\LatestCommand::class,
                Command\StatusCommand::class,
                Command\UpToDateCommand::class,
            ],
            'migration' => [
                'table_storage' => [
                    'table_name' => 'migrations'
                ],

                'migrations_paths' => [
                    'App\Data\Migration' => __DIR__ . '/../../src/Data/Migration'
                ],

                'all_or_nothing' => true,
                'check_database_platform' => false,
            ],
        ],
    ],
];
