<?php

declare(strict_types=1);

namespace App\Entity\User;

use InvalidArgumentException;

use function filter_var;

use const FILTER_VALIDATE_EMAIL;

class Email
{
    private string $email;

    public function __construct(string $email)
    {
        if (! filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentException('Invalid email format');
        }

        $this->email = $email;
    }

    public function __toString(): string
    {
        return $this->email;
    }
}
