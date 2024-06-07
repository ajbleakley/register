<?php

declare(strict_types=1);

namespace App\ADR\Domain\CreateUser;

use App\ADR\Domain\DomainInterface;
use App\ADR\Domain\DomainRequestInterface;
use App\ADR\Domain\DomainResultInterface;
use App\Entity\User;
use App\Service\UserService;
use Throwable;

class CreateUserDomain implements DomainInterface
{
    public function __construct(private readonly UserService $users)
    {
    }

    /**
     * @param CreateUserDomainRequest $request
     */
    public function process(DomainRequestInterface $request): DomainResultInterface
    {
        if ($this->users->isEmailAlreadyRegistered($request->getEmail())) {
            return new UserNotCreatedDomainResult('User already exists.');
        }

        $user = new User($request->getEmail(), $request->getPassword());

        try {
            $this->users->saveUser($user);
        } catch (Throwable $exception) {
            return new UserNotCreatedDomainResult($exception->getMessage());
        }

        // TODO - dispatch user created event

        return new UserCreatedDomainResult($user);
    }
}
