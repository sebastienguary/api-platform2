<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class UserFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
       

        $user = (new User())->setEmail('sebastien@guary.org')->setPassword('$2y$13$YO9UJrwnE8xp5ay9cZDvDerKjP3oCcycuoZmZHJ7tmwWBKSG5w6nO');
        $manager->persist($user);

        $manager->flush();    }
}
