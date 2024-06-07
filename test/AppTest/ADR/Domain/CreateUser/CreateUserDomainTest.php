<?php

declare(strict_types=1);

namespace AppTest\ADR\Domain\CreateUser;

use App\ADR\Domain\CreateUser\CreateUserDomain;
use App\ADR\Domain\CreateUser\CreateUserDomainRequest;
use App\ADR\Domain\CreateUser\UserCreatedDomainResult;
use App\ADR\Domain\CreateUser\UserNotCreatedDomainResult;
use App\ADR\Domain\DomainResultInterface;
use App\Service\UserService;
use PHPUnit\Framework\TestCase;
use Throwable;

class CreateUserDomainTest extends TestCase
{
    // dependencies
    private UserService $users;

    // parameters
    private CreateUserDomainRequest $domainRequest;

    protected function setUp(): void
    {
        // dependencies
        $this->users = $this->createMock(UserService::class);

        // parameters
        $this->domainRequest = $this->createMock(CreateUserDomainRequest::class);
    }

    private function sut(): DomainResultInterface
    {
        return (new CreateUserDomain($this->users))->process($this->domainRequest);
    }

    public function testWhenEmailIsAlreadyRegisteredThenDomainSignalsUserNotCreated(): void
    {
        // given
        $this->users->method('isEmailAlreadyRegistered')
            ->willReturn(true);

        // when
        $result = $this->sut();

        // then
        self::assertInstanceOf(UserNotCreatedDomainResult::class, $result);
    }

    public function testWhenUserIsCreatedThenUserIsPersisted(): void
    {
        // expect
        $this->users->expects($this->once())->method('saveUser');

        // when
        $this->sut();
    }

    public function testWhenPersistenceFailsThenDomainSignalsUserNotCreated(): void
    {
        // given
        $this->users->method('saveUser')
            ->willThrowException($this->createMock(Throwable::class));

        // when
        $result = $this->sut();

        // then
        self::assertInstanceOf(UserNotCreatedDomainResult::class, $result);
    }

    public function testWhenPersistenceSucceedsThenDomainSignalsUserCreated(): void
    {
        // when
        $result = $this->sut();

        // then
        self::assertInstanceOf(UserCreatedDomainResult::class, $result);
    }
}
