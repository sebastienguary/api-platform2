<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ApiResource(mercure: true)]



#[ORM\Entity]
class Dog
{
    #[ORM\Id]
    #[ORM\Column(type: 'integer')]
    #[ORM\GeneratedValue(strategy: 'SEQUENCE')]
    private ?int $id = null;

    /**
     * Nom du chien
     */
    #[ORM\Column]
    #[Assert\NotBlank]
    private string $name = '';

    /**
     * Race du chien
     */
    #[ORM\ManyToOne(targetEntity: Breed::class, inversedBy: 'dogs')]
    #[ORM\JoinColumn(nullable: false)]
    #[Assert\NotNull]
    private ?Breed $breed = null;

    /**
     * Date de naissance du chien
     */
    #[ORM\Column(type: 'date_immutable')]
    #[Assert\NotNull]
    #[Assert\LessThanOrEqual('today')]
    private ?\DateTimeImmutable $birthDate = null;

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

    public function getBreed(): ?Breed
    {
        return $this->breed;
    }

    public function setBreed(?Breed $breed): self
    {
        $this->breed = $breed;
        return $this;
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
