<?php

declare(strict_types=1);

namespace App\Factory;

use App\Entity\User\EmailType;
use Doctrine\DBAL\DriverManager;
use Doctrine\DBAL\Exception;
use Doctrine\DBAL\Types\Type;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMSetup;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Psr\Container\ContainerInterface;

class EntityManagerFactory implements FactoryInterface
{
    /**
     * @inheritDoc
     * @return EntityManager
     * @throws Exception
     */
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null)
    {
        if (! Type::hasType('email')) {
            Type::addType('email', EmailType::class);
        }

        // Create a simple "default" Doctrine ORM configuration for Attributes
        $config = ORMSetup::createAttributeMetadataConfiguration(
            paths: [__DIR__ . '/../Entity'],
            isDevMode: true,
        );

        // configuring the database connection
        $connection = DriverManager::getConnection([
            'driver' => 'pdo_sqlite',
            'path'   => __DIR__ . '/../../../../data/db.sqlite',
        ], $config);

        return new EntityManager($connection, $config);
    }
}
