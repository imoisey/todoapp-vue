<?php

declare(strict_types=1);

namespace App\Auth\Test\Unit\Entity\User;

use App\Auth\Entity\User\Email;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

/**
 * @covers Email
 */
class EmailTest extends TestCase
{
    public function testSuccess(): void
    {
        $email = new Email($value = 'username@email.ru');

        self::assertEquals($value, $email->getValue());
    }

    public function testIncorrect(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new Email('not-email');
    }

    public function testCase(): void
    {
        $email = new Email('uSeRname@Email.Ru');

        self::assertEquals('username@email.ru', $email->getValue());
    }

    public function testEmpty(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new Email('');
    }
}
