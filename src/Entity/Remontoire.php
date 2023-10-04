<?php

namespace App\Entity;

use App\Repository\RemontoireRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RemontoireRepository::class)]
class Remontoire
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToMany(mappedBy: 'remontoire_id', targetEntity: Montre::class)]
    private Collection $montres;

    #[ORM\ManyToOne(inversedBy: 'remontoires')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Member $member = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $nom = null;


    public function __construct()
    {
        $this->montres = new ArrayCollection();
    }

    public function __toString(): string
    {
        return $this->getId();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): static
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return Collection<int, Montre>
     */
    public function getMontres(): Collection
    {
        return $this->montres;
    }

    public function addMontre(Montre $montre): static
    {
        if (!$this->montres->contains($montre)) {
            $this->montres->add($montre);
            $montre->setRemontoireId($this);
        }

        return $this;
    }

    public function removeMontre(Montre $montre): static
    {
        if ($this->montres->removeElement($montre)) {
            // set the owning side to null (unless already changed)
            if ($montre->getRemontoireId() === $this) {
                $montre->setRemontoireId(null);
            }
        }

        return $this;
    }

    public function getMember(): ?Member
    {
        return $this->member;
    }

    public function setMember(?Member $member): static
    {
        $this->member = $member;

        return $this;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(?string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }



}
