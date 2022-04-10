<?php

namespace App\Entity;

use App\Repository\DepartementRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;


/**
 * @ORM\Entity(repositoryClass=DepartementRepository::class)
 */
class Departement
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;


    /**
     * @ORM\Column(type="string", length=255)
     */
    private $libDepartement;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $abregeDepartement;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $couleurDepartement;

    /**
     * @ORM\Column(type="integer")
     */
    private $etat;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateCreation;



    /**
     * @ORM\ManyToOne(targetEntity=CodeDepartement::class, inversedBy="departements")
     */
    private $codeDepartement;

    /**
     * @ORM\OneToMany(targetEntity=Membre::class, mappedBy="departement")
     */
    private $membres;

    /**
     * @ORM\ManyToOne(targetEntity=Localite::class, inversedBy="departements")
     */
    private $region;


    /**
     * @ORM\Column(type="integer")
     */
    private $active;

    public function __construct()
    {
        $this->membres = new ArrayCollection();

    }


    public function getId(): ?int
    {
        return $this->id;
    }


    public function getLibDepartement(): ?string
    {
        return $this->libDepartement;
    }

    public function setLibDepartement(string $libDepartement): self
    {
        $this->libDepartement = $libDepartement;

        return $this;
    }

    public function getAbregeDepartement(): ?string
    {
        return $this->abregeDepartement;
    }

    public function setAbregeDepartement(string $abregeDepartement): self
    {
        $this->abregeDepartement = $abregeDepartement;

        return $this;
    }

    public function getCouleurDepartement(): ?string
    {
        return $this->couleurDepartement;
    }

    public function setCouleurDepartement(string $couleurDepartement): self
    {
        $this->couleurDepartement = $couleurDepartement;

        return $this;
    }

    public function getEtat(): ?int
    {
        return $this->etat;
    }

    public function setEtat(int $etat): self
    {
        $this->etat = $etat;

        return $this;
    }

    public function getDateCreation(): ?\DateTimeInterface
    {
        return $this->dateCreation;
    }

    public function setDateCreation(\DateTimeInterface $dateCreation): self
    {
        $this->dateCreation = $dateCreation;

        return $this;
    }


    public function getCodeDepartement(): ?CodeDepartement
    {
        return $this->codeDepartement;
    }

    public function setCodeDepartement(?CodeDepartement $codeDepartement): self
    {
        $this->codeDepartement = $codeDepartement;

        return $this;
    }

    /**
     * @return Collection<int, Membre>
     */
    public function getMembres(): Collection
    {
        return $this->membres;
    }

    public function addMembre(Membre $membre): self
    {
        if (!$this->membres->contains($membre)) {
            $this->membres[] = $membre;
            $membre->setDepartement($this);
        }

        return $this;
    }

    public function removeMembre(Membre $membre): self
    {
        if ($this->membres->removeElement($membre)) {
            // set the owning side to null (unless already changed)
            if ($membre->getDepartement() === $this) {
                $membre->setDepartement(null);
            }
        }

        return $this;
    }

    public function getRegion(): ?Localite
    {
        return $this->region;
    }

    public function setRegion(?Localite $region): self
    {
        $this->region = $region;

        return $this;
    }


    public function getActive(): ?int
    {
        return $this->active;
    }

    public function setActive(int $active): self
    {
        $this->active = $active;

        return $this;
    }



   





}
