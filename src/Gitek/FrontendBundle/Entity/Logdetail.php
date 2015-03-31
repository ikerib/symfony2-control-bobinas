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
     * @ORM\Column(name="descripcion", type="string", length=255, nullable=true)
     */
    private $descripcion;

    /**
     * @var string
     *
     * @ORM\Column(name="lote", type="string", length=255, nullable=true)
     */
    private $lote;

    /**
     * @var string
     *
     * @ORM\Column(name="uuid", type="string", length=255, nullable=true)
     */
    private $uuid;

    /**
     * @var string
     *
     * @ORM\Column(name="bin1", type="string", length=255, nullable=true)
     */
    private $bin1;

    /**
     * @var string
     *
     * @ORM\Column(name="bin2", type="string", length=255, nullable=true)
     */
    private $bin2;

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

    /**
     * @ORM\ManyToOne(targetEntity="Gitek\BackendBundle\Entity\Usuario", inversedBy="detalles")
     * @ORM\JoinColumn(name="usuario_id", referencedColumnName="id")
     */
    protected $usuario;


    public function __construct()
    {
        $this->created_at = new \DateTime();
        $this->updated_at = new \DateTime();
    }

    public function __toString()
    {
        return $this->getDescripcion();
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
     * Set descripcion
     *
     * @param string $descripcion
     * @return Logdetail
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

    /**
     * Set usuario
     *
     * @param \Gitek\BackendBundle\Entity\Usuario $usuario
     * @return Logdetail
     */
    public function setUsuario(\Gitek\BackendBundle\Entity\Usuario $usuario = null)
    {
        $this->usuario = $usuario;

        return $this;
    }

    /**
     * Get usuario
     *
     * @return \Gitek\BackendBundle\Entity\Usuario 
     */
    public function getUsuario()
    {
        return $this->usuario;
    }

    /**
     * Set lote
     *
     * @param string $lote
     * @return Logdetail
     */
    public function setLote($lote)
    {
        $this->lote = $lote;

        return $this;
    }

    /**
     * Get lote
     *
     * @return string 
     */
    public function getLote()
    {
        return $this->lote;
    }

    /**
     * Set uuid
     *
     * @param string $uuid
     * @return Logdetail
     */
    public function setUuid($uuid)
    {
        $this->uuid = $uuid;

        return $this;
    }

    /**
     * Get uuid
     *
     * @return string 
     */
    public function getUuid()
    {
        return $this->uuid;
    }

    /**
     * Set bin1
     *
     * @param string $bin1
     * @return Logdetail
     */
    public function setBin1($bin1)
    {
        $this->bin1 = $bin1;

        return $this;
    }

    /**
     * Get bin1
     *
     * @return string 
     */
    public function getBin1()
    {
        return $this->bin1;
    }

    /**
     * Set bin2
     *
     * @param string $bin2
     * @return Logdetail
     */
    public function setBin2($bin2)
    {
        $this->bin2 = $bin2;

        return $this;
    }

    /**
     * Get bin2
     *
     * @return string 
     */
    public function getBin2()
    {
        return $this->bin2;
    }
}
