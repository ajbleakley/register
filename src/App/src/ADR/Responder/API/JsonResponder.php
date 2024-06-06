<?php

declare(strict_types=1);

namespace App\ADR\Responder\API;

use App\ADR\Responder\ResponderInterface;
use App\ADR\Responder\ResponderRequestInterface;
use Laminas\Diactoros\Response\JsonResponse;
use Psr\Http\Message\ResponseInterface;

class JsonResponder implements ResponderInterface
{
    /**
     * @param JsonResponderRequest $request
     */
    public function respond(ResponderRequestInterface $request): ResponseInterface
    {
        return new JsonResponse($request->getData(), $request->getStatus());
    }
}
