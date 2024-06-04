<?php

declare(strict_types=1);

namespace App\Factory;

use Laminas\ServiceManager\Factory\FactoryInterface;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Psr\Container\ContainerInterface;

class LoggerFactory implements FactoryInterface
{
    /**
     * @inheritDoc
     */
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null)
    {
        $logger = new Logger('name');
        $logger->pushHandler(new StreamHandler('data/log/test.log'));
        return $logger;
    }
}
