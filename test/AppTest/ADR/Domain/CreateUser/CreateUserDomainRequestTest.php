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

    public static function invalidPasswordProvider(): array
    {
        return [
            'empty'      => [''],
            'no lower'   => ['UPPER123@$!'],
            'no upper'   => ['lower123@$!'],
            'no number'  => ['lowerUPPER@$!'],
            'no special' => ['lowerUPPER123'],
        ];
    }

    /**
     * @dataProvider invalidPasswordProvider
     */
    public function testWhenInvalidPasswordProvidedThenDomainRequestIsInvalid(string $password): void
    {
        $this->expectException(InvalidArgumentException::class);
        new CreateUserDomainRequest('invalid_email.com', $password);
    }
}
