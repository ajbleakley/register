#!/usr/bin/env php
<?php

declare(strict_types=1);

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Tools\Console\ConsoleRunner;
use Doctrine\ORM\Tools\Console\EntityManagerProvider\SingleManagerProvider;
use Psr\Container\ContainerInterface;

chdir(__DIR__ . '/../');

require 'vendor/autoload.php';

/** @var ContainerInterface $container */
$container = require 'config/container.php';

/** @var EntityManagerInterface $entityManager */
$entityManager = $container->get(EntityManagerInterface::class);

ConsoleRunner::run(
    new SingleManagerProvider($entityManager)
);
