<?php

declare(strict_types=1);

namespace App\ADR\Action\API;

use App\ADR\Domain\CreateUser\CreateUserDomain;
use App\ADR\Domain\CreateUser\CreateUserDomainRequest;
use App\ADR\Domain\CreateUser\NotReadyToCreateUserDomainResult;
use App\ADR\Domain\CreateUser\UserCreatedDomainResult;
use App\ADR\Responder\API\JsonResponder;
use App\ADR\Responder\API\JsonResponderRequest;
use InvalidArgumentException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

use function filter_var;
use function htmlspecialchars;

use const FILTER_SANITIZE_EMAIL;

class CreateUserAction implements RequestHandlerInterface
{
    public function __construct(
        private readonly CreateUserDomain $createUserDomain,
        private readonly JsonResponder $jsonResponder
    ) {
    }

    /**
     * @inheritDoc
     */
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        // sanitise user input (note - validation is performed by the domain request)
        $email    = filter_var($request->getParsedBody()['email'] ?? '', FILTER_SANITIZE_EMAIL);
        $password = htmlspecialchars($request->getParsedBody()['password'] ?? '');

        // domain
        try {
            $domainRequest = new CreateUserDomainRequest($email, $password);
            $domainResult  = $this->createUserDomain->process($domainRequest);
        } catch (InvalidArgumentException $exception) {
            $domainResult = new NotReadyToCreateUserDomainResult($exception->getMessage());
        }

        // responder
        if (! $domainResult instanceof UserCreatedDomainResult) {
            // TODO - use [mezzio-problem-details](https://docs.mezzio.dev/mezzio-problem-details/)
            return $this->jsonResponder->respond(
                new JsonResponderRequest(['message' => $domainResult->getMessage()], 400)
            );
        }

        // TODO - improve structure of API response (maybe use existing PHP library)
        $responderRequest = new JsonResponderRequest([
            'message' => 'User created successfully',
            'email'   => $domainResult->getUser()->getEmail(),
        ], 200);

        return $this->jsonResponder->respond($responderRequest);
    }
}
