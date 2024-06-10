<?php

declare(strict_types=1);

use App\Entity\User\User;
use App\Hydrator\StrategicObjectPropertyHydrator;
use Mezzio\Hal\Metadata\MetadataMap;
use Mezzio\Hal\Metadata\RouteBasedResourceMetadata;

return [
    MetadataMap::class => [
        [
            '__class__'      => RouteBasedResourceMetadata::class,
            'resource_class' => User::class,
            'route'          => 'api.users',
            'extractor'      => StrategicObjectPropertyHydrator::class,
        ],
//        [
//            '__class__'           => RouteBasedResourceMetadata::class,
//            'collection_class'    => User::class,
//            'collection_relation' => 'users',
//            'route'               => 'api.users',
//        ],
    ],
];
