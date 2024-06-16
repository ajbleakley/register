<?php

declare(strict_types=1);

namespace App\ADR\Action\API;

use App\Entity\User\UserInterface;
use App\Exception\OutOfBoundsException;
use App\Service\UserService;
use App\Trait\FetchUserTrait;
use App\Trait\RestDispatchTrait;
use Laminas\Diactoros\Response\EmptyResponse;
use Laminas\Diactoros\Response\RedirectResponse;
use Mezzio\Helper\UrlHelper;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

use function htmlspecialchars;

class ModifyUserAction implements RequestHandlerInterface
{
    use FetchUserTrait;
    use RestDispatchTrait;

    public function __construct(
        private readonly UserService $users,
        private readonly UrlHelper $urlHelper
    ) {
    }

    protected function delete(ServerRequestInterface $request): ResponseInterface
    {
        $user = $this->fetchUser($request);
        $this->users->removeUser($user);
        return new EmptyResponse(200);
    }

    protected function patch(ServerRequestInterface $request): ResponseInterface
    {
        $user    = $this->fetchUser($request);
        $updated = false;

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
