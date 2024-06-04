<?php

declare(strict_types=1);

namespace AppTest\Handler;

use App\Handler\PingHandler;
use ColinODell\PsrTestLogger\TestLogger;
use Laminas\Diactoros\Response\JsonResponse;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

use function json_decode;
use function property_exists;

use const JSON_THROW_ON_ERROR;

class PingHandlerTest extends TestCase
{
    private TestLogger $logger;

    protected function setUp(): void
    {
        $this->logger = new TestLogger();
    }

    private function sut(): ResponseInterface
    {
        $handler = new PingHandler();
        $handler->setLogger($this->logger);
        return $handler->handle($this->createMock(ServerRequestInterface::class));
    }

    public function testWhenPingHandlerInvokedThenJsonResponseReturned(): void
    {
        $response = $this->sut();

        $json = json_decode((string) $response->getBody(), null, 512, JSON_THROW_ON_ERROR);

        self::assertInstanceOf(JsonResponse::class, $response);
        self::assertTrue(property_exists($json, 'ack') && $json->ack !== null);
    }

    public function testWhenPingHandlerInvokedThenInfoMessageLogged(): void
    {
        $this->sut();
        self::assertTrue($this->logger->hasInfo('Ping handler invoked'));
    }
}
