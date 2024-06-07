<?php

declare(strict_types=1);

namespace AppTest\ADR\Domain\CreateUser;

use App\ADR\Domain\CreateUser\CreateUserDomainRequest;
use Exception;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class CreateUserDomainRequestTest extends TestCase
{
    public function testWhenValidFieldsProvidedThenDomainRequestIsValid(): void
    {
        // Password validation - require at least 1 capital letter, 1 number, 1 special character, at least 8 characters
        try {
            new CreateUserDomainRequest('example@email.com', 'lowerUPPER123@$!');
            $this->assertTrue(true);
        } catch (Exception $exception) {
            $this->fail('Exception should not be thrown when valid fields provided');
        }
    }

    public function testWhenInvalidEmailProvidedThenDomainRequestIsInvalid(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new CreateUserDomainRequest('invalid_email.com', 'weak_password');
    }

    /**
     * Unit tests for password validation helper already test range of scenarios
     */
    public function testWhenInvalidPasswordProvidedThenDomainRequestIsInvalid(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new CreateUserDomainRequest('invalid_email.com', 'invalid_password');
    }
}
