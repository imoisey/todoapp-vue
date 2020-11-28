<?php

declare(strict_types=1);

namespace App\Helper\Test\Unit;

use App\Helper\DataTransferObject;
use PHPUnit\Framework\TestCase;

class DataTransferObjectTest extends TestCase
{
    public function testToArray(): void
    {
        $properties = [
            'id' => '00000000-0000-0000-0000-000000000001',
            'email' => 'user@email.ru',
            'role' => 'admin',
        ];

        $dto = new class () extends DataTransferObject {
            public string $id = '';
            public string $email = '';
            public string $role = '';
        };

        $dto->id = $properties['id'];
        $dto->email = $properties['email'];
        $dto->role = $properties['role'];

        self::assertEquals($properties, $dto->toArray());
    }
}
