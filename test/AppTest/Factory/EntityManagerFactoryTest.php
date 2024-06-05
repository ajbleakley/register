<?php

declare(strict_types=1);

namespace AppTest\Factory;

use App\Factory\EntityManagerFactory;
use Doctrine\ORM\EntityManagerInterface;
use Laminas\ServiceManager\ServiceManager;
use PHPUnit\Framework\TestCase;

class EntityManagerFactoryTest extends TestCase
{
    public function testWhenFactoryIsInvokedThenItBuildsEntityManager(): void
    {
        $object = (new EntityManagerFactory())(new ServiceManager(), EntityManagerInterface::class);
        $this->assertInstanceOf(EntityManagerInterface::class, $object);
    }
}
