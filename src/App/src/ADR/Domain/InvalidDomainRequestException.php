<?php

declare(strict_types=1);

namespace App\ADR\Domain;

use InvalidArgumentException;

use function implode;
use function strtolower;
use function ucfirst;

class InvalidDomainRequestException extends InvalidArgumentException
{
    public function __construct(array $messages)
    {
        parent::__construct(ucfirst(strtolower(implode(', ', $messages))));
    }
}
