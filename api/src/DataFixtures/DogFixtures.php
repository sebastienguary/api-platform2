<?php

namespace App\DataFixtures;

use App\Entity\Dog;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class DogFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $dogs = [
            ['name' => 'Rex', 'breed' => 'German Shepherd', 'birth' => '2018-03-14'],
            ['name' => 'Bella', 'breed' => 'Labrador Retriever', 'birth' => '2020-07-22'],
            ['name' => 'Charlie', 'breed' => 'Beagle', 'birth' => '2019-11-05'],
            ['name' => 'Luna', 'breed' => 'Border Collie', 'birth' => '2021-01-30'],
            ['name' => 'Max', 'breed' => 'Golden Retriever', 'birth' => '2017-05-10'],
            ['name' => 'Milo', 'breed' => 'French Bulldog', 'birth' => '2022-02-18'],
            ['name' => 'Nala', 'breed' => 'Australian Shepherd', 'birth' => '2019-08-09'],
            ['name' => 'Rocky', 'breed' => 'Boxer', 'birth' => '2016-12-01'],
            ['name' => 'Ruby', 'breed' => 'Cocker Spaniel', 'birth' => '2020-10-17'],
            ['name' => 'Simba', 'breed' => 'Shiba Inu', 'birth' => '2021-06-25'],
        ];

        foreach ($dogs as $i => $data) {
            $dog = (new Dog())
                ->setName($data['name'])
                ->setBreed($data['breed'])
                ->setBirthDate(new \DateTimeImmutable($data['birth']));

            $manager->persist($dog);

            // Optional references if needed by other fixtures later
            $this->addReference('dog_'.($i+1), $dog);
        }

        $manager->flush();
    }
}
