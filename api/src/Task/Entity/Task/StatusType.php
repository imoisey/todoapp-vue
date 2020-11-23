<?php

declare(strict_types=1);

namespace App\Task\Entity\Task;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\StringType;

class StatusType extends StringType
{
    public const NAME = 'task_task_status';

    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        return $value instanceof Status ? $value->getName() : $value;
    }

    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        return !empty($value) ? new Status((string)$value) : null;
    }

    public function getName(): string
    {
        return self::NAME;
    }

    public function requiresSQLCommentHint(AbstractPlatform $platform)
    {
        return true;
    }
}
