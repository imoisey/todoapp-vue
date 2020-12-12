<?php

declare(strict_types=1);

namespace App\Task\Entity\Task;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use DomainException;

class DoctrineTaskRepository implements TaskRepository
{
    private EntityManagerInterface $em;
    private EntityRepository $repository;

    public function __construct(EntityManagerInterface $em, EntityRepository $repository)
    {
        $this->em = $em;
        $this->repository = $repository;
    }

    public function get(Id $id): Task
    {
        if (!$task = $this->repository->find($id->getValue())) {
            throw new DomainException('Task not found.');
        }

        /** @var Task $task */
        return $task;
    }

    public function add(Task $task): void
    {
        $this->em->persist($task);
    }

    public function remove(Task $task): void
    {
        $this->em->remove($task);
    }
}
