<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Abonne
 *
 * @ORM\Table(name="Abonne", indexes={@ORM\Index(name="IDX_719E8EC620B77BF2", columns={"Code_Pays"})})
 * @ORM\Entity
 */
class Abonne
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
     * @ORM\Column(name="Nom_Abonne", type="string", length=50, nullable=false)
     */
    private $nomAbonne;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Login", type="string", length=10, nullable=true)
     */
    private $login;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Password", type="string", length=80, nullable=true)
     */
    private $password;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Adresse", type="string", length=50, nullable=true)
     */
    private $adresse;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Ville", type="string", length=50, nullable=true)
     */
    private $ville;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Code_Postal", type="string", length=50, nullable=true)
     */
    private $codePostal;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Email", type="string", length=0, nullable=true)
     */
    private $email;

    /**
     * @var string|null
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
     * @ORM\Column(name="Prenom_Abonne", type="string", length=40, nullable=true)
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


}
