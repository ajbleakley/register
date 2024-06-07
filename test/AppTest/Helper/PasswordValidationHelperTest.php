<?php

declare(strict_types=1);

namespace AppTest\Helper;

use App\Helper\PasswordValidationHelper;
use PHPUnit\Framework\TestCase;

class PasswordValidationHelperTest extends TestCase
{
    public function testWhenValidPasswordThenReturnsTrue(): void
    {
        self::assertTrue((new PasswordValidationHelper())->isValid('lowerUPPER123@$!'));
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
    public function testWhenInvalidPasswordThenReturnsFalse(string $password): void
    {
        self::assertFalse((new PasswordValidationHelper())->isValid($password));
    }
}
