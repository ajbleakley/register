<?php

declare(strict_types=1);

namespace AppTest\ADR\Domain\CreateUser;

use App\ADR\Domain\CreateUser\CreateUserDomain;
use App\ADR\Domain\CreateUser\CreateUserDomainRequest;
use App\ADR\Domain\CreateUser\UserCreatedDomainResult;
use App\ADR\Domain\CreateUser\UserNotCreatedDomainResult;
use App\ADR\Domain\DomainResultInterface;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\TestCase;
use Throwable;

class CreateUserDomainTest extends TestCase
{
    // dependencies
    private EntityManagerInterface $entityManager;

    // parameters
    private CreateUserDomainRequest $domainRequest;

    protected function setUp(): void
    {
        // dependencies
        $this->entityManager = $this->createMock(EntityManagerInterface::class);

        // parameters
        $this->domainRequest = $this->createMock(CreateUserDomainRequest::class);
    }

    private function sut(): DomainResultInterface
    {
        return (new CreateUserDomain($this->entityManager))->process($this->domainRequest);
    }

    public function testWhenUserIsCreatedThenUserEntityIsPersisted(): void
    {
        // expect
        $this->entityManager->expects($this->once())->method('persist');

        // when
        $this->sut();
    }

    public function testWhenPersistenceFailsThenDomainSignalsUserNotCreated(): void
    {
        // given
        $this->entityManager->method('persist')
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
