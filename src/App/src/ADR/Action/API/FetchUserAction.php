<?php

declare(strict_types=1);

namespace App\ADR\Action\API;

use App\Exception\NoResourceFoundException;
use App\Service\UserService;
use Exception;
use Mezzio\Hal\HalResponseFactory;
use Mezzio\Hal\ResourceGenerator;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

use function htmlspecialchars;

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
        // sanitise user input
        $identifier = htmlspecialchars($request->getAttribute('identifier'));

        // fetch user
        try {
            $user = $this->users->fetchByIdentifier($identifier);
        } catch (Exception $exception) {
            throw NoResourceFoundException::create($exception->getMessage());
        }

        // issue response
        $resource = $this->resourceGenerator->fromObject($user, $request);
        return $this->responseFactory->createResponse($request, $resource);
    }
}
