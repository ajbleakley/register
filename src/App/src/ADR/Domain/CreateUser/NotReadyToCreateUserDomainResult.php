<?php

declare(strict_types=1);

namespace App\ADR\Domain\CreateUser;

use App\ADR\Domain\DomainResultInterface;

class NotReadyToCreateUserDomainResult implements DomainResultInterface
{
    public function __construct(private readonly string $message)
    {
    }

    public function getMessage(): string
    {
        return $this->message;
    }
}
