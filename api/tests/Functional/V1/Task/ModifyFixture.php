<?php

declare(strict_types=1);

namespace Test\Functional\V1\Task;

use App\Auth\Entity\User\Email;
use App\Auth\Entity\User\Id;
use App\Auth\Entity\User\Token;
use App\Auth\Entity\User\User;
use App\Task\Entity\Task\Author\Author;
use App\Task\Entity\Task\Author\Email as AuthorEmail;
use App\Task\Entity\Task\Author\Id as AuthorId;
use App\Task\Entity\Task\Task;
use App\Task\Entity\Task\Id as TaskId;
use DateTimeImmutable;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Persistence\ObjectManager;
use Ramsey\Uuid\Uuid;

class ModifyFixture extends AbstractFixture
{
    public const TASK_UUID = 'ecbe2bb8-4d0d-4e4e-afdd-9652f30a8616';

    public function load(ObjectManager $manager): void
    {
        $user = User::joinByEmail(
            new Id(CreateFixture::USER_UUID),
            $date = new DateTimeImmutable(),
            new Email('valid@email.ru'),
            'password-hash',
            new Token($token = Uuid::uuid4()->toString(), $date->modify('+1 hour'))
        );

        $user->confirmJoin($token, new DateTimeImmutable());

        $manager->persist($user);

        $task = Task::create(
            $id = new TaskId(self::TASK_UUID),
            new Author(new AuthorId(CreateFixture::USER_UUID), new AuthorEmail('author@email.ru')),
            $name = 'New Task',
            $description = 'Description Task'
        );

        $manager->persist($task);

        $manager->flush();
    }
}
