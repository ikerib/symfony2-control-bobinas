<?php

namespace Gitek\FrontendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;
use JMS\Serializer\Annotation\Exclude;

/**
 * LogSerigrafia
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Gitek\FrontendBundle\Entity\LogSerigrafiaRepository")
 * @ExclusionPolicy("none")
 */
class LogSerigrafia
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
     * @ORM\ManyToOne(targetEntity="Gitek\BackendBundle\Entity\ValidacionSerigrafia", inversedBy="$logserigrafia")
     * @ORM\JoinColumn(name="pregunta_id", referencedColumnName="id")
     * @Exclude
     */
    protected $pregunta;

    /**
     * @var string
     *
     * @ORM\Column(name="respuesta", type="string", length=255)
     */
    private $respuesta;

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
        return $this->getRespuesta();
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
     * Set respuesta
     *
     * @param string $respuesta
     * @return LogSerigrafia
     */
    public function setRespuesta($respuesta)
    {
        $this->respuesta = $respuesta;

        return $this;
    }

    /**
     * Get respuesta
     *
     * @return string 
     */
    public function getRespuesta()
    {
        return $this->respuesta;
    }

    /**
     * Set created_at
     *
     * @param \DateTime $createdAt
     * @return LogSerigrafia
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
     * @return LogSerigrafia
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
     * Set pregunta
     *
     * @param \Gitek\BackendBundle\Entity\ValidacionSerigrafia $pregunta
     * @return LogSerigrafia
     */
    public function setPregunta(\Gitek\BackendBundle\Entity\ValidacionSerigrafia $pregunta = null)
    {
        $this->pregunta = $pregunta;

        return $this;
    }

    /**
     * Get pregunta
     *
     * @return \Gitek\BackendBundle\Entity\ValidacionSerigrafia 
     */
    public function getPregunta()
    {
        return $this->pregunta;
    }

    /**
     * Set log
     *
     * @param \Gitek\FrontendBundle\Entity\Log $log
     * @return LogSerigrafia
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
