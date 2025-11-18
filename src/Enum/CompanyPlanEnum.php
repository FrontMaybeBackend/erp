<?php

namespace App\Enum;

enum CompanyPlanEnum: string
{
    case TRIAL = 'trial';
    case PARTIAL = 'partial';
    case YEAR = 'year';
}
