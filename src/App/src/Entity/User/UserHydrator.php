<?php

declare(strict_types=1);

namespace App\Entity\User;

use Laminas\Hydrator\HydratorInterface;

class UserHydrator implements HydratorInterface
{
    /**
     * @inheritDoc
     */
    public function extract(object $object): array
    {
        if (! $object instanceof UserInterface) {
            return [];
        }

        return [
            'identifier' => $object->identifier(),
            'created_at' => $object->createdAt()->format('c'),
            'updated_at' => $object->updatedAt()->format('c'),
            'email'      => $object->email(),
        ];
    }

    /**
     * @inheritDoc
     */
    public function hydrate(array $data, object $object)
    {
        // Hydration is not required for read-only operations
        return $object;
    }
}
