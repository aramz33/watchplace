<?php

namespace App\Entity;

use App\Repository\MemberRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MemberRepository::class)]
class Member
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\OneToMany(mappedBy: 'member', targetEntity: Remontoire::class, orphanRemoval: true)]
    private Collection $remontoires;

    public function __construct()
    {
        $this->remontoires = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * @return Collection<int, Remontoire>
     */
    public function getRemontoires(): Collection
    {
        return $this->remontoires;
    }

    public function addRemontoire(Remontoire $remontoire): static
    {
        if (!$this->remontoires->contains($remontoire)) {
            $this->remontoires->add($remontoire);
            $remontoire->setMember($this);
        }

        return $this;
    }

    public function removeRemontoire(Remontoire $remontoire): static
    {
        if ($this->remontoires->removeElement($remontoire)) {
            // set the owning side to null (unless already changed)
            if ($remontoire->getMember() === $this) {
                $remontoire->setMember(null);
            }
        }

        return $this;
    }
}
