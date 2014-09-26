<?php

namespace Gitek\BackendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AuxSerigrafia
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Gitek\BackendBundle\Entity\AuxSerigrafiaRepository")
 */
class AuxSerigrafia
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
     * @ORM\Column(name="texto", type="string", length=255)
     */
    private $texto;

    /**
     * @var string
     *
     * @ORM\Column(name="completado", type="string", length=255)
     */
    private $completado;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha", type="datetime")
     */
    private $fecha;

    /**
     * @var string
     *
     * @ORM\Column(name="descripcion", type="string", length=255)
     */
    private $descripcion;

    /**
     * @var boolean
     *
     * @ORM\Column(name="mostrar", type="boolean")
     */
    private $mostrar;


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
     * Set texto
     *
     * @param string $texto
     * @return AuxSerigrafia
     */
    public function setTexto($texto)
    {
        $this->texto = $texto;

        return $this;
    }

    /**
     * Get texto
     *
     * @return string 
     */
    public function getTexto()
    {
        return $this->texto;
    }

    /**
     * Set completado
     *
     * @param string $completado
     * @return AuxSerigrafia
     */
    public function setCompletado($completado)
    {
        $this->completado = $completado;

        return $this;
    }

    /**
     * Get completado
     *
     * @return string 
     */
    public function getCompletado()
    {
        return $this->completado;
    }

    /**
     * Set fecha
     *
     * @param \DateTime $fecha
     * @return AuxSerigrafia
     */
    public function setFecha($fecha)
    {
        $this->fecha = $fecha;

        return $this;
    }

    /**
     * Get fecha
     *
     * @return \DateTime 
     */
    public function getFecha()
    {
        return $this->fecha;
    }

    /**
     * Set descripcion
     *
     * @param string $descripcion
     * @return AuxSerigrafia
     */
    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    /**
     * Get descripcion
     *
     * @return string 
     */
    public function getDescripcion()
    {
        return $this->descripcion;
    }

    /**
     * Set mostrar
     *
     * @param boolean $mostrar
     * @return AuxSerigrafia
     */
    public function setMostrar($mostrar)
    {
        $this->mostrar = $mostrar;

        return $this;
    }

    /**
     * Get mostrar
     *
     * @return boolean 
     */
    public function getMostrar()
    {
        return $this->mostrar;
    }
}
