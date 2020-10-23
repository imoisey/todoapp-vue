<?php

declare(strict_types=1);

use App\Auth\Entity\User\DoctrineUserRepository;
use App\Auth\Entity\User\User;
use App\Auth\Entity\User\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Psr\Container\ContainerInterface;

return [
    UserRepository::class => static function (ContainerInterface $container): UserRepository {
        /** @var EntityManagerInterface $em */
        $em = $container->get(EntityManagerInterface::class);
        /** @var EntityRepository $repository */
        $repository = $em->getRepository(User::class);
        return new DoctrineUserRepository($em, $repository);
    },
];
