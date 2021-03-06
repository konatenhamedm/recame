<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 */
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     * @Assert\Blank(message="Le montant est oblogatoire")
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $prenoms;

    /**
     * @ORM\Column(type="integer")
     */
    private $active;

    /**
     * @ORM\OneToMany(targetEntity=CourierArrive::class, mappedBy="user")
     */
    private $courierArrives;

    /**
     * @ORM\OneToMany(targetEntity=CourierArrive::class, mappedBy="exp")
     */
    private $exp;

    public function __construct()
    {
        $this->courierArrives = new ArrayCollection();
        $this->exp = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @deprecated since Symfony 5.3, use getUserIdentifier instead
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
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

    public function getActive(): ?int
    {
        return $this->active;
    }

    public function setActive(int $active): self
    {
        $this->active = $active;

        return $this;
    }

    /**
     * @return Collection<int, CourierArrive>
     */
    public function getCourierArrives(): Collection
    {
        return $this->courierArrives;
    }

    public function addCourierArrife(CourierArrive $courierArrife): self
    {
        if (!$this->courierArrives->contains($courierArrife)) {
            $this->courierArrives[] = $courierArrife;
            $courierArrife->setUser($this);
        }

        return $this;
    }

    public function removeCourierArrife(CourierArrive $courierArrife): self
    {
        if ($this->courierArrives->removeElement($courierArrife)) {
            // set the owning side to null (unless already changed)
            if ($courierArrife->getUser() === $this) {
                $courierArrife->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, CourierArrive>
     */
    public function getExp(): Collection
    {
        return $this->exp;
    }

    public function addExp(CourierArrive $exp): self
    {
        if (!$this->exp->contains($exp)) {
            $this->exp[] = $exp;
            $exp->setExp($this);
        }

        return $this;
    }

    public function removeExp(CourierArrive $exp): self
    {
        if ($this->exp->removeElement($exp)) {
            // set the owning side to null (unless already changed)
            if ($exp->getExp() === $this) {
                $exp->setExp(null);
            }
        }

        return $this;
    }
}
