<?php

declare(strict_types=1);

namespace App\Task\Entity\Task;

use DomainException;

interface TaskRepository
{
    /**
     * @param Id $id
     * @return Task
     * @throws DomainException
     */
    public function get(Id $id): Task;

    public function add(Task $task): void;
    public function remove(Task $task): void;
}
