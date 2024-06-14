<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\User\User;
use App\Entity\User\UserCollection;
use App\Entity\User\UserInterface;
use Doctrine\ORM\EntityManagerInterface;

class UserService
{
    public function __construct(private EntityManagerInterface $entityManager)
    {
    }

    public function fetchAll(): UserCollection
    {
        $entityRepository = $this->entityManager->getRepository(User::class);
        return new UserCollection($entityRepository->findAll());
    }

    public function fetchByIdentifier(string $identifier): UserInterface
    {
        return $this->entityManager->createQueryBuilder()
            ->select('u')
            ->from(User::class, 'u')
            ->andWhere('u.identifier = :identifier')
            ->setParameter('identifier', $identifier)
            ->getQuery()
            ->getSingleResult();
    }

    public function saveUser(User $user): void
    {
        $this->entityManager->persist($user);
        $this->entityManager->flush();
    }

    public function isEmailAlreadyRegistered(string $email): bool
    {
        return (bool) $this->entityManager->createQueryBuilder()
            ->select('u')
            ->from(User::class, 'u')
            ->andWhere('u.email = :email')
            ->setParameter('email', $email)
            ->getQuery()
            ->getOneOrNullResult();
    }
}
