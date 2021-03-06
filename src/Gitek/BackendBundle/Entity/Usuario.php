<?php

namespace Gitek\BackendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Usuario
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Gitek\BackendBundle\Entity\UsuarioRepository")
 * @Vich\Uploadable
 */
class Usuario
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
     * @ORM\Column(name="nombre", type="string", length=255)
     */
    private $nombre;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=255, nullable=true)
     */
    private $password;

    /**
     * @var string
     *
     * @ORM\Column(name="apellidos", type="string", length=255, nullable=true)
     */
    private $apellidos;

    /**
     * @var smallint
     *
     * @ORM\Column(name="encargado", type="smallint")
     */
    private $encargado;

    /**
     * @var smallint
     *
     * @ORM\Column(name="admin", type="smallint")
     */
    private $admin;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255, nullable=true)
     */
    private $email;

    /**
     * @Vich\UploadableField(mapping="avatar", fileNameProperty="avatar", nullable=true)
     *
     * @var File $avatarImg
     */
    protected $avatarImg;

    /**
     * @ORM\Column(type="string", length=255, name="avatar", nullable=true)
     *
     * @var string $avatar
     */
    protected $avatar;


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
     *
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile $image
     */
    public function setAvatarImg(File $image)
    {
        $this->avatarImg = $image;

        if ($image) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->updated = new \DateTime('now');
        }
    }

    /**
     * @return File
     */
    public function getAvatarImg()
    {
        return $this->avatarImg;
    }

    /**
     * @param string $avatar
     */
    public function setAvatar($avatar)
    {
        $this->avatar = $avatar;
    }

    /**
     * @return string
     */
    public function getAvatar()
    {
        return $this->avatar;
    }

    public function __toString()
    {
        return $this->getNombre();
    }


    /**
     * @ORM\OneToMany(targetEntity="Gitek\FrontendBundle\Entity\Logdetail", mappedBy="usuario")
     */
    private $detalles;

    /**
     * @ORM\OneToMany(targetEntity="Gitek\FrontendBundle\Entity\Logbobina", mappedBy="usuario")
     */
    private $logbobinas;


    public function __construct()
    {
        $this->detalles = new ArrayCollection();
        $this->logbobinas = new ArrayCollection();
        $this->admin = 0;
        $this->encargado = 0;
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
     * Set nombre
     *
     * @param string $nombre
     * @return Usuario
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * Get nombre
     *
     * @return string 
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Set androidreg
     *
     * @param string $androidreg
     * @return Usuario
     */
    public function setAndroidreg($androidreg)
    {
        $this->androidreg = $androidreg;

        return $this;
    }

    /**
     * Get androidreg
     *
     * @return string 
     */
    public function getAndroidreg()
    {
        return $this->androidreg;
    }

    /**
     * Set password
     *
     * @param string $password
     * @return Usuario
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password
     *
     * @return string 
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set apellidos
     *
     * @param string $apellidos
     * @return Usuario
     */
    public function setApellidos($apellidos)
    {
        $this->apellidos = $apellidos;

        return $this;
    }

    /**
     * Get apellidos
     *
     * @return string 
     */
    public function getApellidos()
    {
        return $this->apellidos;
    }

    /**
     * Set encargado
     *
     * @param integer $encargado
     * @return Usuario
     */
    public function setEncargado($encargado)
    {
        $this->encargado = $encargado;

        return $this;
    }

    /**
     * Get encargado
     *
     * @return integer 
     */
    public function getEncargado()
    {
        return $this->encargado;
    }

    /**
     * Set admin
     *
     * @param integer $admin
     * @return Usuario
     */
    public function setAdmin($admin)
    {
        $this->admin = $admin;

        return $this;
    }

    /**
     * Get admin
     *
     * @return integer 
     */
    public function getAdmin()
    {
        return $this->admin;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return Usuario
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string 
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     * @return Usuario
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
     * @return Usuario
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
     * @param \Gitek\FrontendBundle\Entity\Logdetail $detalles
     * @return Usuario
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
     * Add logbobinas
     *
     * @param \Gitek\FrontendBundle\Entity\Logbobina $logbobinas
     * @return Usuario
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
}
