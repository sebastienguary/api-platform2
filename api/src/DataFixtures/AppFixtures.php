<?php

namespace App\DataFixtures;

use App\Entity\Greeting;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
         $product = new Greeting();
         $manager->persist($product);

        $manager->flush();
    }
}
