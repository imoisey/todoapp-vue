<?php

declare(strict_types=1);

namespace App\Task\Command\Create;

use App\Flusher;
use App\Task\Entity\Task\Id;
use App\Task\Entity\Task\Task;
use App\Task\Entity\Task\TaskRepository;
use App\Task\Factory\AuthorFactory;

class Handler
{
    private TaskRepository $tasks;
    private AuthorFactory $authorFactory;
    private Flusher $flusher;

    public function __construct(TaskRepository $tasks, AuthorFactory $authorFactory, Flusher $flusher)
    {
        $this->tasks = $tasks;
        $this->authorFactory = $authorFactory;
        $this->flusher = $flusher;
    }

    public function handle(Command $command): void
    {
        $author = $this->authorFactory->create($command->author);

        $task = Task::create(
            Id::generate(),
            $author,
            $command->name,
            $command->description
        );

        $this->tasks->add($task);

        $this->flusher->flush();
    }
}
