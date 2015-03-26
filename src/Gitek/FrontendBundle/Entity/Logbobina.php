<?php

namespace Gitek\FrontendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Logbobina
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Gitek\FrontendBundle\Entity\LogbobinaRepository")
 */
class Logbobina
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
     * @ORM\Column(name="of", type="string", length=255)
     */
    private $of;

    /**
     * @var string
     *
     * @ORM\Column(name="operacion", type="string", length=255)
     */
    private $operacion;

    /**
     * @var string
     *
     * @ORM\Column(name="componenteSale", type="string", length=255)
     */
    private $componenteSale;

    /**
     * @var string
     *
     * @ORM\Column(name="componenteEntra", type="string", length=255)
     */
    private $componenteEntra;

    /**
     * @var string
     *
     * @ORM\Column(name="loteSale", type="string", length=255)
     */
    private $loteSale;

    /**
     * @var string
     *
     * @ORM\Column(name="loteEntra", type="string", length=255)
     */
    private $loteEntra;

    /**
     * @var string
     *
     * @ORM\Column(name="uuidSale", type="string", length=255)
     */
    private $uuidSale;

    /**
     * @var string
     *
     * @ORM\Column(name="uuidEntra", type="string", length=255)
     */
    private $uuidEntra;

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
     * Set of
     *
     * @param string $of
     * @return Logbobina
     */
    public function setOf($of)
    {
        $this->of = $of;

        return $this;
    }

    /**
     * Get of
     *
     * @return string 
     */
    public function getOf()
    {
        return $this->of;
    }

    /**
     * Set operacion
     *
     * @param string $operacion
     * @return Logbobina
     */
    public function setOperacion($operacion)
    {
        $this->operacion = $operacion;

        return $this;
    }

    /**
     * Get operacion
     *
     * @return string 
     */
    public function getOperacion()
    {
        return $this->operacion;
    }

    /**
     * Set componenteSale
     *
     * @param string $componenteSale
     * @return Logbobina
     */
    public function setComponenteSale($componenteSale)
    {
        $this->componenteSale = $componenteSale;

        return $this;
    }

    /**
     * Get componenteSale
     *
     * @return string 
     */
    public function getComponenteSale()
    {
        return $this->componenteSale;
    }

    /**
     * Set componenteEntra
     *
     * @param string $componenteEntra
     * @return Logbobina
     */
    public function setComponenteEntra($componenteEntra)
    {
        $this->componenteEntra = $componenteEntra;

        return $this;
    }

    /**
     * Get componenteEntra
     *
     * @return string 
     */
    public function getComponenteEntra()
    {
        return $this->componenteEntra;
    }

    /**
     * Set loteSale
     *
     * @param string $loteSale
     * @return Logbobina
     */
    public function setLoteSale($loteSale)
    {
        $this->loteSale = $loteSale;

        return $this;
    }

    /**
     * Get loteSale
     *
     * @return string 
     */
    public function getLoteSale()
    {
        return $this->loteSale;
    }

    /**
     * Set loteEntra
     *
     * @param string $loteEntra
     * @return Logbobina
     */
    public function setLoteEntra($loteEntra)
    {
        $this->loteEntra = $loteEntra;

        return $this;
    }

    /**
     * Get loteEntra
     *
     * @return string 
     */
    public function getLoteEntra()
    {
        return $this->loteEntra;
    }

    /**
     * Set uuidSale
     *
     * @param string $uuidSale
     * @return Logbobina
     */
    public function setUuidSale($uuidSale)
    {
        $this->uuidSale = $uuidSale;

        return $this;
    }

    /**
     * Get uuidSale
     *
     * @return string 
     */
    public function getUuidSale()
    {
        return $this->uuidSale;
    }

    /**
     * Set uuidEntra
     *
     * @param string $uuidEntra
     * @return Logbobina
     */
    public function setUuidEntra($uuidEntra)
    {
        $this->uuidEntra = $uuidEntra;

        return $this;
    }

    /**
     * Get uuidEntra
     *
     * @return string 
     */
    public function getUuidEntra()
    {
        return $this->uuidEntra;
    }

    /**
     * Set created_at
     *
     * @param \DateTime $createdAt
     * @return Logbobina
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
     * @return Logbobina
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
     * @return Logbobina
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
     * @return Logbobina
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
}
