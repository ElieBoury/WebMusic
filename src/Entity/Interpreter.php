<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Interpreter
 *
 * @ORM\Table(name="Interpreter", indexes={@ORM\Index(name="IDX_36AEA960D990D4F0", columns={"Code_Morceau"}), @ORM\Index(name="IDX_36AEA960E694D5AB", columns={"Code_Musicien"}), @ORM\Index(name="IDX_36AEA960D389A975", columns={"Code_Instrument"})})
 * @ORM\Entity
 */
class Interpreter
{
    /**
     * @var int
     *
     * @ORM\Column(name="Code_Interpreter", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $codeInterpreter;

    /**
     * @var \Enregistrement
     *
     * @ORM\ManyToOne(targetEntity="Enregistrement")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Code_Morceau", referencedColumnName="Code_Morceau")
     * })
     */
    private $codeMorceau;

    /**
     * @var \Musicien
     *
     * @ORM\ManyToOne(targetEntity="Musicien")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Code_Musicien", referencedColumnName="Code_Musicien")
     * })
     */
    private $codeMusicien;

    /**
     * @var \Instrument
     *
     * @ORM\ManyToOne(targetEntity="Instrument")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Code_Instrument", referencedColumnName="Code_Instrument")
     * })
     */
    private $codeInstrument;


}
