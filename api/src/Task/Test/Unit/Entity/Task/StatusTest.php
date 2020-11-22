<?php

declare(strict_types=1);

namespace App\Task\Test\Unit\Entity\Task;

use App\Task\Entity\Task\Status;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

/**
 * @covers \App\Task\Entity\Task\Status
 */
class StatusTest extends TestCase
{
    public function testSuccess(): void
    {
        $status = new Status($name = Status::WAIT);

        self::assertEquals($name, $status->getName());
    }

    public function testIncorrect(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new Status('none');
    }

    public function testWait(): void
    {
        $status = Status::wait();

        self::assertTrue($status->isWait());
        self::assertFalse($status->isExecute());
        self::assertFalse($status->isCompleted());
        self::assertFalse($status->isDeleted());
    }

    public function testExecute(): void
    {
        $status = Status::execute();

        self::assertTrue($status->isExecute());
        self::assertFalse($status->isWait());
        self::assertFalse($status->isCompleted());
        self::assertFalse($status->isDeleted());
    }

    public function testComplete(): void
    {
        $status = Status::complete();

        self::assertTrue($status->isCompleted());
        self::assertFalse($status->isWait());
        self::assertFalse($status->isExecute());
        self::assertFalse($status->isDeleted());
    }

    public function testDeleted(): void
    {
        $status = Status::delete();

        self::assertTrue($status->isDeleted());
        self::assertFalse($status->isWait());
        self::assertFalse($status->isExecute());
        self::assertFalse($status->isCompleted());
    }
}
