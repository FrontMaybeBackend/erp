<?php

namespace App\Tests\User;

use App\DTO\CompanyDTO;
use App\Entity\User;
use App\Service\UserService;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class RegisterFromCompanyTest extends KernelTestCase
{

    public function testRegisterUserFromCompanyData(): void
    {
        $kernel = self::bootKernel();
        $userService = self::getContainer()->get(UserService::class);
        $companyDtoData = new CompanyDTO();
        $companyDtoData->email = 'test3@test.com';
        $companyDtoData->companyName = 'test';
        $companyDtoData->companyNip = '123123213';
        $user = $userService->registerNewUser($companyDtoData);
        $passwordHash = self::getContainer()->get(UserPasswordHasherInterface::class);
        $passwordVer = $passwordHash->isPasswordValid($user, $companyDtoData->email);
        $this->assertTrue($passwordVer);
        $this->assertInstanceOf(User::class, $user);
        $this->assertSame('test3@test.com', $user->getEmail());

    }
}
