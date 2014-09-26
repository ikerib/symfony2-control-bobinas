<?php

namespace Gitek\BackendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AuxDiodos
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Gitek\BackendBundle\Entity\AuxDiodosRepository")
 */
class AuxDiodos
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="referencia", type="string", length=255)
     */
    private $referencia;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set referencia
     *
     * @param string $referencia
     * @return AuxDiodos
     */
    public function setReferencia($referencia)
    {
        $this->referencia = $referencia;

        return $this;
    }

    /**
     * Get referencia
     *
     * @return string 
     */
    public function getReferencia()
    {
        return $this->referencia;
    }
}
