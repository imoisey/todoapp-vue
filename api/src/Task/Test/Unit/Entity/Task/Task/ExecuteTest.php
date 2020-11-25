<?php

declare(strict_types=1);

namespace App\Task\Test\Unit\Entity\Task\Task;

use App\Task\Test\Builder\TaskBuilder;
use PHPUnit\Framework\TestCase;

class ExecuteTest extends TestCase
{
    public function testSuccess(): void
    {
        $task = (new TaskBuilder())
            ->build();

        $task->execute();

        self::assertTrue($task->isExecute());
        self::assertFalse($task->isWait());
        self::assertFalse($task->isCompleted());
        self::assertFalse($task->isDeleted());
    }

    public function testSame(): void
    {
        $task = (new TaskBuilder())
            ->build();

        $task->execute();

        $this->expectExceptionMessage('Unable to execute task.');

        $task->execute();
    }

    public function testDeleted(): void
    {
        $task = (new TaskBuilder())
            ->build();

        $task->delete();

        $this->expectExceptionMessage('Unable to execute task.');

        $task->execute();
    }

    public function testCompleted(): void
    {
        $task = (new TaskBuilder())
            ->doExecute()
            ->build();

        $task->complete();

        $this->expectExceptionMessage('Unable to execute task.');

        $task->execute();
    }
}
