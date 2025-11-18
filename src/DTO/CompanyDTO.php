<?php

namespace App\DTO;

use App\Entity\Company;
use Symfony\Component\ObjectMapper\Attribute\Map;

#[Map(target: Company::class)]
class CompanyDTO
{
    #[Map(target: 'companyName')]
    public string $companyName;
    #[Map(target: 'companyNip')]
    public string $companyNip;
    #[Map(target: 'email')]
    public string $email;
}
