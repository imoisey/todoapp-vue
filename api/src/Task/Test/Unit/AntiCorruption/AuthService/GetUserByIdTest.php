<?php

declare(strict_types=1);

namespace App\Task\Test\Unit\AntiCorruption\AuthService;

use App\Auth\Api\ApiInterface;
use App\Auth\Api\Dto\UserDto as AuthUserDto;
use App\Task\AntiCorruption\AuthService;
use DomainException;
use PHPUnit\Framework\TestCase;

class GetUserByIdTest extends TestCase
{
    private const USER_ID = '00000000-0000-0000-0000-000000000001';

    public function testSuccess(): void
    {
        $authUserDto = new AuthUserDto();

        $api = $this->createMock(ApiInterface::class);
        $api->expects(self::once())->method('getUserById')->with(
            self::equalTo(self::USER_ID)
        )->willReturn($authUserDto);

        $authService = new AuthService($api);
        $authService->getUserById(self::USER_ID);
    }

    public function testException(): void
    {
        $api = $this->createMock(ApiInterface::class);
        $api->expects(self::once())->method('getUserById')->with(
            self::equalTo(self::USER_ID)
        )->willThrowException(new DomainException('User not found.'));

        $authService = new AuthService($api);

        $this->expectExceptionMessage('User not found.');

        $authService->getUserById(self::USER_ID);
    }
}
