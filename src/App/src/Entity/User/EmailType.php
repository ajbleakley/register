<?php

declare(strict_types=1);

namespace App\Entity\User;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Exception\InvalidType;
use Doctrine\DBAL\Types\StringType;

use function is_string;

class EmailType extends StringType
{
    public const EMAIL = 'email';

    public function convertToDatabaseValue(mixed $value, AbstractPlatform $platform): ?string
    {
        if ($value === null) {
            return null;
        }

        if ($value instanceof Email) {
            return (string) $value;
        }

        throw InvalidType::new(
            $value,
            static::class,
            ['null', Email::class],
        );
    }

    public function convertToPHPValue(mixed $value, AbstractPlatform $platform): ?Email
    {
        if ($value === null || $value instanceof Email) {
            return $value;
        }

        if (! is_string($value)) {
            throw InvalidType::new(
                $value,
                static::class,
                ['null', 'string']
            );
        }

        return new Email($value);
    }

    public function getName(): string
    {
        return self::EMAIL;
    }
}
