<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;




#[ApiResource(mercure: true)]
#[ApiFilter(SearchFilter::class, properties: [
    'name' => 'exact',
    'species.name' => 'exact'
])]
#[ORM\Entity]
class Pet
{
    #[ORM\Id]
    #[ORM\Column(name: 'id_pet', type: 'integer')]
    #[ORM\GeneratedValue(strategy: 'SEQUENCE')]
    private ?int $id = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Nom du chien
     */
    #[ORM\Column]
    #[Assert\NotBlank]
    private string $name = '';

    /**
     * Race de l'animal
     */

    #[ORM\ManyToOne(targetEntity: Breed::class, inversedBy: 'breeds')]
    #[ORM\JoinColumn(name: 'id_breed', referencedColumnName: 'id_breed', nullable: false, onDelete: 'RESTRICT')]
    private Breed $breed;

    /**
     * Espèce de l'animal
     */


    #[ORM\ManyToOne(targetEntity: Species::class, inversedBy: 'breeds')]
    #[ORM\JoinColumn(name: 'id_species', referencedColumnName: 'id_species', nullable: false, onDelete: 'RESTRICT')]
    private Species $species;


    /**
     * Date de naissance du chien
     */
    #[ORM\Column(type: 'date_immutable')]
    #[Assert\NotNull]
    #[Assert\LessThanOrEqual('today')]
    private ?\DateTimeImmutable $birthDate = null;


    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function getBreed(): ?Breed
    {
        return $this->breed;
    }

    public function setBreed(?Breed $breed): self
    {
        $this->breed = $breed;
        return $this;
    }

   public function setSpecies(?Species $species): self
    {
        $this->species = $species;
        return $this;
    }

    public function getSpecies(): ?Species
    {
        return $this->species;
    }

    public function getBirthDate(): ?\DateTimeImmutable
    {
        return $this->birthDate;
    }

    public function setBirthDate(?\DateTimeImmutable $birthDate): self
    {
        $this->birthDate = $birthDate;
        return $this;
    }


}
