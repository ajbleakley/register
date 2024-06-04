<?php

declare(strict_types=1);

namespace App\Handler;

use Laminas\Diactoros\Response\JsonResponse;
use Monolog\Handler\StreamHandler;
use Monolog\Level;
use Monolog\Logger;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

use function time;

class PingHandler implements RequestHandlerInterface
{
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        // create a log channel
        $log = new Logger('name');
        $log->pushHandler(new StreamHandler('data/log/test.log', Level::Warning));

        // add records to the log
        $log->warning('Foo');
        $log->error('Bar');

        return new JsonResponse(['ack' => time()]);
    }
}
