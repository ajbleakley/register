<?php

declare(strict_types=1);

namespace AppTest\ADR\Action\API;

use App\ADR\Action\API\CreateUserAction;
use App\ADR\Domain\CreateUser\CreateUserDomain;
use App\ADR\Domain\CreateUser\UserCreatedDomainResult;
use App\ADR\Domain\CreateUser\UserNotCreatedDomainResult;
use App\Exception\OutOfBoundsException;
use Mezzio\Helper\UrlHelper;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class CreateUserActionTest extends TestCase
{
    // dependencies
    private CreateUserDomain $domain;
    private UrlHelper $urlHelper;

    // parameters
    private ServerRequestInterface $request;

    protected function setUp(): void
    {
        // dependencies
        $this->domain    = $this->createMock(CreateUserDomain::class);
        $this->urlHelper = $this->createMock(UrlHelper::class);

        // parameters
        $this->request = $this->createMock(ServerRequestInterface::class);
    }

    private function sut(): ResponseInterface // subject under test
    {
        return (new CreateUserAction($this->domain, $this->urlHelper))->handle($this->request);
    }

    public function testWhenUserCreatedThenRespondWithRedirectResponse(): void
    {
        // given
        $this->request->method('getParsedBody')->willReturn([
            'email'    => 'example@email.com',
            'password' => 'lowerUPPER123@$!',
        ]);
        $this->domain->method('process')
            ->willReturn($this->createMock(UserCreatedDomainResult::class));

        // when
        $response = $this->sut();

        // then
        self::assertEquals(302, $response->getStatusCode());
    }

    public function testWhenNotReadyToCreateUserThenActionExitsEarly(): void
    {
        // given
        $this->request->method('getParsedBody')->willReturn([
            // missing required body
        ]);

        // then
        $this->expectException(OutOfBoundsException::class);

        // when
        $this->sut();
    }

    public function testWhenUserCreationFailsThenThenActionExitsEarly(): void
    {
        // given
        $this->domain->method('process')
            ->willReturn($this->createMock(UserNotCreatedDomainResult::class));

        // then
        $this->expectException(OutOfBoundsException::class);

        // when
        $this->sut();
    }
}
