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
use App\Task\Entity\Task\Id as TaskId;
use App\Task\Entity\Task\Task;
use DateTimeImmutable;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Persistence\ObjectManager;
use Ramsey\Uuid\Uuid;

class CompleteFixture extends AbstractFixture
{
    public const USER_ID = '00000000-0000-1000-9000-000000000001';
    public const TASK_ID = '00000000-0000-1000-8000-000000000001';

    public function load(ObjectManager $manager)
    {
        $user = User::joinByEmail(
            new Id(self::USER_ID),
            $date = new DateTimeImmutable(),
            new Email('user@email.ru'),
            'password-hash',
            new Token($token = Uuid::uuid4()->toString(), $date->modify('+1 hour'))
        );

        $user->confirmJoin($token, new DateTimeImmutable());

        $manager->persist($user);

        $task = Task::create(
            $id = new TaskId(self::TASK_ID),
            new Author(new AuthorId(self::USER_ID), new AuthorEmail('author@email.ru')),
            $name = 'New Task',
            $description = 'Description Task'
        );

        $task->execute();

        $manager->persist($task);

        $manager->flush();
    }
}
