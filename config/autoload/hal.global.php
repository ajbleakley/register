<?php

declare(strict_types=1);

use App\Entity\User\User;
use App\Entity\User\UserCollection;
use App\Entity\User\UserHydrator;
use Mezzio\Hal\Metadata\MetadataMap;
use Mezzio\Hal\Metadata\RouteBasedCollectionMetadata;
use Mezzio\Hal\Metadata\RouteBasedResourceMetadata;

return [
    MetadataMap::class => [
        [
            '__class__'      => RouteBasedResourceMetadata::class,
            'resource_class' => User::class,
            'route'          => 'api.users',
            'extractor'      => UserHydrator::class,
        ],
        [
            '__class__'           => RouteBasedCollectionMetadata::class,
            'collection_class'    => UserCollection::class,
            'collection_relation' => 'users',
            'route'               => 'api.users',
        ],
    ],
];
