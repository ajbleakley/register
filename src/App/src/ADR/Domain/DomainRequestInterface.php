<?php

declare(strict_types=1);

namespace App\ADR\Domain;

use InvalidArgumentException;

interface DomainRequestInterface
{
    /**
     * @throws InvalidArgumentException
     */
    public function validate(): void;
}
