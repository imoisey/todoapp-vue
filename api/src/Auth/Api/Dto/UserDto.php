<?php

declare(strict_types=1);

namespace App\Auth\Api\Dto;

use App\Helper\DataTransferObject;
use DateTimeImmutable;

class UserDto extends DataTransferObject
{
    public string $id = '';
    public ?DateTimeImmutable $date = null;
    public string $email = '';
    public string $status = '';
    public string $role = '';
}
