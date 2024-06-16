<?php

declare(strict_types=1);

namespace AppTest\ADR\Action\API;

use App\ADR\Action\API\ModifyUserAction;
use App\Service\UserService;
use Laminas\Diactoros\Response\RedirectResponse;
use Mezzio\Helper\UrlHelper;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class ModifyUserActionTest extends TestCase
{
    // dependencies
    private UserService $users;
    private UrlHelper $urlHelper;

    // parameters
    private ServerRequestInterface $request;

    protected function setUp(): void
    {
        // dependencies
        $this->users     = $this->createMock(UserService::class);
        $this->urlHelper = $this->createMock(UrlHelper::class);

        // parameters
        $this->request = $this->createMock(ServerRequestInterface::class);
        $this->request->method('getAttribute')->willReturn('identifier');
    }

    private function sut(): ResponseInterface  // subject under test
    {
        return (new ModifyUserAction($this->users, $this->urlHelper))
            ->handle($this->request);
    }

    public function testWhenUserDeletedThenEmptySuccessResponseIssued(): void
    {
        // given
        $this->request->method('getMethod')
            ->willReturn('delete');

        // when
        $response = $this->sut();

        // then
        self::assertEquals(200, $response->getStatusCode());
    }

    public function testWhenPasswordIsNotUpdatedThenUserIsNotSaved(): void
    {
        // given
        $this->request->method('getMethod')
            ->willReturn('patch');
        $this->request->method('getParsedBody')
            ->willReturn([]); // no password

        // expect
        $this->users->expects(self::never())
            ->method('saveUser');

        // when
        $this->sut();
    }

    public function testWhenPasswordIsUpdatedThenUserIsSaved(): void
    {
        // given
        $this->request->method('getMethod')
            ->willReturn('patch');
        $this->request->method('getParsedBody')
            ->willReturn(['password' => 'updated_password']);

        // expect
        $this->users->expects(self::atLeastOnce())
            ->method('saveUser');

        // when
        $this->sut();
    }

    public function testWhenSuccessfulUpdateRequestThenRedirectResponse(): void
    {
        // given
        $this->request->method('getMethod')
            ->willReturn('patch');
        $this->request->method('getParsedBody')
            ->willReturn(['password' => 'updated_password']);

        // when
        $response = $this->sut();

        // then
        self::assertInstanceOf(RedirectResponse::class, $response);
    }
}
