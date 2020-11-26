<?php

declare(strict_types=1);

namespace App\Task\Test\Unit\Entity\Task\Task;

use App\Task\Test\Builder\TaskBuilder;
use DateTimeImmutable;
use PHPUnit\Framework\TestCase;

class CompleteTest extends TestCase
{
    public function testSuccess(): void
    {
        $task = (new TaskBuilder())
            ->doExecute()
            ->build();

        $task->complete();

        self::assertTrue($task->isCompleted());
        self::assertFalse($task->isWait());
        self::assertFalse($task->isExecute());
        self::assertFalse($task->isDeleted());

        self::assertInstanceOf(DateTimeImmutable::class, $task->getCompletedDate());
    }

    public function testSame(): void
    {
        $task = (new TaskBuilder())
            ->doExecute()
            ->build();

        $task->complete();

        $this->expectExceptionMessage('Unable to complete task.');

        $task->complete();
    }

    public function testWait(): void
    {
        $task = (new TaskBuilder())
            ->build();

        $this->expectExceptionMessage('Unable to complete task.');

        $task->complete();
    }

    public function testDeleted(): void
    {
        $task = (new TaskBuilder())
            ->doDelete()
            ->build();

        $this->expectExceptionMessage('Unable to complete task.');

        $task->complete();
    }
}
