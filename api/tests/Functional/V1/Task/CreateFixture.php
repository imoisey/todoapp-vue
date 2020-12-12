<?php

declare(strict_types=1);

namespace Test\Functional\V1\Task;

use App\Auth\Entity\User\Email;
use App\Auth\Entity\User\Id;
use App\Auth\Entity\User\Token;
use App\Auth\Entity\User\User;
use DateTimeImmutable;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Persistence\ObjectManager;
use Ramsey\Uuid\Uuid;

class CreateFixture extends AbstractFixture
{
    public const USER_ID = '00000000-0000-1000-8000-000000000001';

    public function load(ObjectManager $manager): void
    {
        $user = User::joinByEmail(
            new Id(self::USER_ID),
            $date = new DateTimeImmutable(),
            new Email('valid@email.ru'),
            'password-hash',
            new Token($token = Uuid::uuid4()->toString(), $date->modify('+1 hour'))
        );

        $user->confirmJoin($token, new DateTimeImmutable());

        $manager->persist($user);

        $manager->flush();
    }
}
