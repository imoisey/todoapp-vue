<?php

declare(strict_types=1);

namespace App\Task\Test\Builder;

use App\Task\Entity\Task\Author\Author;
use App\Task\Entity\Task\Author\Id as AuthorId;
use App\Task\Entity\Task\Author\Email;
use App\Task\Entity\Task\Id;
use App\Task\Entity\Task\Status;
use App\Task\Entity\Task\Task;
use DateTimeImmutable;

class TaskBuilder
{
    private Id $id;
    private Author $author;
    private string $name;
    private string $description;
    private Status $status;
    private DateTimeImmutable $createdDate;

    public function __construct()
    {
        $this->id = Id::generate();
        $this->author = new Author(
            new AuthorId('00000000-0000-0000-0000-000000000001'),
            new Email('user@email.ru')
        );
        $this->name = 'Name';
        $this->description = 'Description';
        $this->status = Status::wait();
        $this->createdDate = new DateTimeImmutable();
    }

    public function withAuthor(Author $author): self
    {
        $clone = clone $this;
        $clone->author = $author;
        return $clone;
    }

    public function withDescription(string $description): self
    {
        $clone = clone $this;
        $clone->description = $description;
        return $clone;
    }

    public function build(): Task
    {
        return new Task(
            $this->id,
            $this->author,
            $this->name,
            $this->description,
            $this->status,
            $this->createdDate
        );
    }
}
