<?php

declare(strict_types=1);

namespace App\Hydrator;

use Laminas\Hydrator\ObjectPropertyHydrator;
use Laminas\Hydrator\Strategy\DateTimeFormatterStrategy;
use Laminas\Hydrator\Strategy\DateTimeImmutableFormatterStrategy;

class StrategicObjectPropertyHydrator extends ObjectPropertyHydrator
{
    public function __construct()
    {
        $this->addStrategy('createdAt', new DateTimeImmutableFormatterStrategy(new DateTimeFormatterStrategy()));
        $this->addStrategy('updatedAt', new DateTimeImmutableFormatterStrategy(new DateTimeFormatterStrategy()));
    }
}
