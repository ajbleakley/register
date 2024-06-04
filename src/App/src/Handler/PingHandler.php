<?php

declare(strict_types=1);

namespace App\Handler;

use Laminas\Diactoros\Response\JsonResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerAwareTrait;

use function time;

class PingHandler implements RequestHandlerInterface, LoggerAwareInterface
{
    use LoggerAwareTrait;

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $this->logger->info('Ping handler invoked');
        return new JsonResponse(['ack' => time()]);
    }
}
