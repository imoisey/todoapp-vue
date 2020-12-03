<?php

declare(strict_types=1);

namespace App\Task\Test\Unit\Factory;

use App\Task\AntiCorruption\AuthService;
use App\Task\AntiCorruption\Dto\UserDto;
use App\Task\Factory\AuthorFactory;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

/**
 * @covers \App\Task\Factory\AuthorFactory
 */
class AuthorFactoryTest extends TestCase
{
    public function testSuccess(): void
    {
        $id = Uuid::uuid4()->toString();
        $email = 'user@email.ru';

        $authService = $this->createMock(AuthService::class);
        $authService
            ->expects(self::once())
            ->method('getUserById')
            ->with(self::equalTo($id))
            ->willReturnCallback(static function (string $id) use ($email) {
                $userDto = new UserDto();
                $userDto->id = $id;
                $userDto->email = $email;

                return $userDto;
            });

        $author = (new AuthorFactory($authService))->create($id);

        self::assertEquals($id, $author->getId()->getValue());
        self::assertEquals($email, $author->getEmail()->getValue());
    }
}
