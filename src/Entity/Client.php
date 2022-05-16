<?php

namespace App\Entity;

use App\Repository\ClientRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=ClientRepository::class)
 */
class Client
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
    private $prenom;

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
    private $profession;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $domicile;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $pere;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $mere;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $etatBienVendu;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $adresse;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $telDomicile;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $telBureau;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $telPortable;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nationalite;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $situation;

    /**
     * @ORM\Column(type="string", length=255,nullable=true)
     */
    private $nomConjoint;

    /**
     * @ORM\Column(type="string", length=255,nullable=true)
     */
    private $prenomConjoint;

    /**
     * @ORM\Column(type="datetime",nullable=true)
     */
    private $dateNaissanceConjoint;

    /**
     * @ORM\Column(type="string", length=255,nullable=true)
     */
    private $lieuNaissanceConjoint;

    /**
     * @ORM\Column(type="string", length=255,nullable=true)
     */
    private $professionConjoint;

    /**
     * @ORM\Column(type="string", length=255,nullable=true)
     */
    private $pereConjoint;

    /**
     * @ORM\Column(type="string", length=255,nullable=true)
     */
    private $mereConjoint;

    /**
     * @ORM\Column(type="string", length=255,nullable=true)
     */
    private $adresseConjoint;

    /**
     * @ORM\Column(type="string", length=255,nullable=true)
     */
    private $nationaliteConjoint;

    /**
     * @ORM\Column(type="string", length=255,nullable=true)
     */
    private $regimeMatrimonialConjoint;

    /**
     * @ORM\Column(type="datetime",nullable=true)
     */
    private $dateMariage;

    /**
     * @ORM\Column(type="string", length=255,nullable=true)
     */
    private $lieuMariageConjoint;

    /**
     * @ORM\Column(type="string", length=255,nullable=true)
     */
    private $contratMariageConjoint;

    /**
     * @ORM\Column(type="string", length=255,nullable=true)
     */
    private $affirmatif;

    /**
     * @ORM\Column(type="string", length=255,nullable=true)
     */
    private $precedentMariage;

    /**
     * @ORM\Column(type="string", length=255,nullable=true)
     */
    private $nomPrenomEpoux;

    /**
     * @ORM\Column(type="datetime",nullable=true)
     */
    private $datePrecedent;

    /**
     * @ORM\Column(type="string", length=255,nullable=true)
     */
    private $regime;

    /**
     * @ORM\Column(type="string", length=255,nullable=true)
     */
    private $numeroJugement;

    /**
     * @ORM\Column(type="datetime",nullable=true)
     */
    private $dateJugement;

    /**
     * @ORM\Column(type="string", length=255,nullable=true)
     */
    private $jugementRendu;

    /**
     * @ORM\Column(type="datetime",nullable=true)
     */
    private $dateDeces;

    /**
     * @ORM\Column(type="string", length=255,nullable=true)
     */
    private $lieuDeces;

    /**
     * @ORM\Column(type="datetime",nullable=true)
     */
    private $faitLe;

    /**
     * @ORM\OneToMany(targetEntity=Calendar::class, mappedBy="client")
     */
    private $calendars;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $active;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $photo;

    /**
     * @ORM\Column(type="string", length=255,nullable=true)
     */
    private $emailConjoint;

    /**
     * @ORM\Column(type="string", length=255,nullable=true)
     */
    private $telConjoint;

    /**
     * @ORM\Column(type="string", length=255,nullable=true)
     */
    private $portableConjoint;

    /**
     * @ORM\OneToMany(targetEntity=CourierArrive::class, mappedBy="expediteur")
     */
    private $expediteur;

    /**
     * @ORM\OneToMany(targetEntity=CourierArrive::class, mappedBy="recep")
     */
    private $recep;

    /**
     * @ORM\OneToMany(targetEntity=TypeActe::class, mappedBy="vendeur")
     */
    private $vendeur;

    /**
     * @ORM\OneToMany(targetEntity=TypeActe::class, mappedBy="acheteur")
     */
    private $acheteur;

    public function __construct()
    {
        $this->calendars = new ArrayCollection();
        $this->expediteur = new ArrayCollection();
        $this->recep = new ArrayCollection();
        $this->vendeur = new ArrayCollection();
        $this->acheteur = new ArrayCollection();
    }

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

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

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

    public function getProfession(): ?string
    {
        return $this->profession;
    }

    public function setProfession(string $profession): self
    {
        $this->profession = $profession;

        return $this;
    }

    public function getDomicile(): ?string
    {
        return $this->domicile;
    }

    public function setDomicile(string $domicile): self
    {
        $this->domicile = $domicile;

        return $this;
    }

    public function getPere(): ?string
    {
        return $this->pere;
    }

    public function setPere(string $pere): self
    {
        $this->pere = $pere;

        return $this;
    }

    public function getMere(): ?string
    {
        return $this->mere;
    }

    public function setMere(string $mere): self
    {
        $this->mere = $mere;

        return $this;
    }

    public function getEtatBienVendu(): ?string
    {
        return $this->etatBienVendu;
    }

    public function setEtatBienVendu(string $etatBienVendu): self
    {
        $this->etatBienVendu = $etatBienVendu;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getTelDomicile(): ?string
    {
        return $this->telDomicile;
    }

    public function setTelDomicile(string $telDomicile): self
    {
        $this->telDomicile = $telDomicile;

        return $this;
    }

    public function getTelBureau(): ?string
    {
        return $this->telBureau;
    }

    public function setTelBureau(string $telBureau): self
    {
        $this->telBureau = $telBureau;

        return $this;
    }

    public function getTelPortable(): ?string
    {
        return $this->telPortable;
    }

    public function setTelPortable(string $telPortable): self
    {
        $this->telPortable = $telPortable;

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

    public function getNationalite(): ?string
    {
        return $this->nationalite;
    }

    public function setNationalite(string $nationalite): self
    {
        $this->nationalite = $nationalite;

        return $this;
    }

    public function getSituation(): ?string
    {
        return $this->situation;
    }

    public function setSituation(string $situation): self
    {
        $this->situation = $situation;

        return $this;
    }

    public function getNomConjoint(): ?string
    {
        return $this->nomConjoint;
    }

    public function setNomConjoint(string $nomConjoint): self
    {
        $this->nomConjoint = $nomConjoint;

        return $this;
    }

    public function getPrenomConjoint(): ?string
    {
        return $this->prenomConjoint;
    }

    public function setPrenomConjoint(string $prenomConjoint): self
    {
        $this->prenomConjoint = $prenomConjoint;

        return $this;
    }

    public function getDateNaissanceConjoint(): ?\DateTimeInterface
    {
        return $this->dateNaissanceConjoint;
    }

    public function setDateNaissanceConjoint(\DateTimeInterface $dateNaissanceConjoint): self
    {
        $this->dateNaissanceConjoint = $dateNaissanceConjoint;

        return $this;
    }

    public function getLieuNaissanceConjoint(): ?string
    {
        return $this->lieuNaissanceConjoint;
    }

    public function setLieuNaissanceConjoint(string $lieuNaissanceConjoint): self
    {
        $this->lieuNaissanceConjoint = $lieuNaissanceConjoint;

        return $this;
    }

    public function getProfessionConjoint(): ?string
    {
        return $this->professionConjoint;
    }

    public function setProfessionConjoint(string $professionConjoint): self
    {
        $this->professionConjoint = $professionConjoint;

        return $this;
    }

    public function getPereConjoint(): ?string
    {
        return $this->pereConjoint;
    }

    public function setPereConjoint(string $pereConjoint): self
    {
        $this->pereConjoint = $pereConjoint;

        return $this;
    }

    public function getMereConjoint(): ?string
    {
        return $this->mereConjoint;
    }

    public function setMereConjoint(string $mereConjoint): self
    {
        $this->mereConjoint = $mereConjoint;

        return $this;
    }

    public function getAdresseConjoint(): ?string
    {
        return $this->adresseConjoint;
    }

    public function setAdresseConjoint(string $adresseConjoint): self
    {
        $this->adresseConjoint = $adresseConjoint;

        return $this;
    }

    public function getNationaliteConjoint(): ?string
    {
        return $this->nationaliteConjoint;
    }

    public function setNationaliteConjoint(string $nationaliteConjoint): self
    {
        $this->nationaliteConjoint = $nationaliteConjoint;

        return $this;
    }

    public function getRegimeMatrimonialConjoint(): ?string
    {
        return $this->regimeMatrimonialConjoint;
    }

    public function setRegimeMatrimonialConjoint(string $regimeMatrimonialConjoint): self
    {
        $this->regimeMatrimonialConjoint = $regimeMatrimonialConjoint;

        return $this;
    }

    public function getDateMariage(): ?\DateTimeInterface
    {
        return $this->dateMariage;
    }

    public function setDateMariage(\DateTimeInterface $dateMariage): self
    {
        $this->dateMariage = $dateMariage;

        return $this;
    }

    public function getLieuMariageConjoint(): ?string
    {
        return $this->lieuMariageConjoint;
    }

    public function setLieuMariageConjoint(string $lieuMariageConjoint): self
    {
        $this->lieuMariageConjoint = $lieuMariageConjoint;

        return $this;
    }

    public function getContratMariageConjoint(): ?string
    {
        return $this->contratMariageConjoint;
    }

    public function setContratMariageConjoint(string $contratMariageConjoint): self
    {
        $this->contratMariageConjoint = $contratMariageConjoint;

        return $this;
    }

    public function getAffirmatif(): ?string
    {
        return $this->affirmatif;
    }

    public function setAffirmatif(string $affirmatif): self
    {
        $this->affirmatif = $affirmatif;

        return $this;
    }

    public function getPrecedentMariage(): ?string
    {
        return $this->precedentMariage;
    }

    public function setPrecedentMariage(string $precedentMariage): self
    {
        $this->precedentMariage = $precedentMariage;

        return $this;
    }

    public function getNomPrenomEpoux(): ?string
    {
        return $this->nomPrenomEpoux;
    }

    public function setNomPrenomEpoux(string $nomPrenomEpoux): self
    {
        $this->nomPrenomEpoux = $nomPrenomEpoux;

        return $this;
    }

    public function getDatePrecedent(): ?\DateTimeInterface
    {
        return $this->datePrecedent;
    }

    public function setDatePrecedent(\DateTimeInterface $datePrecedent): self
    {
        $this->datePrecedent = $datePrecedent;

        return $this;
    }

    public function getRegime(): ?string
    {
        return $this->regime;
    }

    public function setRegime(string $regime): self
    {
        $this->regime = $regime;

        return $this;
    }

    public function getNumeroJugement(): ?string
    {
        return $this->numeroJugement;
    }

    public function setNumeroJugement(string $numeroJugement): self
    {
        $this->numeroJugement = $numeroJugement;

        return $this;
    }

    public function getDateJugement(): ?\DateTimeInterface
    {
        return $this->dateJugement;
    }

    public function setDateJugement(\DateTimeInterface $dateJugement): self
    {
        $this->dateJugement = $dateJugement;

        return $this;
    }

    public function getJugementRendu(): ?string
    {
        return $this->jugementRendu;
    }

    public function setJugementRendu(string $jugementRendu): self
    {
        $this->jugementRendu = $jugementRendu;

        return $this;
    }

    public function getDateDeces(): ?\DateTimeInterface
    {
        return $this->dateDeces;
    }

    public function setDateDeces(\DateTimeInterface $dateDeces): self
    {
        $this->dateDeces = $dateDeces;

        return $this;
    }

    public function getLieuDeces(): ?string
    {
        return $this->lieuDeces;
    }

    public function setLieuDeces(string $lieuDeces): self
    {
        $this->lieuDeces = $lieuDeces;

        return $this;
    }

    public function getFaitLe(): ?\DateTimeInterface
    {
        return $this->faitLe;
    }

    public function setFaitLe(\DateTimeInterface $faitLe): self
    {
        $this->faitLe = $faitLe;

        return $this;
    }

    /**
     * @return Collection<int, Calendar>
     */
    public function getCalendars(): Collection
    {
        return $this->calendars;
    }

    public function addCalendar(Calendar $calendar): self
    {
        if (!$this->calendars->contains($calendar)) {
            $this->calendars[] = $calendar;
            $calendar->setClient($this);
        }

        return $this;
    }

    public function removeCalendar(Calendar $calendar): self
    {
        if ($this->calendars->removeElement($calendar)) {
            // set the owning side to null (unless already changed)
            if ($calendar->getClient() === $this) {
                $calendar->setClient(null);
            }
        }

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

    public function getPhoto(): ?string
    {
        return $this->photo;
    }

    public function setPhoto(string $photo): self
    {
        $this->photo = $photo;

        return $this;
    }

    public function getEmailConjoint(): ?string
    {
        return $this->emailConjoint;
    }

    public function setEmailConjoint(string $emailConjoint): self
    {
        $this->emailConjoint = $emailConjoint;

        return $this;
    }

    public function getTelConjoint(): ?string
    {
        return $this->telConjoint;
    }

    public function setTelConjoint(string $telConjoint): self
    {
        $this->telConjoint = $telConjoint;

        return $this;
    }

    public function getPortableConjoint(): ?string
    {
        return $this->portableConjoint;
    }

    public function setPortableConjoint(string $portableConjoint): self
    {
        $this->portableConjoint = $portableConjoint;

        return $this;
    }

    /**
     * @return Collection<int, CourierArrive>
     */
    public function getExpediteur(): Collection
    {
        return $this->expediteur;
    }

    public function addExpediteur(CourierArrive $expediteur): self
    {
        if (!$this->expediteur->contains($expediteur)) {
            $this->expediteur[] = $expediteur;
            $expediteur->setExpediteur($this);
        }

        return $this;
    }

    public function removeExpediteur(CourierArrive $expediteur): self
    {
        if ($this->expediteur->removeElement($expediteur)) {
            // set the owning side to null (unless already changed)
            if ($expediteur->getExpediteur() === $this) {
                $expediteur->setExpediteur(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, CourierArrive>
     */
    public function getRecep(): Collection
    {
        return $this->recep;
    }

    public function addRecep(CourierArrive $recep): self
    {
        if (!$this->recep->contains($recep)) {
            $this->recep[] = $recep;
            $recep->setRecep($this);
        }

        return $this;
    }

    public function removeRecep(CourierArrive $recep): self
    {
        if ($this->recep->removeElement($recep)) {
            // set the owning side to null (unless already changed)
            if ($recep->getRecep() === $this) {
                $recep->setRecep(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, TypeActe>
     */
    public function getVendeur(): Collection
    {
        return $this->vendeur;
    }

    public function addVendeur(TypeActe $vendeur): self
    {
        if (!$this->vendeur->contains($vendeur)) {
            $this->vendeur[] = $vendeur;
            $vendeur->setVendeur($this);
        }

        return $this;
    }

    public function removeVendeur(TypeActe $vendeur): self
    {
        if ($this->vendeur->removeElement($vendeur)) {
            // set the owning side to null (unless already changed)
            if ($vendeur->getVendeur() === $this) {
                $vendeur->setVendeur(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, TypeActe>
     */
    public function getAcheteur(): Collection
    {
        return $this->acheteur;
    }

    public function addAcheteur(TypeActe $acheteur): self
    {
        if (!$this->acheteur->contains($acheteur)) {
            $this->acheteur[] = $acheteur;
            $acheteur->setAcheteur($this);
        }

        return $this;
    }

    public function removeAcheteur(TypeActe $acheteur): self
    {
        if ($this->acheteur->removeElement($acheteur)) {
            // set the owning side to null (unless already changed)
            if ($acheteur->getAcheteur() === $this) {
                $acheteur->setAcheteur(null);
            }
        }

        return $this;
    }
}
