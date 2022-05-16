<?php

namespace App\Entity;

use App\Repository\ActeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ActeRepository::class)
 */
class Acte
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $date;

    /**
     * @ORM\ManyToOne(targetEntity=Client::class, inversedBy="vendeur")
     */
    private $vendeur;

    /**
     * @ORM\ManyToOne(targetEntity=Client::class, inversedBy="acheteur")
     */
    private $acheteur;



    /**
     * @ORM\Column(type="string", length=255)
     */
    private $objet;

    /**
     * @ORM\Column(type="float")
     */
    private $montant;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $active;


    /**
     * @ORM\Column(type="string", length=255)
     */
    private $numero;

    /**
     * @ORM\OneToMany(targetEntity=FichierActe::class, mappedBy="acte",cascade={"persist"})
     */
    private $fichiers;

    /**
     * @ORM\ManyToOne(targetEntity=TypeActe::class, inversedBy="actes")
     */
    private $type;

    public function __construct()
    {
        $this->fichiers = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }
    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(?\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getVendeur(): ?Client
    {
        return $this->vendeur;
    }

    public function setVendeur(?Client $vendeur): self
    {
        $this->vendeur = $vendeur;

        return $this;
    }

    public function getAcheteur(): ?Client
    {
        return $this->acheteur;
    }

    public function setAcheteur(?Client $acheteur): self
    {
        $this->acheteur = $acheteur;

        return $this;
    }

    public function getObjet(): ?string
    {
        return $this->objet;
    }

    public function setObjet(string $objet): self
    {
        $this->objet = $objet;

        return $this;
    }

    public function getMontant(): ?float
    {
        return $this->montant;
    }

    public function setMontant(float $montant): self
    {
        $this->montant = $montant;

        return $this;
    }

    public function getActive(): ?string
    {
        return $this->active;
    }

    public function setActive(string $active): self
    {
        $this->active = $active;

        return $this;
    }

    public function getNumero(): ?string
    {
        return $this->numero;
    }

    public function setNumero(string $numero): self
    {
        $this->numero = $numero;

        return $this;
    }

    /**
     * @return Collection<int, FichierActe>
     */
    public function getFichiers(): Collection
    {
        return $this->fichiers;
    }

    public function addFichier(FichierActe $fichier): self
    {
        if (!$this->fichiers->contains($fichier)) {
            $this->fichiers[] = $fichier;
            $fichier->setActe($this);
        }

        return $this;
    }

    public function removeFichier(FichierActe $fichier): self
    {
        if ($this->fichiers->removeElement($fichier)) {
            // set the owning side to null (unless already changed)
            if ($fichier->getActe() === $this) {
                $fichier->setActe(null);
            }
        }

        return $this;
    }

    public function getType(): ?TypeActe
    {
        return $this->type;
    }

    public function setType(?TypeActe $type): self
    {
        $this->type = $type;

        return $this;
    }


}
