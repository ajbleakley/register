<?php

declare(strict_types=1);

namespace App\ADR\Domain\CreateUser;

use App\ADR\Domain\DomainRequestInterface;
use InvalidArgumentException;
use Laminas\Validator\EmailAddress;
use Laminas\Validator\Regex;

use function sprintf;

class CreateUserDomainRequest implements DomainRequestInterface
{
    private const REQUIRED_FIELDS = ['email', 'password'];

    private const EXCEPTION_MESSAGE_TEMPLATE = 'Please provide a valid %s';

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
        if (! (new EmailAddress())->isValid($this->email)) {
            throw new InvalidArgumentException(sprintf(self::EXCEPTION_MESSAGE_TEMPLATE, $this->email));
        }

        // Could use [Undisclosed Password Validator](https://docs.laminas.dev/laminas-validator/validators/undisclosed-password/)
        if (! (new Regex(self::PASSWORD_REGEX))->isValid($this->password)) {
            throw new InvalidArgumentException(sprintf(self::EXCEPTION_MESSAGE_TEMPLATE, $this->password));
        }
    }
}
