<?php

namespace App\Entity;

#use ApiPlatform\Metadata\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use App\Entity\Owner;
use App\Entity\Pet;

##[ApiResource(mercure: true)]
#[ORM\Entity]
class OwnerPet
{
    #[ORM\Id]
    #[ORM\Column(name: 'id_owner_pet', type: 'integer')]
    #[ORM\GeneratedValue(strategy: 'SEQUENCE')]
    private ?int $id = null;

    public function getId(): ?int
    {
        return $this->id;
    }


    #[ORM\ManyToOne(targetEntity: Owner::class, inversedBy: 'ownerPets')]
    #[ORM\JoinColumn(name: 'id_owner', referencedColumnName: 'id_owner', nullable: false, onDelete: 'RESTRICT')]



    private Owner $owner;

    #[ORM\ManyToOne(targetEntity: Pet::class, inversedBy: 'ownerPets')]
    #[ORM\JoinColumn(name: 'id_pet', referencedColumnName: 'id_pet', nullable: false, onDelete: 'RESTRICT')]
    private Pet $pet;

    public function getOwner(): Owner
    {
        return $this->owner;
    }
    public function setOwner(Owner $owner): self
    {
        $this->owner = $owner;

        return $this;
    }
    public function getPet(): Pet
    {
        return $this->pet;
    }
    public function setPet(Pet $pet): self
    {
        $this->pet = $pet;

        return $this;
    }
}
