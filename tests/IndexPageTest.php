<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class IndexPageTest extends WebTestCase
{
    public function testIndexPage(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/post');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Post index');
    }

    // php bin/console make:test
    // WebTestCase
}
