<?php

declare(strict_types=1);

namespace App\Task\Entity\Task;

use Webmozart\Assert\Assert;

class Status
{
    public const WAIT = 'wait';
    public const EXECUTE = 'execute';
    public const COMPLETE = 'complete';
    public const DELETE = 'delete';

    private string $name;

    public function __construct(string $name)
    {
        Assert::oneOf($name, [
            self::WAIT,
            self::EXECUTE,
            self::COMPLETE,
            self::DELETE
        ]);

        $this->name = $name;
    }

    public static function wait(): self
    {
        return new self(self::WAIT);
    }

    public static function execute(): self
    {
        return new self(self::EXECUTE);
    }

    public static function complete(): self
    {
        return new self(self::COMPLETE);
    }

    public static function delete(): self
    {
        return new self(self::DELETE);
    }

    public function isWait(): bool
    {
        return $this->name === self::WAIT;
    }

    public function isExecute(): bool
    {
        return $this->name === self::EXECUTE;
    }

    public function isCompleted(): bool
    {
        return $this->name === self::COMPLETE;
    }

    public function isDeleted(): bool
    {
        return $this->name === self::DELETE;
    }

    public function getName(): string
    {
        return $this->name;
    }
}
