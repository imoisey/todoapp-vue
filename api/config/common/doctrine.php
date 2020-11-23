<?php

declare(strict_types=1);

use App\Auth;
use App\Task;
use App\DoctrineFlusher;
use App\Flusher;
use Doctrine\Common\Cache\ArrayCache;
use Doctrine\Common\Cache\FilesystemCache;
use Doctrine\Common\EventManager;
use Doctrine\Common\EventSubscriber;
use Doctrine\DBAL\Types\Type;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\UnderscoreNamingStrategy;
use Doctrine\ORM\Tools\Setup;
use Psr\Container\ContainerInterface;

return [
    EntityManagerInterface::class => static function (ContainerInterface $container): EntityManagerInterface {
        /**
         * @psalm-suppress MixedArrayAccess
         * @psalm-var array{
         *     metadata_dirs:array,
         *     dev_mode:bool,
         *     proxy_dir:string,
         *     cache_dir:?string,
         *     types:array<string,string>,
         *     subscribers:string[],
         *     connection:array
         * } $settings
         */
        $settings = $container->get('config')['doctrine'];

        $config = Setup::createAnnotationMetadataConfiguration(
            $settings['metadata_dirs'],
            $settings['dev_mode'],
            $settings['proxy_dir'],
            $settings['cache_dir'] ? new FilesystemCache($settings['cache_dir']) : new ArrayCache(),
            false
        );

        $config->setNamingStrategy(new UnderscoreNamingStrategy());

        foreach ($settings['types'] as $name => $class) {
            if (!Type::hasType($name)) {
                /** @psalm-suppress ArgumentTypeCoercion */
                Type::addType($name, $class);
            }
        }

        $eventManager = new EventManager();

        foreach ($settings['subscribers'] as $name) {
            /** @var EventSubscriber $subscriber */
            $subscriber = $container->get($name);
            $eventManager->addEventSubscriber($subscriber);
        }

        return EntityManager::create(
            $settings['connection'],
            $config,
            $eventManager
        );
    },

    Flusher::class => static function (ContainerInterface $container): Flusher {
        /** @var EntityManagerInterface $em */
        $em = $container->get(EntityManagerInterface::class);

        return new DoctrineFlusher($em);
    },

    'config' => [
        'doctrine' => [
            'dev_mode' => false,
            'cache_dir' => __DIR__ . '/../../var/cache/doctrine/cache',
            'proxy_dir' => __DIR__ . '/../../var/cache/doctrine/proxy',
            'connection' => [
                'driver' => 'pdo_pgsql',
                'url' => getenv('DB_URL'),
                'charset' => 'utf-8'
            ],
            'subscribers' => [],
            'metadata_dirs' => [
                __DIR__ . '/../../src/Auth/Entity',
                __DIR__ . '/../../src/Task/Entity',
            ],
            'types' => [
                Auth\Entity\User\IdType::NAME => Auth\Entity\User\IdType::class,
                Auth\Entity\User\EmailType::NAME => Auth\Entity\User\EmailType::class,
                Auth\Entity\User\RoleType::NAME => Auth\Entity\User\RoleType::class,
                Auth\Entity\User\StatusType::NAME => Auth\Entity\User\StatusType::class,

                Task\Entity\Task\IdType::NAME => Task\Entity\Task\IdType::class,
                Task\Entity\Task\StatusType::NAME => Task\Entity\Task\StatusType::class,
                Task\Entity\Task\Author\IdType::NAME => Task\Entity\Task\Author\IdType::class,
                Task\Entity\Task\Author\EmailType::NAME => Task\Entity\Task\Author\EmailType::class,
            ]
        ],
    ],
];
