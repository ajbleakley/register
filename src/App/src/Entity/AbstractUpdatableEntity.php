<?php

declare(strict_types=1);

namespace App\Entity;

use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;

abstract class AbstractUpdatableEntity extends AbstractImmutableEntity implements UpdatableEntityInterface
{
    #[ORM\GeneratedValue]
    #[ORM\Column(name: 'updated_at', type: 'datetime_immutable')]
    protected DateTimeImmutable $updatedAt;

    public function __construct()
    {
        parent::__construct();
        $this->setUpdatedAt();
    }

    public function updatedAt(): DateTimeImmutable
    {
        return $this->updatedAt;
    }

    /**
     * Gets triggered every time on update
     *
     * @ORM\PreUpdate
     */
    public function setUpdatedAt(): self
    {
        $this->updatedAt = new DateTimeImmutable();
        return $this;
    }
}
