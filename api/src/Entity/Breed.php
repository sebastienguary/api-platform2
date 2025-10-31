<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

#[ApiResource(mercure: true)]



#[ORM\Entity]
class Breed
{
    #[ORM\Id]
    #[ORM\Column(type: 'integer')]
    #[ORM\GeneratedValue(strategy: 'SEQUENCE')]
    private ?int $id = null;

    /**
     * Nom de la race
     */
    #[ORM\Column]
    #[Assert\NotBlank]
    private string $name = '';

    /**
     * Chiens de cette race
     *
     * @var Collection<int, Dog>
     */
    #[ORM\OneToMany(mappedBy: 'breed', targetEntity: Dog::class, orphanRemoval: false)]
    private Collection $dogs;

    public function __construct()
    {
        $this->dogs = new ArrayCollection();
    }

    /**
     * @return Collection<int, Dog>
     */
    public function getDogs(): Collection
    {
        return $this->dogs;
    }

    public function addDog(Dog $dog): self
    {
        if (!$this->dogs->contains($dog)) {
            $this->dogs->add($dog);
            $dog->setBreed($this);
        }

        return $this;
    }

    public function removeDog(Dog $dog): self
    {
        if ($this->dogs->removeElement($dog)) {
            // set the owning side to null (unless already changed)
            if ($dog->getBreed() === $this) {
                $dog->setBreed(null);
            }
        }

        return $this;
    }

    public function getId(): ?int
    {
        return $this->id;
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
