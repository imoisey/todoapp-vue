<?php

declare(strict_types=1);

use App\Task\Entity\Task\DoctrineTaskRepository;
use App\Task\Entity\Task\Task;
use App\Task\Entity\Task\TaskRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Psr\Container\ContainerInterface;

return [
    TaskRepository::class => static function (ContainerInterface $container): TaskRepository {
        /** @var EntityManagerInterface $em */
        $em = $container->get(EntityManagerInterface::class);
        /** @var EntityRepository $repository */
        $repository = $em->getRepository(Task::class);
        return new DoctrineTaskRepository($em, $repository);
    },

    'config' => [
        'task' => [

        ],
    ]
];
