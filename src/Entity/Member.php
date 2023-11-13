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

    #[ORM\OneToMany(mappedBy: 'creator', targetEntity: Vitrine::class, orphanRemoval: true)]
    private Collection $vitrines;

    #[ORM\OneToOne(mappedBy: 'member', cascade: ['persist', 'remove'])]
    private ?User $user = null;

    public function __toString(): string
    {
        return $this->getNom();
    }

    public function __construct()
    {
        $this->remontoires = new ArrayCollection();
        $this->vitrines = new ArrayCollection();
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

    /**
     * @return Collection<int, Vitrine>
     */
    public function getVitrines(): Collection
    {
        return $this->vitrines;
    }

    public function addVitrine(Vitrine $vitrine): static
    {
        if (!$this->vitrines->contains($vitrine)) {
            $this->vitrines->add($vitrine);
            $vitrine->setCreator($this);
        }

        return $this;
    }

    public function removeVitrine(Vitrine $vitrine): static
    {
        if ($this->vitrines->removeElement($vitrine)) {
            // set the owning side to null (unless already changed)
            if ($vitrine->getCreator() === $this) {
                $vitrine->setCreator(null);
            }
        }

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(User $user): static
    {
        // set the owning side of the relation if necessary
        if ($user->getMember() !== $this) {
            $user->setMember($this);
        }

        $this->user = $user;

        return $this;
    }
}
