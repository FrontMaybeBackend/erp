<?php

namespace App\Security;

use Symfony\Component\HttpFoundation\Cookie;

class JwtManager
{
    public function createAccessTokenCookie(string $token): Cookie
    {
        return Cookie::create('ACCESS_TOKEN_ERP')
            ->withValue($token)
            ->withHttpOnly(true)
            ->withSecure(false)
            ->withSameSite('lax')
            ->withPath('/')
            ->withExpires(time() + 3600);
    }

    public function clearAccessTokenCookie(): Cookie
    {
        return Cookie::create('ACCESS_TOKEN_ERP')
            ->withValue('')
            ->withHttpOnly(true)
            ->withSecure(false)
            ->withSameSite('lax')
            ->withPath('/')
            ->withExpires(1);
    }
}
