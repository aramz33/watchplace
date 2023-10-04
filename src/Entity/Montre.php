<?php

namespace App\Entity;

use App\Repository\MontreRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MontreRepository::class)]
class Montre
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $brand = null;

    #[ORM\ManyToOne(targetEntity: Remontoire::class, inversedBy: "montres")]
    #[ORM\JoinColumn(nullable: false)]
    private ?Remontoire $remontoire_id = null;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function __toString(): string
    {
        return $this->getBrand();
    }


    public function getBrand(): ?string
    {
        return $this->brand;
    }

    public function setBrand(string $brand): static
    {
        $this->brand = $brand;

        return $this;
    }

    public function getRemontoireId(): ?Remontoire
    {
        return $this->remontoire_id;
    }

    public function setRemontoireId(?Remontoire $remontoire_id): static
    {
        $this->remontoire_id = $remontoire_id;

        return $this;
    }





}