<?php

namespace App\Command\Generate\Pet;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Breed;
use App\Entity\Pet;

#[AsCommand(
    name: 'app:generate:pet:random',
    description: 'Add a short description for your command',
)]
class GeneratePetRandomCommand extends Command
{
    public function __construct(private ManagerRegistry $doctrine)
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addArgument('arg1', InputArgument::OPTIONAL, 'Argument description')
            ->addOption('option1', null, InputOption::VALUE_NONE, 'Option description')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $manager = $this->doctrine->getManager();

        $io = new SymfonyStyle($input, $output);
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
            $io->writeln("Creating pet: $name");


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

        }



        $manager->flush();


        return Command::SUCCESS;
    }
}
