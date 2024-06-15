<?php

declare(strict_types=1);

namespace AppTest\ADR\Action\API;

use App\ADR\Action\API\FetchUserAction;
use App\Entity\User\UserCollection;
use App\Entity\User\UserInterface;
use App\Exception\NoResourceFoundException;
use App\Exception\OutOfBoundsException;
use App\Service\UserService;
use Doctrine\ORM\NoResultException;
use Mezzio\Hal\HalResponseFactory;
use Mezzio\Hal\ResourceGenerator;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class FetchUserActionTest extends TestCase
{
    // dependencies
    private UserService $users;

    // parameters
    private ServerRequestInterface $request;

    protected function setUp(): void
    {
        // dependencies
        $this->users = $this->createMock(UserService::class);

        // parameters
        $this->request = $this->createMock(ServerRequestInterface::class);
        $this->request->method('getMethod')->willReturn('get');
    }

    public function sut(): ResponseInterface
    {
        return (new FetchUserAction(
            $this->users,
            $this->createMock(ResourceGenerator::class),
            $this->createMock(HalResponseFactory::class)
        ))->handle($this->request);
    }

    public function testWhenUserNotFoundThenActionExitsEarly(): void
    {
        // given
        $this->request->method('getAttribute')
            ->willReturn('identifier');
        $this->users->method('fetchByIdentifier')
            ->willThrowException(new NoResultException());

        // expect
        $this->expectException(NoResourceFoundException::class);

        // when
        $this->sut();
    }

    public function testWhenUserFoundThenResponseIssues(): void
    {
        // given
        $this->users->method('fetchByIdentifier')
            ->willReturn($this->createMock(UserInterface::class));

        // expect
        $this->expectNotToPerformAssertions();

        // when
        $this->sut();
    }

    public function testWhenUsersNotFoundThenActionExitsEarly(): void
    {
        // given
        $this->users->method('findBy')
            ->willThrowException(new NoResultException());

        // expect
        $this->expectException(OutOfBoundsException::class);

        // when
        $this->sut();
    }

    public function testWhenUsersFoundThenResponseIssues(): void
    {
        // given
        $this->users->method('findBy')
            ->willReturn($this->createMock(UserCollection::class));

        // expect
        $this->expectNotToPerformAssertions();

        // when
        $this->sut();
    }
}
