<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Species;
use App\Entity\Breed;
use App\Entity\Pet;
use App\Entity\Owner;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;

class AppFixtures extends Fixture implements FixtureGroupInterface
{
    public function load(ObjectManager $manager): void
    {

        $owner = (new Owner())->setEmail('sebastien@guary.org')
        ->setPassword('$2y$13$xIcxj0nJj3BozK/tInfEmO8M4xdA8uMA8ysAQoqKRryjquz7Gd3G6');

        $manager->persist($owner);



        $species = ['Dog','Cat','Bird','Fish','Reptile','Rodent'];

        foreach ($species as $speciesName) {
            $species = new Species();
            $species->setName($speciesName);
            $manager->persist($species);

        }
        $manager->flush();



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
            $breed = new Breed();
            $breed->setName($breedName);
            $breed->setSpecies(
                $manager->getRepository(Species::class)->findOneBy(['name' => 'Dog'])
            );
            $manager->persist($breed);

        }

        $catBreeds = [
            'Persian','Maine Coon','Siamese','Ragdoll','Bengal',
            'Sphynx','British Shorthair','Abyssinian','Scottish Fold','Norwegian Forest Cat',
            'Birman','Oriental Shorthair','Devon Rex','Cornish Rex','American Shorthair'
        ];

        foreach ($catBreeds as $breedName) {
            $breed = new Breed();
            $breed->setName($breedName);
            $breed->setSpecies(
                $manager->getRepository(Species::class)->findOneBy(['name' => 'Cat'])
            );
            $manager->persist($breed);
        }

        $manager->flush();

        $names = [
            'Rex','Bella','Charlie','Luna','Max','Milo','Nala','Rocky','Ruby','Simba',
            'Daisy','Buddy','Lucy','Cooper','Lola','Bailey','Sadie','Toby','Zoe','Oliver',
            'Maggie','Oscar','Sophie','Bentley','Harley','Lilly','Leo','Poppy','Jack','Mimi'
        ];

        $breeds = $manager->getRepository(Breed::class)->findAll();


        // Timestamp range: from now minus 10 years to now
        $endTs = (new \DateTimeImmutable())->getTimestamp();
        $startTs = (new \DateTimeImmutable())->modify('-10 years')->getTimestamp();
        $nbPets = (int) 100;

        for ($i = 0; $i < $nbPets; $i++) {
            $name = $names[array_rand($names)];

            // random timestamp between start and end
            $randTs = random_int($startTs, $endTs);
            $birthDate = (new \DateTimeImmutable())->setTimestamp($randTs)->setTime(0, 0);

            // Get a random breed from the breeds created in BreedFixtures

            $breed = $breeds[array_rand($breeds)];

            $pet = (new Pet())
                ->setName($name)
                ->setBreed($breed)
                ->setSpecies($breed->getSpecies())
                ->setBirthDate($birthDate);

            $manager->persist($pet);

            // Add a reference that other fixtures can use if needed
            $this->addReference('pet_'.($i + 1), $pet);
        }



        $manager->flush();




    }


    public static function getGroups(): array
    {
        return ['base', 'dev']; // cette fixture appartient aux groupes "base" et "dev"
    }
}
