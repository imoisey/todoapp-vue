<?php

declare(strict_types=1);

namespace App\Task\Entity\Task;

interface TaskRepository
{
    public function add(Task $task): void;
    public function remove(Task $task): void;
}
