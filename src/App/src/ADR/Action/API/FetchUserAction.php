<?php

declare(strict_types=1);

namespace App\ADR\Action\API;

use App\Service\UserService;
use Mezzio\Hal\HalResponseFactory;
use Mezzio\Hal\ResourceGenerator;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class FetchUserAction implements RequestHandlerInterface
{
    public function __construct(
        private UserService $users,
        private ResourceGenerator $resourceGenerator,
        private HalResponseFactory $responseFactory
    ) {
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $user = $this->users->fetchByIdentifier($request->getAttribute('identifier'));

        $resource = $this->resourceGenerator->fromObject($user, $request);
        return $this->responseFactory->createResponse($request, $resource);
    }
}
