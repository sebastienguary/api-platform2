<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

#[ApiResource(mercure: true)]



#[ORM\Entity]
class Species
{
    #[ORM\Id]
    #[ORM\Column(name: 'id_species', type: 'integer')]
    #[ORM\GeneratedValue(strategy: 'SEQUENCE')]
    private ?int $id = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Nom de l'espèce
     */
    #[ORM\Column]
    #[Assert\NotBlank]
    private string $name = '';

    /**
     * Animaux de cette espèce
     *
     * @var Collection<int, Pet>
     */
    #[ORM\OneToMany(mappedBy: 'specie', targetEntity: Pet::class, orphanRemoval: false)]
    private Collection $pets;

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
            $pet->setSpecie($this);
        }

        return $this;
    }

    public function removePet(Pet $pet): self
    {
        if ($this->pets->removeElement($pet)) {
            // set the owning side to null (unless already changed)
            if ($pet->getSpecie() === $this) {
                $pet->setSpecie(null);
            }
        }

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
