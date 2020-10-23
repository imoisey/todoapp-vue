<?php

declare(strict_types=1);

namespace App\Auth\Entity\User;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use DomainException;

class DoctrineUserRepository implements UserRepository
{
    private EntityRepository $repository;
    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em, EntityRepository $repository)
    {
        $this->em = $em;
        $this->repository = $repository;
    }

    public function hasByEmail(Email $email): bool
    {
        return $this->repository->createQueryBuilder('t')
            ->select('COUNT(t.id)')
            ->andWhere('t.email = :email')
            ->setParameter(':email', $email->getValue())
            ->getQuery()->getSingleScalarResult() > 0;
    }

    /**
     * @param string $token
     * @return User|object|null
     * @psalm-return User|null
     */
    public function findByJoinConfirmToken(string $token): ?User
    {
        /** @psalm-var User|null */
        return $this->repository->findOneBy(['joinConfirmToken.value' => $token]);
    }

    /**
     * @param string $token
     * @return User|object|null
     * @psalm-return User|null
     */
    public function findByPasswordResetToken(string $token): ?User
    {
        /** @psalm-var User|null */
        return $this->repository->findOneBy(['passwordResetToken.value' => $token]);
    }

    /**
     * @param string $token
     * @return User|object|null
     * @psalm-return User|null
     */
    public function findByNewEmailToken(string $token): ?User
    {
        /** @psalm-var User|null */
        return $this->repository->findOneBy(['newEmailToken.value' => $token]);
    }

    public function get(Id $id): User
    {
        if (!$user = $this->repository->find($id->getValue())) {
            throw new DomainException('User is not found.');
        }

        /** @var User $user */
        return $user;
    }

    public function getByEmail(Email $email): User
    {
        if (!$user = $this->repository->findOneBy(['email' => $email->getValue()])) {
            throw new DomainException('User is not found.');
        }

        /** @var User $user */
        return $user;
    }

    public function add(User $user): void
    {
        $this->em->persist($user);
    }

    public function remove(User $user): void
    {
        $this->em->remove($user);
    }
}
