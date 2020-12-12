<?php

declare(strict_types=1);

namespace App\Task\Command\Execute;

use App\Flusher;
use App\Task\Entity\Task\Id;
use App\Task\Entity\Task\TaskRepository;

class Handler
{
    private TaskRepository $tasks;
    private Flusher $flusher;

    public function __construct(TaskRepository $tasks, Flusher $flusher)
    {
        $this->tasks = $tasks;
        $this->flusher = $flusher;
    }

    public function handle(Command $command): void
    {
        $task = $this->tasks->get(new Id($command->id));

        $task->execute();

        $this->flusher->flush();
    }
}
