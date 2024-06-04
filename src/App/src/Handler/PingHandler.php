<?php

declare(strict_types=1);

namespace App\Handler;

use Laminas\Diactoros\Response\JsonResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Log\LoggerInterface;

use function time;

class PingHandler implements RequestHandlerInterface
{
    public function __construct(private readonly LoggerInterface $logger)
    {
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        // add records to the log
        $this->logger->warning('Foo');
        $this->logger->error('Bar');

        return new JsonResponse(['ack' => time()]);
    }
}
