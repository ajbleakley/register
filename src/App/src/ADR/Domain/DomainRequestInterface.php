<?php

declare(strict_types=1);

namespace App\ADR\Domain;

interface DomainRequestInterface
{
    /**
     * @throws InvalidDomainRequestException
     */
    public function validate(): void;
}
