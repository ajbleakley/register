<?php

declare(strict_types=1);

namespace App\Trait;

use App\Entity\User\UserInterface;
use App\Exception\NoResourceFoundException;
use App\Service\UserService;
use Exception;
use Psr\Http\Message\ServerRequestInterface;

use function htmlspecialchars;

trait FetchUserTrait
{
    private readonly UserService $users;

    public function fetchUser(ServerRequestInterface $request): UserInterface
    {
        $identifier = htmlspecialchars($request->getAttribute('identifier'));

        try {
            return $this->users->fetchByIdentifier($identifier);
        } catch (Exception $exception) {
            throw NoResourceFoundException::create($exception->getMessage());
        }
    }
}
