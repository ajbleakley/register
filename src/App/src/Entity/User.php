<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

use function password_hash;

use const PASSWORD_DEFAULT;

#[ORM\Entity]
#[ORM\Table(name: 'users')]
class User
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private int|null $id;

    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'guid')]
    private string|null $identifier;

    #[ORM\GeneratedValue]
    #[ORM\Column(name: 'created_at', type: 'datetime_immutable')]
    private string $createdAt;

    #[ORM\GeneratedValue]
    #[ORM\Column(name: 'updated_at', type: 'datetime_immutable')]
    private string $updatedAt;

    #[ORM\Column(type: 'string')]
    private string $username;

    #[ORM\Column(name: 'password_hash', type: 'string')]
    private string $passwordHash;

    #[ORM\Column(type: 'string')]
    private string $email;

    public function __construct(string $email, string $password)
    {
        $this->username = $email; // On user creation, email is used as username
        // validate password here
        $this->passwordHash = password_hash($password, PASSWORD_DEFAULT);
        $this->email        = $email;
    }

    public function identifier(): string
    {
        return $this->identifier;
    }

    public function username(): string
    {
        return $this->username;
    }

    public function email(): string
    {
        return $this->username;
    }
}
