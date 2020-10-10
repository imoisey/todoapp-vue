<?php

declare(strict_types=1);

namespace App\Auth\Test\Unit\Entity\User;

use App\Auth\Entity\User\Email;
use App\Auth\Entity\User\Id;
use App\Auth\Entity\User\Token;
use App\Auth\Entity\User\User;
use DateTimeImmutable;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class UserTest extends TestCase
{
    public function testRequestSuccess(): void
    {
        $user = new User(
            $id = Id::generate(),
            $date = new DateTimeImmutable(),
            $email = new Email('username@email.ru'),
            $hash = 'hash',
            $token = new Token(Uuid::uuid4()->toString(), new DateTimeImmutable())
        );

        self::assertEquals($id, $user->getId());
        self::assertEquals($date, $user->getDate());
        self::assertEquals($email, $user->getEmail());
        self::assertEquals($hash, $user->getPasswordHash());
        self::assertEquals($token, $user->getJoinConfirmToken());
    }
}
