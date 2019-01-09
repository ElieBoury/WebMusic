<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Achat
 *
 * @ORM\Table(name="Achat", indexes={@ORM\Index(name="IDX_E768AB52A1866919", columns={"Code_Enregistrement"}), @ORM\Index(name="IDX_E768AB52888459B3", columns={"Code_Abonne"})})
 * @ORM\Entity
 */
class Achat
{
    /**
     * @var int
     *
     * @ORM\Column(name="Code_Achat", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $codeAchat;

    /**
     * @var bool|null
     *
     * @ORM\Column(name="Achat_Confirme", type="boolean", nullable=true)
     */
    private $achatConfirme;

    /**
     * @var \Enregistrement
     *
     * @ORM\ManyToOne(targetEntity="Enregistrement")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Code_Enregistrement", referencedColumnName="Code_Morceau")
     * })
     */
    private $codeEnregistrement;

    /**
     * @var \Abonne
     *
     * @ORM\ManyToOne(targetEntity="Abonne")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Code_Abonne", referencedColumnName="Code_Abonne")
     * })
     */
    private $codeAbonne;


}
