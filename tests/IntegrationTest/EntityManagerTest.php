<?php

namespace App\Tests\IntegrationTest;

use App\Entity\Post;
use App\Factory\PostFactory;
use App\Repository\PostRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class EntityManagerTest extends KernelTestCase
{
    private $entityManager;
    protected function setUp(): void
    {
        self::bootKernel();
        $this->entityManager = static::getContainer()->get('doctrine.orm.entity_manager');
        $this->truncateEntities([Post::class]);
    }

    public function testQueryBuilder()
    {
        $factory = static::getContainer()->get('App\Factory\PostFactory');
        $this->assertInstanceOf(PostFactory::class, $factory);

        $post1 = $factory->create('this is title1', 'this is body1');
        $post2 = $factory->create('this is title2', 'this is body2');
        $this->entityManager->persist($post1);
        $this->entityManager->persist($post2);
        $this->entityManager->flush();

        $postRepo = static::getContainer()->get(PostRepository::class);
        $this->assertInstanceOf(PostRepository::class, $postRepo);
        $findByTitles = $postRepo->findByTitle('title1');
        $this->assertCount(1, $findByTitles);
        // $this->assertSame($post1->getTitle(), $findByTitles[0]->getTitle());

        $findByTitleDQL = $postRepo->findByTitleDQL('title1');
        $this->assertCount(1, $findByTitleDQL);
        // --filter=testQueryBuilder
    }

    public function testEntityManager(): void
    {
        $this->assertSame('test', self::$kernel->getEnvironment());
        $this->assertInstanceOf(EntityManagerInterface::class, $this->entityManager);

        $factory = static::getContainer()->get('App\Factory\PostFactory');
        $this->assertInstanceOf(PostFactory::class, $factory);

        $post1 = $factory->create('this is title1', 'this is body1');
        $post2 = $factory->create('this is title2', 'this is body2');
        $this->entityManager->persist($post1);
        $this->entityManager->persist($post2);

        $this->entityManager->flush();

        $postRepo = static::getContainer()->get(PostRepository::class);
        $this->assertInstanceOf(PostRepository::class, $postRepo);
        $posts = $postRepo->findAll();
        $this->assertCount(2, $posts);
    }

    private function truncateEntities(array $entities)
    {
        $connection = $this->entityManager->getConnection();
        $databasePlatform = $connection->getDatabasePlatform();
        if ($databasePlatform->supportsForeignKeyConstraints()) {
            $connection->executeQuery("set foreign_key_checks=0");
        }
        foreach ($entities as $entity) {
            $query = $databasePlatform->getTruncateTableSql(
                $this->entityManager->getClassMetadata($entity)->getTableName()
            );
            $connection->executeQuery($query);
        }
        if ($databasePlatform->supportsForeignKeyConstraints()) {
            $connection->executeQuery("set foreign_key_checks=1");
        }
    }
}
