<?php

declare(strict_types=1);

namespace App\Factory;

use Doctrine\DBAL\DriverManager;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMSetup;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Psr\Container\ContainerInterface;

class EntityManagerFactory implements FactoryInterface
{
    /**
     * @inheritDoc
     * @return EntityManager
     */
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null)
    {
        // Create a simple "default" Doctrine ORM configuration for Attributes
        $config = ORMSetup::createAttributeMetadataConfiguration(
            paths: [__DIR__ . '/../Entity'],
            isDevMode: true,
        );

        // configuring the database connection
        $connection = DriverManager::getConnection([
            'driver' => 'pdo_sqlite',
            'path'   => __DIR__ . '/../../../../db.sqlite',
        ], $config);

        return new EntityManager($connection, $config);
    }
}
