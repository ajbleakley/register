<?php

declare(strict_types=1);

namespace App\ADR\Action\API;

use App\ADR\Domain\CreateUser\CreateUserDomain;
use App\ADR\Domain\CreateUser\CreateUserDomainRequest;
use App\ADR\Domain\CreateUser\UserCreatedDomainResult;
use App\ADR\Domain\InvalidDomainRequestException;
use App\Exception\OutOfBoundsException;
use App\Exception\RuntimeException;
use Laminas\Diactoros\Response\RedirectResponse;
use Mezzio\Helper\UrlHelper;
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
        private readonly UrlHelper $urlHelper
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

        // marshal domain request
        try {
            $domainRequest = new CreateUserDomainRequest($email, $password);
        } catch (InvalidDomainRequestException $exception) {
            throw OutOfBoundsException::create($exception->getMessage());
        }

        // process domain
        $domainResult = $this->createUserDomain->process($domainRequest);
        if (! $domainResult instanceof UserCreatedDomainResult) {
            throw RuntimeException::create($domainResult->getMessage());
        }

        // issue response
        return new RedirectResponse($this->urlHelper->generate('api.users', [
            'identifier' => $domainResult->getUser()->identifier(),
        ]));
    }
}
