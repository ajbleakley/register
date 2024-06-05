<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'users')]
class UserEntity
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
    private string $email;

    #[ORM\Column(name: 'password_hash', type: 'string')]
    private string $passwordHash;

    public function getId(): int|null
    {
        return $this->id;
    }

    public function getIdentifier(): string|null
    {
        return $this->identifier;
    }

    public function getCreatedAt(): string
    {
        return $this->createdAt;
    }

    public function setCreatedAt(string $createdAt): self
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    public function getUpdatedAt(): string
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(string $updatedAt): self
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;
        return $this;
    }

    public function getPasswordHash(): string
    {
        return $this->passwordHash;
    }

    public function setPasswordHash(string $passwordHash): self
    {
        $this->passwordHash = $passwordHash;
        return $this;
    }
}
