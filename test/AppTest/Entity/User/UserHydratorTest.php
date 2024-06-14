<?php

declare(strict_types=1);

namespace AppTest\Entity\User;

use App\Entity\User\TestUser;
use App\Entity\User\UserHydrator;
use PHPUnit\Framework\TestCase;
use stdClass;

class UserHydratorTest extends TestCase
{
    public function testWhenUserExtractedThenExpectedKeysAreSet(): void
    {
        $email     = 'johndoe@example.com';
        $user      = new TestUser('johndoe@example.com', 'dummy_password');
        $extracted = (new UserHydrator())->extract($user);
        $this->assertArrayHasKey('identifier', $extracted);
        $this->assertArrayHasKey('created_at', $extracted);
        $this->assertArrayHasKey('updated_at', $extracted);
        $this->assertEquals($email, $extracted['email']);
    }

    public function testWhenNonUserExtractedThenExpectEmptyArray(): void
    {
        $extracted = (new UserHydrator())->extract(new stdClass());
        $this->assertEquals([], $extracted);
    }
}
