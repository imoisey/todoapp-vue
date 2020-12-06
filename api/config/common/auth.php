<?php

declare(strict_types=1);

use App\Auth\Api\Api;
use App\Auth\Api\ApiInterface;
use App\Auth\Entity\User\DoctrineUserRepository;
use App\Auth\Entity\User\User;
use App\Auth\Entity\User\UserRepository;
use App\Auth\Service\Tokenizer;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Psr\Container\ContainerInterface;

return [
    ApiInterface::class => static function (ContainerInterface $container): ApiInterface {
        /** @var UserRepository $users */
        $users = $container->get(UserRepository::class);
        return new Api($users);
    },

    UserRepository::class => static function (ContainerInterface $container): UserRepository {
        /** @var EntityManagerInterface $em */
        $em = $container->get(EntityManagerInterface::class);
        /** @var EntityRepository $repository */
        $repository = $em->getRepository(User::class);
        return new DoctrineUserRepository($em, $repository);
    },

    Tokenizer::class => static function (ContainerInterface $container): Tokenizer {
        /**
         * @psalm-suppress MixedArrayAccess
         * @psalm-var array{token_ttl:string} $config
         */
        $config = $container->get('config')['auth'];

        return new Tokenizer(new DateInterval($config['token_ttl']));
    },

    'config' => [
        'auth' => [
            'token_ttl' => 'PT1H',
        ],
    ],
];
