<?php

declare(strict_types=1);

namespace App\Initializer;

use Laminas\ServiceManager\Initializer\InitializerInterface;
use Psr\Container\ContainerInterface;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerInterface;

class LoggerAwareInitializer implements InitializerInterface
{
    /**
     * @inheritDoc
     */
    public function __invoke(ContainerInterface $container, $instance)
    {
        if ($instance instanceof LoggerAwareInterface) {
            /** @var LoggerInterface $logger */
            $logger = $container->get(LoggerInterface::class);
            $instance->setLogger($logger);
        }
    }
}
