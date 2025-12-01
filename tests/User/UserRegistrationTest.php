<?php

namespace App\Tests\User;

use App\Repository\CompanyRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UserRegistrationTest extends WebTestCase
{

    public function testCreateCompany(): void
    {
        $client = static::createClient();
        $payload = [
            'companyName' => 'test',
            'companyNip' => '123123123',
            'email' => 'testemail@test.com',
        ];
        $client->request('POST', 'create/company', server: [
            'CONTENT_TYPE' => 'application/json',
            'HTTP_ACCEPT' => 'application/json',
        ], content: json_encode($payload));

        $response = $client->getResponse();

        $this->assertResponseIsSuccessful();
        $this->assertJson($response->getContent());
        $data = json_decode($response->getContent(), true);
        $companyRepository = static::getContainer()->get(CompanyRepository::class);
        $company = $companyRepository->findOneBy(['companyName' => 'test']);
        $this->assertNotNull($company);
        $this->assertEquals('Company created successfully', $data['message']);
    }
}
