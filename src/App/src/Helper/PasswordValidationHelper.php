<?php

declare(strict_types=1);

namespace App\Helper;

use Laminas\Validator\Regex;

class PasswordValidationHelper
{
    /*
     * Password regex - at least 1 upper case letter, 1 lower case letter, 1 number, and 1 special character
     */
    private const PASSWORD_REGEX = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/';

    public function isValid(string $password): bool
    {
        // Could use https://docs.laminas.dev/laminas-validator/validators/undisclosed-password/
        return (new Regex(self::PASSWORD_REGEX))->isValid($password);
    }
}
