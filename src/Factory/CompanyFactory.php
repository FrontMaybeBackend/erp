<?php

namespace App\Factory;

use App\DTO\CompanyDTO;
use App\Entity\Company;
use App\Entity\User;
use App\Enum\CompanyActiveEnum;
use App\Enum\CompanyPlanEnum;

final class CompanyFactory
{
    public function createCompany(CompanyDTO $dto, User $user): Company
    {
        $company = new Company(
            companyName: $dto->companyName,
            companyActive: CompanyActiveEnum::ACTIVE,
            company_nip: $dto->companyNip,
            email: $dto->email,
            plan: CompanyPlanEnum::TRIAL
        );
        $company->addUserId($user);

        return $company;
    }
}
