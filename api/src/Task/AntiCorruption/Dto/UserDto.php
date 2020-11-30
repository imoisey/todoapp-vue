<?php

declare(strict_types=1);

namespace App\Task\AntiCorruption\Dto;

use App\Helper\DataTransferObject;

class UserDto extends DataTransferObject
{
    public string $id = '';
    public string $date = '';
    public string $email = '';
    public string $status = '';
    public string $role = '';
}
