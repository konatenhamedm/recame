<?php

namespace App\Entity;

use App\Repository\MembreRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=MembreRepository::class)
 */
class Membre
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
    private $nom;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $prenoms;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $cellule;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $numero;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $codeParrainnage;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $quartier;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $sexe;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateNaissance;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $lieuNaissance;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $niveauEtude;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $naturePiece;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $numeroPiece;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $lieuVote;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $preocupation;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $numeroCarteElecteur;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $contacts;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateCreation;

    /**
     * @ORM\ManyToOne(targetEntity=Localite::class, inversedBy="membres")
     */
    private $region;

    /**
     * @ORM\ManyToOne(targetEntity=Profession::class, inversedBy="membres")
     */
    private $profession;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $photo;

    /**
     * @ORM\ManyToOne(targetEntity=Departement::class, inversedBy="membres")
     */
    private $departement;


    /**
     * @ORM\Column(type="integer")
     */
    private $active;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenoms(): ?string
    {
        return $this->prenoms;
    }

    public function setPrenoms(string $prenoms): self
    {
        $this->prenoms = $prenoms;

        return $this;
    }

    public function getCellule(): ?string
    {
        return $this->cellule;
    }

    public function setCellule(string $cellule): self
    {
        $this->cellule = $cellule;

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

    public function getCodeParrainnage(): ?string
    {
        return $this->codeParrainnage;
    }

    public function setCodeParrainnage(string $codeParrainnage): self
    {
        $this->codeParrainnage = $codeParrainnage;

        return $this;
    }

    public function getQuartier(): ?string
    {
        return $this->quartier;
    }

    public function setQuartier(string $quartier): self
    {
        $this->quartier = $quartier;

        return $this;
    }

    public function getSexe(): ?string
    {
        return $this->sexe;
    }

    public function setSexe(string $sexe): self
    {
        $this->sexe = $sexe;

        return $this;
    }

    public function getDateNaissance(): ?\DateTimeInterface
    {
        return $this->dateNaissance;
    }

    public function setDateNaissance(\DateTimeInterface $dateNaissance): self
    {
        $this->dateNaissance = $dateNaissance;

        return $this;
    }

    public function getLieuNaissance(): ?string
    {
        return $this->lieuNaissance;
    }

    public function setLieuNaissance(string $lieuNaissance): self
    {
        $this->lieuNaissance = $lieuNaissance;

        return $this;
    }

    public function getNiveauEtude(): ?string
    {
        return $this->niveauEtude;
    }

    public function setNiveauEtude(string $niveauEtude): self
    {
        $this->niveauEtude = $niveauEtude;

        return $this;
    }

    public function getNaturePiece(): ?string
    {
        return $this->naturePiece;
    }

    public function setNaturePiece(string $naturePiece): self
    {
        $this->naturePiece = $naturePiece;

        return $this;
    }

    public function getNumeroPiece(): ?string
    {
        return $this->numeroPiece;
    }

    public function setNumeroPiece(string $numeroPiece): self
    {
        $this->numeroPiece = $numeroPiece;

        return $this;
    }


    public function getLieuVote(): ?string
    {
        return $this->lieuVote;
    }

    public function setLieuVote(string $lieuVote): self
    {
        $this->lieuVote = $lieuVote;

        return $this;
    }

    public function getPreocupation(): ?string
    {
        return $this->preocupation;
    }

    public function setPreocupation(string $preocupation): self
    {
        $this->preocupation = $preocupation;

        return $this;
    }

    public function getNumeroCarteElecteur(): ?string
    {
        return $this->numeroCarteElecteur;
    }

    public function setNumeroCarteElecteur(string $numeroCarteElecteur): self
    {
        $this->numeroCarteElecteur = $numeroCarteElecteur;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getContacts(): ?string
    {
        return $this->contacts;
    }

    public function setContacts(string $contacts): self
    {
        $this->contacts = $contacts;

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

    public function getRegion(): ?Localite
    {
        return $this->region;
    }

    public function setRegion(?Localite $region): self
    {
        $this->region = $region;

        return $this;
    }

    public function getProfession(): ?Profession
    {
        return $this->profession;
    }

    public function setProfession(?Profession $profession): self
    {
        $this->profession = $profession;

        return $this;
    }

    public function getPhoto(): ?string
    {
        return $this->photo;
    }

    public function setPhoto(string $photo): self
    {
        $this->photo = $photo;

        return $this;
    }

    public function getDepartement(): ?Departement
    {
        return $this->departement;
    }

    public function setDepartement(?Departement $departement): self
    {
        $this->departement = $departement;

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
