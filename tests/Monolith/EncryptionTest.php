<?php

namespace App\Tests\Monolith;

use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;

class EncryptionTest extends ApiTestCase
{
    public function testSomething(): void
    {
        $response = static::createClient()->request('GET', '/');

        $this->assertResponseIsSuccessful();
        $this->assertJsonContains(['@id' => '/']);
    }
}
