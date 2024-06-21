<?php

declare(strict_types=1);

namespace App\Entity\User;

use App\Entity\UpdatableEntityInterface;

interface UserInterface extends UpdatableEntityInterface
{
    public function username(): string;

    public function email(): Email;

    public function updatePassword(string $password): self;

    public function verifyPassword(string $password): bool;
}
