<?php

declare(strict_types=1);

namespace App\Entity\User;

use DateTimeImmutable;

interface UserInterface
{
    public function identifier(): string;

    public function createdAt(): DateTimeImmutable;

    public function updatedAt(): DateTimeImmutable;

    public function username(): string;

    public function email(): string;

    public function updatePassword(string $password): self;

    public function verifyPassword(string $password): bool;
}
