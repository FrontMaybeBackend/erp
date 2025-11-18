<?php

namespace App\Service;

use App\DTO\CompanyDTO;
use App\Factory\CompanyFactory;
use App\Repository\CompanyRepository;

class CompanyService
{
    public function __construct(protected CompanyFactory $companyFactory, protected CompanyRepository $companyRepository, protected UserService $userService)
    {
    }

    public function createCompany(CompanyDTO $companyDTO): void
    {
        $user = $this->userService->registerNewUser($companyDTO);
        $company = $this->companyFactory->createCompany($companyDTO, $user);
        $this->companyRepository->save($company);
    }
}
