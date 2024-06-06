<?php

declare(strict_types=1);

namespace App\ADR\Responder;

use Psr\Http\Message\ResponseInterface;

interface ResponderInterface
{
    public function respond(ResponderRequestInterface $request): ResponseInterface;
}
