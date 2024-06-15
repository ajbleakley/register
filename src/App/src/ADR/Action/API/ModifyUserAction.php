<?php

declare(strict_types=1);

namespace App\ADR\Action\API;

use App\Entity\User\UserInterface;
use App\Exception\NoResourceFoundException;
use App\Exception\OutOfBoundsException;
use App\Service\UserService;
use Exception;
use Laminas\Diactoros\Response\RedirectResponse;
use Mezzio\Helper\UrlHelper;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

use function htmlspecialchars;

class ModifyUserAction implements RequestHandlerInterface
{
    public function __construct(
        private readonly UserService $users,
        private readonly UrlHelper $urlHelper
    ) {
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        // sanitise user input
        $identifier = htmlspecialchars($request->getAttribute('identifier'));
        $updated    = false;

        // fetch user
        try {
            $user = $this->users->fetchByIdentifier($identifier);
        } catch (Exception $exception) {
            throw NoResourceFoundException::create($exception->getMessage());
        }

        // update password
        if (! empty($password = $request->getParsedBody()['password'] ?? '')) {
            $user    = $this->updatePassword($user, $password);
            $updated = true;
        }

        // persist user
        if ($updated) {
            $this->users->saveUser($user);
        }

        // redirect to fetch updated user
        return new RedirectResponse($this->urlHelper->generate('api.users', [
            'identifier' => $user->identifier(),
        ]));
    }

    private function updatePassword(UserInterface $user, string $password): UserInterface
    {
        // sanitise user input
        $password = htmlspecialchars($password);

        try {
            $user->updatePassword($password);
        } catch (\OutOfBoundsException $exception) {
            throw OutOfBoundsException::create($exception->getMessage());
        }

        return $user;
    }
}
