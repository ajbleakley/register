<?php

declare(strict_types=1);

namespace App\ADR\Domain\CreateUser;

use App\ADR\Domain\DomainRequestInterface;
use App\ADR\Domain\InvalidDomainRequestException;
use Laminas\Validator\EmailAddress;
use Laminas\Validator\Regex;

class CreateUserDomainRequest implements DomainRequestInterface
{
    private const REQUIRED_FIELDS = ['email', 'password'];

    /*
     * Password regex - at least 1 upper case letter, 1 lower case letter, 1 number, and 1 special character
     */
    private const PASSWORD_REGEX = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/';

    public function __construct(private readonly string $email, private readonly string $password)
    {
        $this->validate();
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @inheritDoc
     */
    public function validate(): void
    {
        $validationMessages = [];

        if (! (new EmailAddress())->isValid($this->email)) {
            $validationMessages[] = 'Please provide a valid email';
        }

        // Could use https://docs.laminas.dev/laminas-validator/validators/undisclosed-password/
        if (! (new Regex(self::PASSWORD_REGEX))->isValid($this->password)) {
            $validationMessages[] = 'Please provide a secure password';
        }

        if (! empty($validationMessages)) {
            throw new InvalidDomainRequestException($validationMessages);
        }
    }
}
