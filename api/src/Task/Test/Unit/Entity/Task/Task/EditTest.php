<?php

declare(strict_types=1);

namespace App\Task\Test\Unit\Entity\Task\Task;

use App\Task\Test\Builder\TaskBuilder;
use PHPUnit\Framework\TestCase;

class EditTest extends TestCase
{
    public function testSuccess(): void
    {
        $task = (new TaskBuilder())
            ->build();

        $task->edit(
            $name = 'Edit name',
            $description = 'Edit description'
        );

        self::assertEquals($name, $task->getName());
        self::assertEquals($description, $task->getDescription());
    }

    public function testEmptyName(): void
    {
        $task = (new TaskBuilder())
            ->build();

        $this->expectExceptionMessage('The name cannot be empty.');

        $task->edit(
            $name = '',
            $description = 'Edit description'
        );
    }
}
