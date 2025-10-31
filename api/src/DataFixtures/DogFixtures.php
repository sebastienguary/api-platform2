<?php

namespace App\DataFixtures;

use App\Entity\Dog;
use App\Entity\Breed;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class DogFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // Number of dogs to generate. Change this value to create a different amount,
        // or set the env var DOG_FIXTURES_COUNT to override it when running fixtures.
        $nbDogs = (int) ($_ENV['DOG_FIXTURES_COUNT'] ?? 1000);
        $nbDogs = (int) 1000;

        // 30 example dog names (you can replace/translate them as needed)
        $names = [
            'Rex','Bella','Charlie','Luna','Max','Milo','Nala','Rocky','Ruby','Simba',
            'Daisy','Buddy','Lucy','Cooper','Lola','Bailey','Sadie','Toby','Zoe','Oliver',
            'Maggie','Oscar','Sophie','Bentley','Harley','Lilly','Leo','Poppy','Jack','Mimi'
        ];

        $breeds = $manager->getRepository(Breed::class)->findAll();


        // Timestamp range: from now minus 10 years to now
        $endTs = (new \DateTimeImmutable())->getTimestamp();
        $startTs = (new \DateTimeImmutable())->modify('-10 years')->getTimestamp();

        for ($i = 0; $i < $nbDogs; $i++) {
            $name = $names[array_rand($names)];

            // random timestamp between start and end
            $randTs = random_int($startTs, $endTs);
            $birthDate = (new \DateTimeImmutable())->setTimestamp($randTs)->setTime(0, 0);

            // Get a random breed from the breeds created in BreedFixtures

            $breed = $breeds[array_rand($breeds)];

            $dog = (new Dog())
                ->setName($name)
                ->setBreed($breed)
                ->setBirthDate($birthDate);

            $manager->persist($dog);

            // Add a reference that other fixtures can use if needed
            $this->addReference('dog_'.($i + 1), $dog);
        }
        $manager->flush();
    }


}
