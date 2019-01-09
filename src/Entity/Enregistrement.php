<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Enregistrement
 *
 * @ORM\Table(name="Enregistrement")
 * @ORM\Entity
 */
class Enregistrement
{
    /**
     * @var int
     *
     * @ORM\Column(name="Code_Morceau", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $codeMorceau;

    /**
     * @var string
     *
     * @ORM\Column(name="Titre", type="string", length=0, nullable=false)
     */
    private $titre;

    /**
     * @var int
     *
     * @ORM\Column(name="Code_Composition", type="integer", nullable=false)
     */
    private $codeComposition;

    /**
     * @var string
     *
     * @ORM\Column(name="Nom_de_Fichier", type="string", length=0, nullable=false)
     */
    private $nomDeFichier;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Duree", type="string", length=10, nullable=true, options={"fixed"=true})
     */
    private $duree;

    /**
     * @var int|null
     *
     * @ORM\Column(name="Duree_Seconde", type="integer", nullable=true)
     */
    private $dureeSeconde;

    /**
     * @var int|null
     *
     * @ORM\Column(name="Prix", type="integer", nullable=true)
     */
    private $prix;

    /**
     * @var binary|null
     *
     * @ORM\Column(name="Extrait", type="binary", nullable=true)
     */
    private $extrait;


}
