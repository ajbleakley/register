<?php

declare(strict_types=1);

namespace App\Entity;

use DateTimeImmutable;

interface ImmutableEntityInterface
{
    public function identifier(): string;

    public function createdAt(): DateTimeImmutable;
}
