<?php

declare(strict_types=1);

namespace App\ADR\Domain;

interface DomainInterface
{
    public function process(DomainRequestInterface $request): DomainResultInterface;
}
