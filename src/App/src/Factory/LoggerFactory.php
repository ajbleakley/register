<?php

declare(strict_types=1);

namespace App\Factory;

use DateTimeImmutable;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Psr\Container\ContainerInterface;

use function sprintf;

class LoggerFactory implements FactoryInterface
{
    private const STREAM_PATH = 'data/log/%s.log';

    /**
     * @inheritDoc
     */
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null)
    {
        $logger = new Logger('default');
        $logger->pushHandler(
            new StreamHandler(sprintf(self::STREAM_PATH, (new DateTimeImmutable())->format('Ymd')))
        );
        return $logger;
    }
}
