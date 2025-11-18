<?php

namespace App\Controller;

use App\DTO\CompanyDTO;
use App\Service\CompanyService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\ObjectMapper\ObjectMapperInterface;
use Symfony\Component\Routing\Attribute\Route;

final class CompanyController extends AbstractController
{
    #[Route('/api/company', name: 'app_company')]
    public function index(): JsonResponse
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/CompanyController.php',
        ]);
    }

    #[Route('create/company', name: 'app_create_company', methods: ['POST'])]
    public function createCompany(Request $request, ObjectMapperInterface $objectMapper, CompanyService $companyService): JsonResponse
    {
        $data = json_decode($request->getContent());
        $companyDto = $objectMapper->map($data, CompanyDTO::class);
        $companyService->createCompany($companyDto);

        return $this->json([
            'message' => 'Company created successfully',
        ]);
    }
}
