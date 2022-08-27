<?php

namespace App\DataFixtures;

use App\Entity\Post;
use App\Factory\PostFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class PostFixtures extends Fixture
{
    public const LastPost = 'last_post';

    private $postFactory;
    private $faker;

    public function __construct(PostFactory $postFactory) 
    {
        $this->postFactory = $postFactory;
        $this->faker = Factory::create();
    }

    public function load(ObjectManager $manager): void
    {
        $lastPost = null;

        for ($i = 0; $i < 20; $i++) {
            $sentence = $this->faker->sentence(3);
            $post = $this->postFactory->create(
                $sentence,
                $this->faker->paragraph()
            );
            if ($this->faker->boolean()) {
                $post->setStatus(Post::Published);
            } else {
                $post->setStatus(Post::Draft);
            }
            $image = '00' . $this->faker->randomDigit() . '.jpg';
            $post->setPostImage($image);

            if ($i == 19) {
                $post->setStatus(Post::Published);
                $lastPost = $post;
            }

            $manager->persist($post);
        }
        $manager->flush();

        $this->addReference(self::LastPost, $lastPost);

        echo "load data\n";
    }
}
