<?php

declare(strict_types=1);

namespace AppTest\Entity\User;

use App\Entity\User\Email;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class EmailTest extends TestCase
{
    public function testWhenInvalidEmailThenObjectNotInstantiated(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new Email('invalid_email.com');
    }

    public function testWhenValidEmailThenObjectInstantiated(): void
    {
        $this->expectNotToPerformAssertions();
        new Email('valid@email.com');
    }
}
