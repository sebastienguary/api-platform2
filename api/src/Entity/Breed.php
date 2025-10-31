<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Delete;

#[ApiResource(
    operations: [
        new GetCollection(security: 'is_granted("ROLE_USER")'),
        new Get(security: 'is_granted("ROLE_USER")'),
  
        new Post(security: 'is_granted("ROLE_USER")', processor: App\State\PetSetOwnerProcessor::class),
        new Patch(security: 'object.getOwner() == user or is_granted("ROLE_ADMIN")'),
        new Delete(security: 'object.getOwner() == user or is_granted("ROLE_ADMIN")'),
    ]
)]


#[ORM\Entity]
class Breed
{
    #[ORM\Id]
    #[ORM\Column(name: 'id_breed', type: 'integer')]
    #[ORM\GeneratedValue(strategy: 'SEQUENCE')]


    private ?int $id = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Nom de la race
     */
    #[ORM\Column]
    #[Assert\NotBlank]
    private string $name = '';

    /**
     * Animaux de cette race
     *
     * @var Collection<int, Pet>
     */
    #[ORM\OneToMany(mappedBy: 'breed', targetEntity: Pet::class, orphanRemoval: false)]
    private Collection $pets;


    /**
     * Espèce de l'animal
     */


    #[ORM\ManyToOne(targetEntity: Species::class, inversedBy: 'breeds')]
    #[ORM\JoinColumn(name: 'id_species', referencedColumnName: 'id_species', nullable: false, onDelete: 'RESTRICT')]
    private Species $species;

    public function __construct()
    {
        $this->pets = new ArrayCollection();

    }

    /**
     * @return Collection<int, Pet>
     */
    public function getPets(): Collection
    {
        return $this->pets;
    }

    public function addPet(Pet $pet): self
    {
        if (!$this->pets->contains($pet)) {
            $this->pets->add($pet);
            $pet->setBreed($this);
        }

        return $this;
    }

    public function removePet(Pet $pet): self
    {
        if ($this->pets->removeElement($pet)) {
            // set the owning side to null (unless already changed)
            if ($pet->getBreed() === $this) {
                $pet->setBreed(null);
            }
        }

        return $this;
    }

    public function getSpecies(): ?Species
    {
        return $this->species;
    }

    public function setSpecies(?Species $species): self
    {
        $this->species = $species;
        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }
}
