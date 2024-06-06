<?php

declare(strict_types=1);

namespace App\ADR\Domain\CreateUser;

use App\ADR\Domain\DomainResultInterface;
use App\Entity\UserEntity;

class UserCreatedDomainResult implements DomainResultInterface
{
    public function __construct(private readonly UserEntity $user)
    {
    }

    public function getUser(): UserEntity
    {
        return $this->user;
    }
}
