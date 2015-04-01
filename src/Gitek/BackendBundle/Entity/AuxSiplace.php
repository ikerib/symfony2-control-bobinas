<?php

namespace Gitek\BackendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AuxSiplace
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Gitek\BackendBundle\Entity\AuxSiplaceRepository")
 */
class AuxSiplace
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
     * @ORM\Column(name="articulo", type="string", length=255)
     */
    private $articulo;

    /**
     * @var string
     *
     * @ORM\Column(name="componente", type="string", length=255, nullable=true)
     */
    private $componente;

    /**
     * @var string
     *
     * @ORM\Column(name="assambleon", type="string", length=255, nullable=true)
     */
    private $assambleon;

    /**
     * @var string
     *
     * @ORM\Column(name="ipulse", type="string", length=255, nullable=true)
     */
    private $ipulse;

    /**
     * @var string
     *
     * @ORM\Column(name="siplace", type="string", length=255, nullable=true)
     */
    private $siplace;


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
     * Set articulo
     *
     * @param string $articulo
     * @return AuxSiplace
     */
    public function setArticulo($articulo)
    {
        $this->articulo = $articulo;

        return $this;
    }

    /**
     * Get articulo
     *
     * @return string 
     */
    public function getArticulo()
    {
        return $this->articulo;
    }

    /**
     * Set componente
     *
     * @param string $componente
     * @return AuxSiplace
     */
    public function setComponente($componente)
    {
        $this->componente = $componente;

        return $this;
    }

    /**
     * Get componente
     *
     * @return string 
     */
    public function getComponente()
    {
        return $this->componente;
    }

    /**
     * Set assambleon
     *
     * @param string $assambleon
     * @return AuxSiplace
     */
    public function setAssambleon($assambleon)
    {
        $this->assambleon = $assambleon;

        return $this;
    }

    /**
     * Get assambleon
     *
     * @return string 
     */
    public function getAssambleon()
    {
        return $this->assambleon;
    }

    /**
     * Set ipulse
     *
     * @param string $ipulse
     * @return AuxSiplace
     */
    public function setIpulse($ipulse)
    {
        $this->ipulse = $ipulse;

        return $this;
    }

    /**
     * Get ipulse
     *
     * @return string 
     */
    public function getIpulse()
    {
        return $this->ipulse;
    }

    /**
     * Set siplace
     *
     * @param string $siplace
     * @return AuxSiplace
     */
    public function setSiplace($siplace)
    {
        $this->siplace = $siplace;

        return $this;
    }

    /**
     * Get siplace
     *
     * @return string 
     */
    public function getSiplace()
    {
        return $this->siplace;
    }
}
