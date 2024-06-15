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

    public function hashPassword(string $password): string;

    public function verifyPassword(string $password): bool;
}
