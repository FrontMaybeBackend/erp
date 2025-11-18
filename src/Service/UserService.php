<?php

namespace App\Service;

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

    public function registerNewUser($dto): void
    {
        $user = new User();
        $passwordHash = $this->passwordHasher->hashPassword($user, $dto->password);
        $user->setPassword($passwordHash);
        $user->setEmail($dto->email);
        $this->repository->save($user);
    }
}
