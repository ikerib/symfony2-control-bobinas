<?php

namespace Gitek\FrontendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Logdetail
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Gitek\FrontendBundle\Entity\LogdetailRepository")
 */
class Logdetail
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
     * @ORM\Column(name="componente", type="string", length=255, nullable=true)
     */
    private $componente;

    /**
     * @var string
     *
     * @ORM\Column(name="posicion1", type="string", length=255, nullable=true)
     */
    private $posicion1;

    /**
     * @var string
     *
     * @ORM\Column(name="posicion2", type="string", length=255, nullable=true)
     */
    private $posicion2;

    /**
     * @var string
     *
     * @ORM\Column(name="cantidad", type="string", length=255, nullable=true)
     */
    private $cantidad;

    /**
     * @var \DateTime $created_at
     *
     * @ORM\Column(name="created_at", type="datetime", nullable=true)
     */
    private $created_at;

    /**
     * @var \DateTime $updated_at
     *
     * @ORM\Column(name="updated_at", type="datetime", nullable=true)
     */
    private $updated_at;

    /**
     * @ORM\ManyToOne(targetEntity="Log", inversedBy="detalles")
     * @ORM\JoinColumn(name="log_id", referencedColumnName="id")
     */
    protected $log;


    public function __construct()
    {
        $this->created_at = new \DateTime();
        $this->updated_at = new \DateTime();
    }

    public function __toString()
    {
        return $this->getOf();
    }

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
     * Set componente
     *
     * @param string $componente
     * @return Logdetail
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
     * Set posicion1
     *
     * @param string $posicion1
     * @return Logdetail
     */
    public function setPosicion1($posicion1)
    {
        $this->posicion1 = $posicion1;

        return $this;
    }

    /**
     * Get posicion1
     *
     * @return string
     */
    public function getPosicion1()
    {
        return $this->posicion1;
    }

    /**
     * Set posicion2
     *
     * @param string $posicion2
     * @return Logdetail
     */
    public function setPosicion2($posicion2)
    {
        $this->posicion2 = $posicion2;

        return $this;
    }

    /**
     * Get posicion2
     *
     * @return string
     */
    public function getPosicion2()
    {
        return $this->posicion2;
    }

    /**
     * Set cantidad
     *
     * @param string $cantidad
     * @return Logdetail
     */
    public function setCantidad($cantidad)
    {
        $this->cantidad = $cantidad;

        return $this;
    }

    /**
     * Get cantidad
     *
     * @return string
     */
    public function getCantidad()
    {
        return $this->cantidad;
    }

    /**
     * Set created_at
     *
     * @param \DateTime $createdAt
     * @return Logdetail
     */
    public function setCreatedAt($createdAt)
    {
        $this->created_at = $createdAt;

        return $this;
    }

    /**
     * Get created_at
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->created_at;
    }

    /**
     * Set updated_at
     *
     * @param \DateTime $updatedAt
     * @return Logdetail
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updated_at = $updatedAt;

        return $this;
    }

    /**
     * Get updated_at
     *
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updated_at;
    }

    /**
     * Set log
     *
     * @param \Gitek\FrontendBundle\Entity\Log $log
     * @return Logdetail
     */
    public function setLog(\Gitek\FrontendBundle\Entity\Log $log = null)
    {
        $this->log = $log;

        return $this;
    }

    /**
     * Get log
     *
     * @return \Gitek\FrontendBundle\Entity\Log 
     */
    public function getLog()
    {
        return $this->log;
    }
}
