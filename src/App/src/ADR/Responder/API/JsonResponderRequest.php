<?php

declare(strict_types=1);

namespace App\ADR\Responder\API;

use App\ADR\Responder\ResponderRequestInterface;

class JsonResponderRequest implements ResponderRequestInterface
{
    public function __construct(private readonly array $data, private readonly int $status = 200)
    {
    }

    public function getData(): array
    {
        return $this->data;
    }

    public function getStatus(): int
    {
        return $this->status;
    }
}
