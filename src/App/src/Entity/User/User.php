<?php

declare(strict_types=1);

namespace App\Entity\User;

use App\Helper\PasswordValidationHelper;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;
use Laminas\Validator\EmailAddress;
use OutOfBoundsException;
use Ramsey\Uuid\Uuid;

use function password_hash;
use function password_verify;

use const PASSWORD_DEFAULT;

#[ORM\Entity]
#[ORM\Table(name: 'users')]
class User implements UserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private int|null $id;

    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'guid')]
    public string|null $identifier;

    #[ORM\GeneratedValue]
    #[ORM\Column(name: 'created_at', type: 'datetime_immutable')]
    public DateTimeImmutable $createdAt;

    #[ORM\GeneratedValue]
    #[ORM\Column(name: 'updated_at', type: 'datetime_immutable')]
    public DateTimeImmutable $updatedAt;

    #[ORM\Column(type: 'string')]
    private string $username;

    #[ORM\Column(name: 'password_hash', type: 'string')]
    private string $passwordHash;

    #[ORM\Column(type: 'string')]
    public string $email;

    public function __construct(string $email, string $password)
    {
        $this->identifier   = Uuid::uuid1()->toString();
        $this->createdAt    = $this->updatedAt = new DateTimeImmutable();
        $this->username     = $this->email = $email; // On user creation, email used as username
        $this->passwordHash = $this->hashPassword($password);
        $this->validate();
    }

    private function validate(): void
    {
        if (! (new EmailAddress())->isValid($this->email)) {
            throw new OutOfBoundsException('Invalid email');
        }
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

    public function hashPassword(string $password): string
    {
        if (! (new PasswordValidationHelper())->isValid($password)) {
            throw new OutOfBoundsException('Invalid password');
        }

        return password_hash($password, PASSWORD_DEFAULT);
    }

    public function verifyPassword(string $password): bool
    {
        return password_verify($password, $this->passwordHash);
    }
}
