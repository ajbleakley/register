<?php

declare(strict_types=1);

namespace App\ADR\Action\API;

use App\Exception\OutOfBoundsException;
use App\Service\UserService;
use App\Trait\FetchUserTrait;
use App\Trait\RestDispatchTrait;
use Exception;
use Mezzio\Hal\HalResponseFactory;
use Mezzio\Hal\ResourceGenerator;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class FetchUserAction implements RequestHandlerInterface
{
    use FetchUserTrait;
    use RestDispatchTrait;

    public function __construct(
        private readonly UserService $users,
        private readonly ResourceGenerator $resourceGenerator,
        private readonly HalResponseFactory $responseFactory
    ) {
    }

    protected function get(ServerRequestInterface $request): ResponseInterface
    {
        // identifier
        $identifier = $request->getAttribute('identifier');
        return $identifier
            ? $this->getUser($request)
            : $this->getAllUsers($request);
    }

    private function getUser(ServerRequestInterface $request): ResponseInterface
    {
        $user = $this->fetchUser($request);
        return $this->createResponse($request, $user);
    }

    private function getAllUsers(ServerRequestInterface $request): ResponseInterface
    {
        try {
            $users = $this->users->findBy(
                (int) ($request->getQueryParams()['page'] ?? 1),
                (int) ($request->getQueryParams()['limit'] ?? 10),
            );
        } catch (Exception $exception) {
            throw OutOfBoundsException::create($exception->getMessage());
        }

        return $this->createResponse($request, $users);
    }
}
