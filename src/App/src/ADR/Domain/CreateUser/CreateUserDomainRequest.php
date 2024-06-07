<?php

declare(strict_types=1);

namespace App\ADR\Domain\CreateUser;

use App\ADR\Domain\DomainRequestInterface;
use App\ADR\Domain\InvalidDomainRequestException;
use App\Helper\PasswordValidationHelper;
use Laminas\Validator\EmailAddress;

class CreateUserDomainRequest implements DomainRequestInterface
{
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

        if (! (new PasswordValidationHelper())->isValid($this->password)) {
            $validationMessages[] = 'Please provide a secure password';
        }

        if (! empty($validationMessages)) {
            throw new InvalidDomainRequestException($validationMessages);
        }
    }
}
