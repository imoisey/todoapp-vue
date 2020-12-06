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
    public const USER_UUID = 'cc2444cb-87ad-4a92-89fd-fa9d2392caa3';

    public function load(ObjectManager $manager)
    {
        // Valid
        $user = User::joinByEmail(
            new Id(self::USER_UUID),
            $date = new DateTimeImmutable(),
            new Email('valid@email.ru'),
            'password-hash',
            new Token(Uuid::uuid4()->toString(), $date->modify('+1 hour'))
        );

        $manager->persist($user);

        $manager->flush();
    }
}
