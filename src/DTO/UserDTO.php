<?php

namespace App\DTO;

use App\Entity\User;
use Symfony\Component\ObjectMapper\Attribute\Map;

#[Map(target: User::class)]
class UserDTO
{
    #[Map(target: 'email')]
    public string $email;
    #[Map(target: 'password')]
    public string $password;
}
