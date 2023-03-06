<?php

namespace App\Tests\Functional;

use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;
use App\Entity\User;
use Hautelook\AliceBundle\PhpUnit\ReloadDatabaseTrait;


class AuthenticationTest extends ApiTestCase
{
    public function testRegisterAndLogin()
    {
        $client = self::createClient();
        $container = self::getContainer();
        $user = new User();
        $user->setEmail('abdaoui@jaafar.com');
        $user->setUsername('jaafar');
        $user->setPassword('$2y$13$lKS7WJcvMErAlglenZqJZecruQ9Od2tWu6gaMol6dk1Y91AH0V8li');
        $manager = $container->get('doctrine')->getManager();
        $manager->persist($user);
        $manager->flush();

        // retrieve a token
        $response = $client->request('POST', '/auth', [
            'headers' => ['Content-Type' => 'application/json'],
            'json' => [
                'email' => 'abdaoui@jaafar.com',
                'password' => 'password',
            ],
        ]);

        $json = $response->toArray();
        $this->assertResponseIsSuccessful();
        $this->assertArrayHasKey('token', $json);

        // test not authorized
        $client->request('GET', '/api/orders');
        $this->assertResponseStatusCodeSame(401);

        // test authorized
        $client->request('GET', '/api/products', ['auth_bearer' => $json['token']]);
        $this->assertResponseIsSuccessful();

    }
}

