<?php

declare(strict_types=1);

namespace AppTest\Trait;

use App\Entity\User\UserInterface;
use App\Exception\NoResourceFoundException;
use App\Service\UserService;
use App\Trait\FetchUserTrait;
use Doctrine\ORM\NoResultException;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ServerRequestInterface;

class FetchUserTraitTest extends TestCase
{
    // dependencies
    private UserService $users;

    // parameters
    private ServerRequestInterface $request;

    public function setUp(): void
    {
        // dependencies
        $this->users = $this->createMock(UserService::class);

        // parameters
        $this->request = $this->createMock(ServerRequestInterface::class);
        $this->request->method('getAttribute')->willReturn('identifier');
    }

    private function sut(): UserInterface
    {
        return (new class ($this->users)
        {
            use FetchUserTrait;

            public function __construct(UserService $users)
            {
                $this->users = $users;
            }
        })->fetchUser($this->request);
    }

    public function testWhenUserNotFetchedThenExitsEarly(): void
    {
        // given
        $this->users->method('fetchByIdentifier')
            ->willThrowException(new NoResultException());

        // expect
        $this->expectException(NoResourceFoundException::class);

        // when
        $this->sut();
    }

    public function testWhenUserFetchedThenUserReturned(): void
    {
        // given
        $user = $this->createMock(UserInterface::class);
        $this->users->method('fetchByIdentifier')
            ->willReturn($user);

        // when
        $result = $this->sut();

        // then
        self::assertEquals($user, $result);
    }
}
