<?php

declare(strict_types=1);

namespace AppTest\Initializer;

use App\Initializer\LoggerAwareInitializer;
use Laminas\ServiceManager\ServiceManager;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerInterface;

class LoggerAwareInitializerTest extends TestCase
{
    public function testWhenInitializedObjectIsLoggerAwareThenLoggerInjectedAsDependency(): void
    {
        $container = new ServiceManager();
        $container->setService(LoggerInterface::class, $this->createMock(LoggerInterface::class));

        $instance = $this->createMock(LoggerAwareInterface::class);
        $instance->expects($this->once())->method('setLogger');

        (new LoggerAwareInitializer())($container, $instance);
    }

    public function testWhenInitializedObjectIsNotLoggerAwareThenLoggerNotInjectedAsDependency(): void
    {
        $container = $this->createMock(ContainerInterface::class);
        $container->expects($this->never())->method('get');

        (new LoggerAwareInitializer())($container, new class {
        });
    }
}
