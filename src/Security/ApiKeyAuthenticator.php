<?php

namespace App\Security;

use App\Entity\User;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Http\Authenticator\AbstractAuthenticator;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\SelfValidatingPassport;

/**
 * @see https://symfony.com/doc/current/security/custom_authenticator.html
 */
class ApiKeyAuthenticator extends AbstractAuthenticator
{
    /**
     * Called on every request to decide if this authenticator should be
     * used for the request. Returning `false` will cause this authenticator
     * to be skipped.
     */
    public function __construct(
        protected UserProviderInterface $userProvider,
        protected ParameterBagInterface $parameterBag,
    ) {
    }

    public function supports(Request $request): ?bool
    {
        return $request->cookies->has('ACCESS_TOKEN_ERP');
    }

    public function authenticate(Request $request): SelfValidatingPassport
    {
        $auth = $request->cookies->get('ACCESS_TOKEN_ERP');

        if (!$auth) {
            throw new CustomUserMessageAuthenticationException('No API token provided');
        }

        $token = substr($auth, 7);

        if (empty($token)) {
            throw new CustomUserMessageAuthenticationException('empty token!!');
        }

        if ($token) {
            $decodedValue = JWT::decode(
                $token,
                new Key(file_get_contents($this->parameterBag->get('jwt_public_key_path')), 'RS256')
            );
        }

        $user = $decodedValue->email ?? null;
        if (!$user) {
            throw new CustomUserMessageAuthenticationException('Invalid token payload');
        }

        return new SelfValidatingPassport(
            new UserBadge($user, function ($user) {
                return new User();
            })
        );
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): ?Response
    {
        return null;
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception): ?Response
    {
        $data = [
            'message' => strtr($exception->getMessageKey(), $exception->getMessageData()),
        ];

        return new JsonResponse($data, Response::HTTP_UNAUTHORIZED);
    }

    public function start(Request $request, ?AuthenticationException $authException = null): Response
    {
        $data = ['message' => 'Authentication Required'];

        return new JsonResponse($data, Response::HTTP_UNAUTHORIZED);
    }
}
