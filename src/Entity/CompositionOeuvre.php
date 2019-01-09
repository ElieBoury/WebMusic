<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CompositionOeuvre
 *
 * @ORM\Table(name="Composition_Oeuvre", indexes={@ORM\Index(name="IDX_AF138FE8CB48FCBD", columns={"Code_Oeuvre"}), @ORM\Index(name="IDX_AF138FE8D49D5E5D", columns={"Code_Composition"})})
 * @ORM\Entity
 */
class CompositionOeuvre
{
    /**
     * @var int
     *
     * @ORM\Column(name="Code_Composer_Oeuvre", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $codeComposerOeuvre;

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
     * @var \Composition
     *
     * @ORM\ManyToOne(targetEntity="Composition")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Code_Composition", referencedColumnName="Code_Composition")
     * })
     */
    private $codeComposition;


}
