<?php

namespace App\Enum;

enum CompanyActiveEnum: string
{
    case ACTIVE = 'active';
    case INACTIVE = 'inactive';
    case DELETED = 'deleted';

    case SUSPENDED = 'suspended';
}
