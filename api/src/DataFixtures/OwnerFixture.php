<?php

namespace App\DataFixtures;

use App\Entity\Owner;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class OwnerFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {

        $owner = (new Owner())->setEmail('sebastien@guary.org')
        ->setPassword('$2y$13$xIcxj0nJj3BozK/tInfEmO8M4xdA8uMA8ysAQoqKRryjquz7Gd3G6');

        $manager->persist($owner);

        $manager->flush();
    }
}
