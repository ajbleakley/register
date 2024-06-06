<?php

declare(strict_types=1);

namespace AppTest\ADR\Action\API;

use App\ADR\Action\API\CreateUserAction;
use App\ADR\Domain\CreateUser\CreateUserDomain;
use App\ADR\Domain\CreateUser\UserCreatedDomainResult;
use App\ADR\Domain\CreateUser\UserNotCreatedDomainResult;
use App\ADR\Responder\API\JsonResponder;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class CreateUserActionTest extends TestCase
{
    // dependencies
    private CreateUserDomain $domain;
    private JsonResponder $responder;

    // parameters
    private ServerRequestInterface $request;

    protected function setUp(): void
    {
        // dependencies
        $this->domain    = $this->createMock(CreateUserDomain::class);
        $this->responder = new JsonResponder();

        // parameters
        $this->request = $this->createMock(ServerRequestInterface::class);
    }

    private function sut(): ResponseInterface // subject under test
    {
        return (new CreateUserAction($this->domain, $this->responder))->handle($this->request);
    }

    public function testWhenUserCreatedThenRespondWithSuccessResponse(): void
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
        self::assertEquals(200, $response->getStatusCode());
    }

    public function testWhenNotReadyToCreateUserThenRespondWithFailureResponse(): void
    {
        // given
        $this->request->method('getParsedBody')->willReturn([
            // missing required body
        ]);

        // when
        $response = $this->sut();

        // then
        self::assertEquals(400, $response->getStatusCode());
    }

    public function testWhenUserCreationFailsThenRespondWithFailureResponse(): void
    {
        // given
        $this->domain->method('process')
            ->willReturn($this->createMock(UserNotCreatedDomainResult::class));

        // when
        $response = $this->sut();

        // then
        self::assertEquals(400, $response->getStatusCode());
    }
}
