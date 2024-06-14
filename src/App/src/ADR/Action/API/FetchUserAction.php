<?php

declare(strict_types=1);

namespace App\ADR\Action\API;

use App\Exception\NoResourceFoundException;
use App\Exception\OutOfBoundsException;
use App\Service\UserService;
use App\Trait\RestDispatchTrait;
use Exception;
use Mezzio\Hal\HalResponseFactory;
use Mezzio\Hal\ResourceGenerator;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

use function htmlspecialchars;

class FetchUserAction implements RequestHandlerInterface
{
    use RestDispatchTrait;

    public function __construct(
        private readonly UserService $users,
        private readonly ResourceGenerator $resourceGenerator,
        private readonly HalResponseFactory $responseFactory
    ) {
    }

    public function get(ServerRequestInterface $request): ResponseInterface
    {
        // identifier
        $identifier = $request->getAttribute('identifier');

        if ($identifier) {
            return $this->getUser($identifier, $request);
        }

        return $this->getAllUsers($request);
    }

    private function getUser(string $identifier, ServerRequestInterface $request): ResponseInterface
    {
        // sanitise user input
        $identifier = htmlspecialchars($identifier);

        try {
            $user = $this->users->fetchByIdentifier($identifier);
        } catch (Exception $exception) {
            throw NoResourceFoundException::create($exception->getMessage());
        }

        return $this->createResponse($request, $user);
    }

    private function getAllUsers(ServerRequestInterface $request): ResponseInterface
    {
        try {
            $users = $this->users->fetchAll();
        } catch (Exception $exception) {
            throw OutOfBoundsException::create($exception->getMessage());
        }

        return $this->createResponse($request, $users);
    }
}
