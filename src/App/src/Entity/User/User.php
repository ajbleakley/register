<?php

declare(strict_types=1);

namespace App\Entity\User;

use App\Entity\AbstractUpdatableEntity;
use App\Helper\PasswordValidationHelper;
use Doctrine\ORM\Mapping as ORM;
use OutOfBoundsException;

use function password_hash;
use function password_verify;

use const PASSWORD_DEFAULT;

#[ORM\Entity]
#[ORM\Table(name: 'users')]
class User extends AbstractUpdatableEntity implements UserInterface
{
    #[ORM\Column(type: 'string')]
    private string $username;

    #[ORM\Column(name: 'password_hash', type: 'string')]
    protected string $passwordHash;

    #[ORM\Column(type: 'email')]
    private Email $email;

    public function __construct(string $email, string $password)
    {
        parent::__construct();
        $this->username = $email;
        $this->email    = new Email($email);
        $this->updatePassword($password);
    }

    public function username(): string
    {
        return $this->username;
    }

    public function updatePassword(string $password): self
    {
        if (! (new PasswordValidationHelper())->isValid($password)) {
            throw new OutOfBoundsException('Invalid password');
        }

        $this->passwordHash = password_hash($password, PASSWORD_DEFAULT);
        return $this;
    }

    public function verifyPassword(string $password): bool
    {
        return password_verify($password, $this->passwordHash);
    }

    public function email(): Email
    {
        return $this->email;
    }
}
