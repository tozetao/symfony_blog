<?php

namespace App\Tests\IntegrationTest;

use App\Factory\PostFactory;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class EntityManagerTest extends KernelTestCase
{
    public function testSomething(): void
    {
        $kernel = self::bootKernel();

        $this->assertSame('test', $kernel->getEnvironment());
        $entityManager = static::getContainer()->get('doctrine.orm.entity_manager');
        $this->assertInstanceOf(EntityManagerInterface::class, $entityManager);

        $factory = static::getContainer()->get('App\Factory\PostFactory');
        $this->assertInstanceOf(PostFactory::class, $factory);

        $post1 = $factory->create('this is title1', 'this is body1');
        $post2 = $factory->create('this is title2', 'this is body2');
        $entityManager->persist($post1);
        $entityManager->persist($post2);

        $entityManager->flush();
    }
}
