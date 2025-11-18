<?php

namespace App\Service;

use App\DTO\CompanyDTO;
use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserService
{
    public function __construct(
        protected UserPasswordHasherInterface $passwordHasher,
        protected UserRepository $repository,
    ) {
    }

    public function registerNewUser(CompanyDTO $dto): User
    {
        $user = new User();
        $passwordHash = $this->passwordHasher->hashPassword($user, $dto->email);
        $user->setPassword($passwordHash);
        $user->setEmail($dto->email);

        return $user;
    }
}
