<?php

namespace Gitek\BackendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * ValidacionSerigrafia
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Gitek\BackendBundle\Entity\ValidacionSerigrafiaRepository")
 */
class ValidacionSerigrafia
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
     * @ORM\Column(name="pregunta", type="string", length=255)
     */
    private $pregunta;

    /**
     * @var boolean
     *
     * @ORM\Column(name="mostrar", type="boolean", nullable=true)
     */
    private $mostrar;

    /**
     * @var datetime $created
     *
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime")
     */
    private $created;

    /**
     * @var datetime $updated
     *
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(type="datetime")
     */
    private $updated;

    /**
     * @ORM\OneToMany(targetEntity="Gitek\FrontendBundle\Entity\LogSerigrafia", mappedBy="validacionserigrafia")
     */
    private $detalles;

    public function __construct()
    {
        $this->created_at = new \DateTime();
        $this->updated_at = new \DateTime();
        $this->detalles = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->getPregunta();
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
     * Set pregunta
     *
     * @param string $pregunta
     * @return ValidacionSerigrafia
     */
    public function setPregunta($pregunta)
    {
        $this->pregunta = $pregunta;

        return $this;
    }

    /**
     * Get pregunta
     *
     * @return string 
     */
    public function getPregunta()
    {
        return $this->pregunta;
    }

    /**
     * Set mostrar
     *
     * @param boolean $mostrar
     * @return ValidacionSerigrafia
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

    /**
     * Set created
     *
     * @param \DateTime $created
     * @return ValidacionSerigrafia
     */
    public function setCreated($created)
    {
        $this->created = $created;

        return $this;
    }

    /**
     * Get created
     *
     * @return \DateTime 
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Set updated
     *
     * @param \DateTime $updated
     * @return ValidacionSerigrafia
     */
    public function setUpdated($updated)
    {
        $this->updated = $updated;

        return $this;
    }

    /**
     * Get updated
     *
     * @return \DateTime 
     */
    public function getUpdated()
    {
        return $this->updated;
    }

    /**
     * Add detalles
     *
     * @param \Gitek\FrontendBundle\Entity\LogSerigrafia $detalles
     * @return ValidacionSerigrafia
     */
    public function addDetalle(\Gitek\FrontendBundle\Entity\LogSerigrafia $detalles)
    {
        $this->detalles[] = $detalles;

        return $this;
    }

    /**
     * Remove detalles
     *
     * @param \Gitek\FrontendBundle\Entity\LogSerigrafia $detalles
     */
    public function removeDetalle(\Gitek\FrontendBundle\Entity\LogSerigrafia $detalles)
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
}
