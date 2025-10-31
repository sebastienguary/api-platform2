<?php

namespace App\DataFixtures;

use App\Entity\Breed;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class BreedFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // 30 example breeds
        $breeds = [
            'German Shepherd','Labrador Retriever','Beagle','Border Collie','Golden Retriever',
            'French Bulldog','Australian Shepherd','Boxer','Cocker Spaniel','Shiba Inu',
            'Poodle','Dachshund','Rottweiler','Siberian Husky','Great Dane',
            'Doberman','Chihuahua','Pug','Basset Hound','Bull Terrier',
            'Pointer','Saint Bernard','Mastiff','Papillon','Shar Pei',
            'Akita','Samoyed','Vizsla','Bernese Mountain Dog','Staffordshire Bull Terrier'
        ];
        foreach ($breeds as $breedName) {
            $breed = new Breed();
            $breed->setName($breedName);
            $manager->persist($breed);

        }

        $manager->flush();
    }
}
