<?php

declare(strict_types=1);

namespace App\Entity\User;

use function password_hash;

use const PASSWORD_DEFAULT;

class TestUser extends User
{
    public function hashPassword(string $password): string
    {
        return password_hash($password, PASSWORD_DEFAULT);
    }
}
