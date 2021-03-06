<?php

namespace Gitek\FrontendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Log
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Gitek\FrontendBundle\Entity\LogRepository")
 */
class Log
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
     * @ORM\Column(name="operacion", type="string", length=255, nullable=true)
     */
    private $operacion;

    /**
     * @var boolean
     *
     * @ORM\Column(name="validacion1", type="boolean", nullable=true)
     */
    private $validacion1;

    /**
     * @var string
     *
     * @ORM\Column(name="codval1", type="string", length=255, nullable=true)
     */
    private $codval1;


    /**
     * @var boolean
     *
     * @ORM\Column(name="validacion2", type="boolean", nullable=true)
     */
    private $validacion2;

    /**
     * @var string
     *
     * @ORM\Column(name="codval2", type="string", length=255, nullable=true)
     */
    private $codval2;

    /**
     * @var boolean
     *
     * @ORM\Column(name="validacion3", type="boolean", nullable=true)
     */
    private $validacion3;

    /**
     * @var string
     *
     * @ORM\Column(name="codval3", type="string", length=255, nullable=true)
     */
    private $codval3;

    /**
     * @var boolean
     *
     * @ORM\Column(name="validacion4", type="boolean", nullable=true)
     */
    private $validacion4;

    /**
     * @var boolean
     *
     * @ORM\Column(name="validacion4usuario", type="boolean", nullable=true)
     */
    private $validacion4usuario;

    /**
     * @var string
     *
     * @ORM\Column(name="codval4", type="string", length=255, nullable=true)
     */

    private $codval4;

    /**
     * @var string
     *
     * @ORM\Column(name="obsval4", type="string", length=255, nullable=true)
     */

    private $obsval4;

    /**
     * @var boolean
     *
     * @ORM\Column(name="validacion5", type="boolean", nullable=true)
     */
    private $validacion5;

    /**
     * @var string
     *
     * @ORM\Column(name="codval5", type="string", length=255, nullable=true)
     */
    private $codval5;

    /**
     * @var boolean
     *
     * @ORM\Column(name="validacion6", type="boolean", nullable=true)
     */
    private $validacion6;

    /**
     * @var string
     *
     * @ORM\Column(name="codval6", type="string", length=255, nullable=true)
     */
    private $codval6;


    /**
     * @var string
     *
     * @ORM\Column(name="programa", type="string", length=255, nullable=true)
     */
    private $programa;

    /**
     * @var boolean
     *
     * @ORM\Column(name="aoipatron", type="boolean", nullable=true)
     */
    private $aoipatron;

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
     * @ORM\OneToMany(targetEntity="Logdetail", mappedBy="log")
     */
    private $detalles;

    /**
     * @ORM\OneToMany(targetEntity="LogSerigrafia", mappedBy="log")
     */
    private $logserigrafia;

    /**
     * @ORM\OneToMany(targetEntity="LogPickplace", mappedBy="log")
     */
    private $logpickplace;

    /**
     * @ORM\OneToMany(targetEntity="Logbobina", mappedBy="log")
     */
    private $logbobinas;

    public function __construct()
    {
        $this->created_at = new \DateTime();
        $this->updated_at = new \DateTime();
        $this->detalles = new ArrayCollection();
        $this->logserigrafia = new ArrayCollection();
        $this->logpickplace = new ArrayCollection();
        $this->logbobinas = new ArrayCollection();
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
     * Set of
     *
     * @param string $of
     * @return Log
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
     * @return Log
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
     * Set validacion1
     *
     * @param boolean $validacion1
     * @return Log
     */
    public function setValidacion1($validacion1)
    {
        $this->validacion1 = $validacion1;

        return $this;
    }

    /**
     * Get validacion1
     *
     * @return boolean
     */
    public function getValidacion1()
    {
        return $this->validacion1;
    }

    /**
     * Set validacion2
     *
     * @param boolean $validacion2
     * @return Log
     */
    public function setValidacion2($validacion2)
    {
        $this->validacion2 = $validacion2;

        return $this;
    }

    /**
     * Get validacion2
     *
     * @return boolean
     */
    public function getValidacion2()
    {
        return $this->validacion2;
    }

    /**
     * Set validacion3
     *
     * @param boolean $validacion3
     * @return Log
     */
    public function setValidacion3($validacion3)
    {
        $this->validacion3 = $validacion3;

        return $this;
    }

    /**
     * Get validacion3
     *
     * @return boolean
     */
    public function getValidacion3()
    {
        return $this->validacion3;
    }

    /**
     * Set validacion4
     *
     * @param boolean $validacion4
     * @return Log
     */
    public function setValidacion4($validacion4)
    {
        $this->validacion4 = $validacion4;

        return $this;
    }

    /**
     * Get validacion4
     *
     * @return boolean
     */
    public function getValidacion4()
    {
        return $this->validacion4;
    }

    /**
     * Set validacion5
     *
     * @param boolean $validacion5
     * @return Log
     */
    public function setValidacion5($validacion5)
    {
        $this->validacion5 = $validacion5;

        return $this;
    }

    /**
     * Get validacion5
     *
     * @return boolean
     */
    public function getValidacion5()
    {
        return $this->validacion5;
    }

    /**
     * Set validacion6
     *
     * @param boolean $validacion6
     * @return Log
     */
    public function setValidacion6($validacion6)
    {
        $this->validacion6 = $validacion6;

        return $this;
    }

    /**
     * Get validacion6
     *
     * @return boolean
     */
    public function getValidacion6()
    {
        return $this->validacion6;
    }

    /**
     * Set created_at
     *
     * @param \DateTime $createdAt
     * @return Log
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
     * @return Log
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
     * Add detalles
     *
     * @param \Gitek\FrontendBundle\Entity\Logdetail $detalles
     * @return Log
     */
    public function addDetalle(\Gitek\FrontendBundle\Entity\Logdetail $detalles)
    {
        $this->detalles[] = $detalles;

        return $this;
    }

    /**
     * Remove detalles
     *
     * @param \Gitek\FrontendBundle\Entity\Logdetail $detalles
     */
    public function removeDetalle(\Gitek\FrontendBundle\Entity\Logdetail $detalles)
    {
        $this->detalles->removeElement($detalles);
    }

    /**
     * Get detalles
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getDetalles()
    {
        return $this->detalles;
    }

    /**
     * Add logserigrafia
     *
     * @param \Gitek\FrontendBundle\Entity\LogSerigrafia $logserigrafia
     * @return Log
     */
    public function addLogserigrafium(\Gitek\FrontendBundle\Entity\LogSerigrafia $logserigrafia)
    {
        $this->logserigrafia[] = $logserigrafia;

        return $this;
    }

    /**
     * Remove logserigrafia
     *
     * @param \Gitek\FrontendBundle\Entity\LogSerigrafia $logserigrafia
     */
    public function removeLogserigrafium(\Gitek\FrontendBundle\Entity\LogSerigrafia $logserigrafia)
    {
        $this->logserigrafia->removeElement($logserigrafia);
    }

    /**
     * Get logserigrafia
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getLogserigrafia()
    {
        return $this->logserigrafia;
    }

    /**
     * Add logpickplace
     *
     * @param \Gitek\FrontendBundle\Entity\LogPickplace $logpickplace
     * @return Log
     */
    public function addLogpickplace(\Gitek\FrontendBundle\Entity\LogPickplace $logpickplace)
    {
        $this->logpickplace[] = $logpickplace;

        return $this;
    }

    /**
     * Remove logpickplace
     *
     * @param \Gitek\FrontendBundle\Entity\LogPickplace $logpickplace
     */
    public function removeLogpickplace(\Gitek\FrontendBundle\Entity\LogPickplace $logpickplace)
    {
        $this->logpickplace->removeElement($logpickplace);
    }

    /**
     * Get logpickplace
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getLogpickplace()
    {
        return $this->logpickplace;
    }

    /**
     * Add logbobinas
     *
     * @param \Gitek\FrontendBundle\Entity\Logbobina $logbobinas
     * @return Log
     */
    public function addLogbobina(\Gitek\FrontendBundle\Entity\Logbobina $logbobinas)
    {
        $this->logbobinas[] = $logbobinas;

        return $this;
    }

    /**
     * Remove logbobinas
     *
     * @param \Gitek\FrontendBundle\Entity\Logbobina $logbobinas
     */
    public function removeLogbobina(\Gitek\FrontendBundle\Entity\Logbobina $logbobinas)
    {
        $this->logbobinas->removeElement($logbobinas);
    }

    /**
     * Get logbobinas
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getLogbobinas()
    {
        return $this->logbobinas;
    }

    /**
     * Set programa
     *
     * @param string $programa
     * @return Log
     */
    public function setPrograma($programa)
    {
        $this->programa = $programa;

        return $this;
    }

    /**
     * Get programa
     *
     * @return string
     */
    public function getPrograma()
    {
        return $this->programa;
    }

    /**
     * Set aoipatron
     *
     * @param boolean $aoipatron
     * @return Log
     */
    public function setAoipatron($aoipatron)
    {
        $this->aoipatron = $aoipatron;

        return $this;
    }

    /**
     * Get aoipatron
     *
     * @return boolean
     */
    public function getAoipatron()
    {
        return $this->aoipatron;
    }

    /**
     * Set codval1
     *
     * @param string $codval1
     * @return Log
     */
    public function setCodval1($codval1)
    {
        $this->codval1 = $codval1;

        return $this;
    }

    /**
     * Get codval1
     *
     * @return string 
     */
    public function getCodval1()
    {
        return $this->codval1;
    }

    /**
     * Set codval2
     *
     * @param string $codval2
     * @return Log
     */
    public function setCodval2($codval2)
    {
        $this->codval2 = $codval2;

        return $this;
    }

    /**
     * Get codval2
     *
     * @return string 
     */
    public function getCodval2()
    {
        return $this->codval2;
    }

    /**
     * Set codval3
     *
     * @param string $codval3
     * @return Log
     */
    public function setCodval3($codval3)
    {
        $this->codval3 = $codval3;

        return $this;
    }

    /**
     * Get codval3
     *
     * @return string 
     */
    public function getCodval3()
    {
        return $this->codval3;
    }

    /**
     * Set codval4
     *
     * @param string $codval4
     * @return Log
     */
    public function setCodval4($codval4)
    {
        $this->codval4 = $codval4;

        return $this;
    }

    /**
     * Get codval4
     *
     * @return string 
     */
    public function getCodval4()
    {
        return $this->codval4;
    }

    /**
     * Set codval5
     *
     * @param string $codval5
     * @return Log
     */
    public function setCodval5($codval5)
    {
        $this->codval5 = $codval5;

        return $this;
    }

    /**
     * Get codval5
     *
     * @return string 
     */
    public function getCodval5()
    {
        return $this->codval5;
    }

    /**
     * Set codval6
     *
     * @param string $codval6
     * @return Log
     */
    public function setCodval6($codval6)
    {
        $this->codval6 = $codval6;

        return $this;
    }

    /**
     * Get codval6
     *
     * @return string 
     */
    public function getCodval6()
    {
        return $this->codval6;
    }

    /**
     * Set validacion4usuario
     *
     * @param boolean $validacion4usuario
     * @return Log
     */
    public function setValidacion4usuario($validacion4usuario)
    {
        $this->validacion4usuario = $validacion4usuario;

        return $this;
    }

    /**
     * Get validacion4usuario
     *
     * @return boolean 
     */
    public function getValidacion4usuario()
    {
        return $this->validacion4usuario;
    }

    /**
     * Set obsval4
     *
     * @param string $obsval4
     * @return Log
     */
    public function setObsval4($obsval4)
    {
        $this->obsval4 = $obsval4;

        return $this;
    }

    /**
     * Get obsval4
     *
     * @return string 
     */
    public function getObsval4()
    {
        return $this->obsval4;
    }
}
