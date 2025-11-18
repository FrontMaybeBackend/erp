<?php
namespace App\Security;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class JwtService
{
    public function __construct(private readonly ParameterBagInterface $parameterBag){}

    public function generateToken(string $email, int $ttl = 3600)
    {
        $privateKey = file_get_contents($this->parameterBag->get('jwt_private_key_path'));
        return JWT::encode(
            ['email' => $email,
                'iat' => time(),
                'exp' => time() + $ttl,
            ],
            $privateKey,
            'RS256'
        );
    }

    public function decodeToken (string $token)
    {
        return JWT::decode(
            $token,
            new Key(file_get_contents($this->parameterBag->get('jwt_public_key_path')), 'RS256')
        );
    }

}
