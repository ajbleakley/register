<?php

declare(strict_types=1);

namespace App\Entity;

use DateTimeImmutable;

interface UpdatableEntityInterface extends ImmutableEntityInterface
{
    public function updatedAt(): DateTimeImmutable;

    public function setUpdatedAt(): self;
}
