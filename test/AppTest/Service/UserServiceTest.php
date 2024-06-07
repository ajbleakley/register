<?php

declare(strict_types=1);

namespace AppTest\Service;

use App\Entity\User;
use App\Service\UserService;
use Doctrine\DBAL\DriverManager;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\ORMSetup;
use Doctrine\ORM\Tools\SchemaTool;
use PHPUnit\Framework\TestCase;

class UserServiceTest extends TestCase
{
    // dependencies
    private EntityManagerInterface $entityManager;

    protected function setUp(): void
    {
        // dependencies
        $this->entityManager = $this->createTestEntityManager();

        // rebuild test schema
        $classes    = [$this->entityManager->getClassMetadata(User::class)];
        $schemaTool = new SchemaTool($this->entityManager);
        $schemaTool->dropSchema($classes);
        $schemaTool->createSchema($classes);
    }

    private function sut(): UserService // subject under test
    {
        return new UserService($this->entityManager);
    }

    private function createTestEntityManager(): EntityManagerInterface
    {
        $config = ORMSetup::createAttributeMetadataConfiguration(
            paths: [__DIR__ . '/../../../src/App/src/Entity'],
        );

        $connection = DriverManager::getConnection([
            'driver' => 'pdo_sqlite',
            'path'   => __DIR__ . '/../../db.sqlite',
        ], $config);

        return new EntityManager($connection, $config);
    }

    public function testWhenUserIsSaved(): void
    {
        $user = new User('user@email.com', 'password');
        $this->sut()->saveUser($user);
        $fetchedUser = $this->sut()->fetchByIdentifier($user->identifier());
        self::assertNotNull($fetchedUser);
    }

    public function testWhenUserDoesNotAlreadyExistForEmail(): void
    {
        $user = new User('user@email.com', 'password');
        self::assertFalse($this->sut()->isEmailAlreadyRegistered($user->email()));
    }

    public function testWhenUserAlreadyExistForEmail(): void
    {
        $user = new User('user@email.com', 'password');
        $this->sut()->saveUser($user);
        self::assertTrue($this->sut()->isEmailAlreadyRegistered($user->email()));
    }
}
