<?php

declare(strict_types=1);

namespace App\ADR\Domain\CreateUser;

use App\ADR\Domain\DomainInterface;
use App\ADR\Domain\DomainRequestInterface;
use App\ADR\Domain\DomainResultInterface;
use App\Entity\UserEntity;
use Doctrine\ORM\EntityManagerInterface;
use Throwable;

use function password_hash;

use const PASSWORD_DEFAULT;

class CreateUserDomain implements DomainInterface
{
    public function __construct(private readonly EntityManagerInterface $entityManager)
    {
    }

    /**
     * @param CreateUserDomainRequest $request
     */
    public function process(DomainRequestInterface $request): DomainResultInterface
    {
        // TODO - deal with a rich user model here, rather than anaemic user entity (DTO)
        $user = (new UserEntity())
            ->setEmail($request->getEmail())
            ->setPasswordHash(password_hash($request->getPassword(), PASSWORD_DEFAULT));

        // TODO - decouple domain from Doctrine entity manager
        try {
            $this->entityManager->persist($user);
        } catch (Throwable $exception) {
            return new UserNotCreatedDomainResult($exception->getMessage());
        }

        // TODO - dispatch user created event

        return new UserCreatedDomainResult($user);
    }
}
