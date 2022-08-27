<?php

namespace App\DataFixtures;

use App\Entity\Comment;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class CommentFixtures extends Fixture implements DependentFixtureInterface
{
    private $faker;

    public function __construct()
    {
        $this->faker = Factory::create('zh_CN');
    }

    public function load(ObjectManager $manager): void
    {
        $post = $this->getReference(PostFixtures::LastPost);
        $commentArray = [];
        for ($i = 0; $i < 50; $i++) {
            $comment = new Comment();
            $comment->setAuthor($this->faker->name());
            $comment->setEmail($this->faker->email());
            $comment->setContent($this->faker->paragraph());
            $comment->setCreatedAt($this->faker->dateTime());

            if ($i > 0 && $this->faker->boolean()) {
                $parentComment = $this->faker->randomElement($commentArray);
                $comment->setParent($parentComment);
                $comment->setLevel($parentComment->getLevel() + 1);
            } else {
                $comment->setPost($post);
            }

            $manager->persist($comment);
            $commentArray[] = $comment;
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [PostFixtures::class];
    }
}
