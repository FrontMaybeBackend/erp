<?php

namespace App\Controller;

use App\DTO\UserDTO;
use App\Service\UserService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\ObjectMapper\ObjectMapperInterface;
use Symfony\Component\Routing\Attribute\Route;

final class RegisterController extends AbstractController
{
    #[Route('/register', name: 'app_register')]
    public function index(Request $request, UserService $userService, ObjectMapperInterface $objectMapper): JsonResponse
    {
        $data = json_decode($request->getContent());
        $dto = $objectMapper->map($data, UserDTO::class);
        $userService->registerNewUser($dto);

        return $this->json([
            'message' => 'Register successfully!',
            'path' => 'src/Controller/RegisterController.php',
        ]);
    }
}
