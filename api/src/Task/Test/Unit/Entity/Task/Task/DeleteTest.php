<?php

declare(strict_types=1);

namespace App\Task\Test\Unit\Entity\Task\Task;

use App\Task\Test\Builder\TaskBuilder;
use PHPUnit\Framework\TestCase;

class DeleteTest extends TestCase
{
    public function testSuccess(): void
    {
        $task = (new TaskBuilder())
            ->build();

        $task->delete();

        self::assertTrue($task->isDeleted());
        self::assertFalse($task->isWait());
        self::assertFalse($task->isExecute());
        self::assertFalse($task->isCompleted());
    }

    public function testSame(): void
    {
        $task = (new TaskBuilder())
            ->build();

        $task->delete();

        $this->expectExceptionMessage('Unable to delete task.');

        $task->delete();
    }

    public function testExecuted(): void
    {
        $task = (new TaskBuilder())
            ->doExecute()
            ->build();

        $this->expectExceptionMessage('Unable to delete task.');

        $task->delete();
    }

    public function testCompleted(): void
    {
        $task = (new TaskBuilder())
            ->doComplete()
            ->build();

        $this->expectExceptionMessage('Unable to delete task.');

        $task->delete();
    }
}
