<?php

declare(strict_types=1);

namespace App\Task\Entity\Task;

use App\Task\Entity\Task\Author\Author;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;
use DomainException;

/**
 * @ORM\Entity
 * @ORM\Table(name="task_tasks")
 */
class Task
{
    /**
     * @ORM\Column(type="task_task_id")
     * @ORM\Id
     */
    private Id $id;
    /**
     * @ORM\Embedded(class="App\Task\Entity\Task\Author\Author")
     */
    private Author $author;
    /**
     * @ORM\Column(type="string", nullable=false, length=255)
     */
    private string $name;
    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private string $description;
    /**
     * @ORM\Column(type="task_task_status", length=16)
     */
    private Status $status;
    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private DateTimeImmutable $createdDate;
    /**
     * @ORM\Column(type="datetime_immutable", nullable=true)
     */
    private ?DateTimeImmutable $completedDate = null;

    public function __construct(
        Id $id,
        Author $author,
        string $name,
        string $description,
        Status $status,
        DateTimeImmutable $createdDate
    ) {
        $this->id = $id;
        $this->author = $author;
        $this->name = $name;
        $this->description = $description;
        $this->status = $status;
        $this->createdDate = $createdDate;
    }

    public static function create(
        Id $id,
        Author $author,
        string $name,
        string $description
    ): self {
        return new self(
            $id,
            $author,
            $name,
            $description,
            Status::wait(),
            new DateTimeImmutable()
        );
    }

    public function execute(): void
    {
        if (!$this->isWait()) {
            throw new DomainException('Unable to execute task.');
        }

        $this->status = Status::execute();
    }

    public function complete(): void
    {
        if (!$this->isExecute()) {
            throw new DomainException('Unable to complete task.');
        }

        $this->status = Status::complete();
        $this->completedDate = new DateTimeImmutable();
    }

    public function delete(): void
    {
        if (!$this->isWait()) {
            throw new DomainException('Unable to delete task.');
        }

        $this->status = Status::delete();
    }

    public function isWait(): bool
    {
        return $this->status->isWait();
    }

    public function isExecute(): bool
    {
        return $this->status->isExecute();
    }

    public function isCompleted(): bool
    {
        return $this->status->isCompleted();
    }

    public function isDeleted(): bool
    {
        return $this->status->isDeleted();
    }

    public function getId(): Id
    {
        return $this->id;
    }

    public function getAuthor(): Author
    {
        return $this->author;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getStatus(): Status
    {
        return $this->status;
    }

    public function getCreatedDate(): DateTimeImmutable
    {
        return $this->createdDate;
    }

    public function getCompletedDate(): ?DateTimeImmutable
    {
        return $this->completedDate;
    }
}
