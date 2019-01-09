<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Instrumentation
 *
 * @ORM\Table(name="Instrumentation", indexes={@ORM\Index(name="IDX_8B3BA89ECB48FCBD", columns={"Code_Oeuvre"}), @ORM\Index(name="IDX_8B3BA89ED389A975", columns={"Code_Instrument"})})
 * @ORM\Entity
 */
class Instrumentation
{
    /**
     * @var int
     *
     * @ORM\Column(name="Code_Instrumentation", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $codeInstrumentation;

    /**
     * @var \Oeuvre
     *
     * @ORM\ManyToOne(targetEntity="Oeuvre")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Code_Oeuvre", referencedColumnName="Code_Oeuvre")
     * })
     */
    private $codeOeuvre;

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
