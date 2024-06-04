<?php

declare(strict_types=1);

namespace AppTest\Factory;

use App\Factory\LoggerFactory;
use Laminas\ServiceManager\ServiceManager;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;

class LoggerFactoryTest extends TestCase
{
    private function sut(): LoggerInterface // subject under test
    {
        return (new LoggerFactory())(new ServiceManager(), LoggerInterface::class);
    }

    public function testWhenLoggerBuiltThenLoggerNameIsDefault(): void
    {
        self::assertEquals('default', $this->sut()->getName());
    }

    public function testWhenLoggerBuiltThenLoggerHasAtLeastOneHandler(): void
    {
        self::assertGreaterThan(0, $this->sut()->getHandlers());
    }
}
