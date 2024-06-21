<?php

declare(strict_types=1);

namespace App\Entity;

use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;

abstract class AbstractImmutableEntity implements ImmutableEntityInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    protected int|null $id;

    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'guid')]
    protected string|null $identifier;

    #[ORM\GeneratedValue]
    #[ORM\Column(name: 'created_at', type: 'datetime_immutable')]
    protected DateTimeImmutable $createdAt;

    public function __construct()
    {
        $this->identifier = Uuid::uuid1()->toString();
        $this->createdAt  = new DateTimeImmutable();
    }

    public function identifier(): string
    {
        return $this->identifier;
    }

    public function createdAt(): DateTimeImmutable
    {
        return $this->createdAt;
    }
}
