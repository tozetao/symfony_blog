<?php

namespace App\DataFixtures;

use App\Factory\PostFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class PostFixtures extends Fixture
{
    private $postFactory;

    public function __construct(PostFactory $postFactory) 
    {
        $this->postFactory = $postFactory;
    }

    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);
        for ($i = 0; $i < 5; $i++) { 
            $post = $this->postFactory->create('Fake post title ' . $i, 'Fake post body' . $i);
            if ($i%2 == 0) {
                $post->setStatus(0);
            }
            $manager->persist($post);
        }
        $manager->flush();
    }
}
