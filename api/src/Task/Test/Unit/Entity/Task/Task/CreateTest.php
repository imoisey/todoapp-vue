<?php

declare(strict_types=1);

namespace App\Task\Test\Unit\Entity\Task\Task;

use App\Task\Entity\Task\Author\Author;
use App\Task\Entity\Task\Author\Email;
use App\Task\Entity\Task\Author\Id as AuthorId;
use App\Task\Entity\Task\Id;
use App\Task\Entity\Task\Task;
use PHPUnit\Framework\TestCase;

class CreateTest extends TestCase
{
    public function testSuccess(): void
    {
        $author = new Author(
            new AuthorId('00000000-0000-0000-0000-000000000001'),
            new Email('user@email.ru')
        );

        $task = Task::create(
            $id = Id::generate(),
            $author,
            $name = 'New Task',
            $description = 'Description',
        );

        self::assertEquals($id, $task->getId());
        self::assertEquals($author, $task->getAuthor());
        self::assertEquals($name, $task->getName());
        self::assertEquals($description, $task->getDescription());

        self::assertTrue($task->isWait());
        self::assertFalse($task->isExecute());
        self::assertFalse($task->isCompleted());
        self::assertFalse($task->isDeleted());
    }
}
