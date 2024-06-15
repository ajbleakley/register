<?php

declare(strict_types=1);

namespace AppTest\ADR\Action\API;

use App\ADR\Action\API\ModifyUserAction;
use App\Entity\User\TestUser;
use App\Entity\User\UserInterface;
use App\Exception\NoResourceFoundException;
use App\Service\UserService;
use Doctrine\ORM\NoResultException;
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

    public function testWhenUserNotFoundThenHandlerExitsEarly(): void
    {
        // given
        $this->users->method('fetchByIdentifier')
            ->willThrowException(new NoResultException());

        // expect
        $this->users->expects(self::never())
            ->method('saveUser');
        $this->expectException(NoResourceFoundException::class);

        // when
        $this->sut();
    }

    public function testWhenPasswordIsNotUpdatedThenUserIsNotSaved(): void
    {
        // given
        $this->users->method('fetchByIdentifier')
            ->willReturn($this->createMock(UserInterface::class));

        // expect
        $this->users->expects(self::never())
            ->method('saveUser');

        // when
        $this->sut();
    }

    public function testWhenPasswordIsUpdatedThenUserIsSaved(): void
    {
        // given
        $this->users->method('fetchByIdentifier')
            ->willReturn(new TestUser('johndoe@example.com', 'original_password'));
        $this->request->method('getParsedBody')
            ->willReturn(['password' => 'updated_password']);

        // expect
        $this->users->expects(self::atLeastOnce())
            ->method('saveUser');

        // when
        $this->sut();
    }

    public function testWhenResponseIssuedThenRedirectResponse(): void
    {
        // given
        $this->users->method('fetchByIdentifier')
            ->willReturn(new TestUser('johndoe@example.com', 'original_password'));
        $this->request->method('getParsedBody')
            ->willReturn(['password' => 'updated_password']);

        // when
        $response = $this->sut();

        // then
        self::assertInstanceOf(RedirectResponse::class, $response);
    }
}
