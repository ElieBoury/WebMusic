<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Abonne
 *
 * @ORM\Table(name="Abonne", indexes={@ORM\Index(name="IDX_719E8EC620B77BF2", columns={"Code_Pays"})})
 * @ORM\Entity
 * @UniqueEntity(
 *  fields={"email"},
 *  message="Email déjà existant."
 * )
 */
class Abonne implements UserInterface
{
    /**     
     * @var int
     *
     * @ORM\Column(name="Code_Abonne", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $codeAbonne;

    /**
     * @var string
     *
     * @ORM\Column(name="Nom_Abonne", type="string", length=100, nullable=false)
     * @Assert\Length(max="50", maxMessage="Votre nom doit comporter moins de 50 caractères.")
     */
    private $nomAbonne;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Login", type="string", length=50, nullable=false)
     * @Assert\Length(max="50", maxMessage="Votre identifiant doit comporter moins de 50 caractères.")
     */
    private $login;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Password", type="string", length=30, nullable=false)
     * @Assert\Length(min="8", minMessage="Votre mot de passe doit comporter 8 caractères au minimum.",
     *                 max="30", maxMessage="Votre mot de passe doit comporter moins de 30 caractères.")
     */
    private $password;

    /**
     * @var string|null
     * 
     * @Assert\EqualTo(propertyPath="password", message="Veuillez insérer des mots de passe identiques.")
     */
    private $confirm_password;

    /**
     * @var string|
     *
     * @ORM\Column(name="Adresse", type="string", length=200, nullable=true)
     * @Assert\Length(max="200", maxMessage="Votre adresse doit comporter moins de 200 caractères.")
     */
    private $adresse;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Ville", type="string", length=100, nullable=true)
     * @Assert\Length(max="200", maxMessage="Votre ville doit comporter moins de 100 caractères.")
     */
    private $ville;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Code_Postal", type="string", length=50, nullable=true)
     * @Assert\Length(min="5", max="5", maxMessage="Le code postal doit comporter 5 caractères.")
     */
    private $codePostal;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Email", type="string", length=100, nullable=false)
     * @Assert\Email()
     */
    private $email;

    /**
     * @var string|null
     * 
     *
     * @ORM\Column(name="UserId", type="string", length=128, nullable=true)
     */
    private $userid;

    /**
     * @var int|null
     *
     * @ORM\Column(name="Credit", type="integer", nullable=true)
     */
    private $credit;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Prenom_Abonne", type="string", length=100, nullable=false)
     * @Assert\Length(max="50", maxMessage="Votre prénom doit comporter moins de 50 caractères.")
     */
    private $prenomAbonne;

    /**
     * @var \Pays
     *
     * @ORM\ManyToOne(targetEntity="Pays")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Code_Pays", referencedColumnName="Code_Pays")
     * })
     */
    private $codePays;

    public function getCodeAbonne(): ?int
    {
        return $this->codeAbonne;
    }

    public function getNomAbonne(): ?string
    {
        return $this->nomAbonne;
    }

    public function setNomAbonne(string $nomAbonne): self
    {
        $this->nomAbonne = $nomAbonne;

        return $this;
    }

    public function getLogin(): ?string
    {
        return $this->login;
    }

    public function setLogin(?string $login): self
    {
        $this->login = $login;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(?string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getConfirmPassword(): ?string
    {
        return $this->confirm_password;
    }

    public function setConfirmPassword(?string $confirm_password): self
    {
        $this->confirm_password = $confirm_password;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(?string $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getVille(): ?string
    {
        return $this->ville;
    }

    public function setVille(?string $ville): self
    {
        $this->ville = $ville;

        return $this;
    }

    public function getCodePostal(): ?string
    {
        return $this->codePostal;
    }

    public function setCodePostal(?string $codePostal): self
    {
        $this->codePostal = $codePostal;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getUserid(): ?string
    {
        return $this->userid;
    }

    public function setUserid(?string $userid): self
    {
        $this->userid = $userid;

        return $this;
    }

    public function getCredit(): ?int
    {
        return $this->credit;
    }

    public function setCredit(?int $credit): self
    {
        $this->credit = $credit;

        return $this;
    }

    public function getPrenomAbonne(): ?string
    {
        return $this->prenomAbonne;
    }

    public function setPrenomAbonne(?string $prenomAbonne): self
    {
        $this->prenomAbonne = $prenomAbonne;

        return $this;
    }

    public function getCodePays(): ?Pays
    {
        return $this->codePays;
    }

    public function setCodePays(?Pays $codePays): self
    {
        $this->codePays = $codePays;

        return $this;
    }

    public function eraseCredentials()
    {
        
    }

    public function getSalt()
    {
        
    }

    public function getRoles()
    {
        return ['ROLES_USER'];
    }

    public function getUsername()
    {
        
    }

}
