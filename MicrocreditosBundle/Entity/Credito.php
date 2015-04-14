<?php

namespace AhoraMadrid\MicrocreditosBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;
use AhoraMadrid\MicrocreditosBundle\Validator\Constraints as AMAssert;

/**
 * Credito
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="AhoraMadrid\MicrocreditosBundle\Entity\CreditoRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Credito
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
     * @ORM\Column(name="nombre", type="string", length=40)
     */
    private $nombre;

    /**
     * @var string
     *
     * @ORM\Column(name="apellidos", type="string", length=80)
     */
    private $apellidos;

    /**
     * @var string
     *
     * @ORM\Column(name="documentoIdentidad", type="string", length=10)
	 * @AMAssert\DniNie
     */
    private $documentoIdentidad;

    /**
     * @var string
     *
     * @ORM\Column(name="correoElectronico", type="string", length=40)
	 * @Assert\Email()
     */
    private $correoElectronico;

    /**
     * @var string
     *
     * @ORM\Column(name="pais", type="string", length=40)
     */
    private $pais;

    /**
     * @var string
     *
     * @ORM\Column(name="provincia", type="string", length=40)
     */
    private $provincia;

    /**
     * @var string
     *
     * @ORM\Column(name="municipio", type="string", length=40)
     */
    private $municipio;

    /**
     * @var integer
     *
     * @ORM\Column(name="codigoPostal", type="integer", length=11)
     */
    private $codigoPostal;

    /**
     * @var string
     *
     * @ORM\Column(name="direcccion", type="string", length=120)
     */
    private $direcccion;

    /**
     * @var integer
     *
     * @ORM\Column(name="importe", type="integer", length=11)
     */
    private $importe;
	
	/**
     * @var string
     *
     * @ORM\Column(name="identificador", type="string", length=40)
     */
    private $identificador;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha", type="datetime")
     */
    private $fecha;
	
	/**
     * @var boolean
     *
     * @ORM\Column(name="recibido", type="boolean")
     */
    private $recibido = false;
	
	/**
     * Se establece el valor fecha cuando se va a insertar un crédito.
     *
     * @ORM\PrePersist
     */
    public function rellenarFecha(){
        $this->setFecha(new \DateTime(date('Y-m-d H:i:s')));
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
     *
     * @return Credito
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
     * Set apellidos
     *
     * @param string $apellidos
     *
     * @return Credito
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
     * Set documentoIdentidad
     *
     * @param string $documentoIdentidad
     *
     * @return Credito
     */
    public function setDocumentoIdentidad($documentoIdentidad)
    {
        $this->documentoIdentidad = $documentoIdentidad;

        return $this;
    }

    /**
     * Get documentoIdentidad
     *
     * @return string
     */
    public function getDocumentoIdentidad()
    {
        return $this->documentoIdentidad;
    }

    /**
     * Set correoElectronico
     *
     * @param string $correoElectronico
     *
     * @return Credito
     */
    public function setCorreoElectronico($correoElectronico)
    {
        $this->correoElectronico = $correoElectronico;

        return $this;
    }

    /**
     * Get correoElectronico
     *
     * @return string
     */
    public function getCorreoElectronico()
    {
        return $this->correoElectronico;
    }

    /**
     * Set pais
     *
     * @param string $pais
     *
     * @return Credito
     */
    public function setPais($pais)
    {
        $this->pais = $pais;

        return $this;
    }

    /**
     * Get pais
     *
     * @return string
     */
    public function getPais()
    {
        return $this->pais;
    }

    /**
     * Set provincia
     *
     * @param string $provincia
     *
     * @return Credito
     */
    public function setProvincia($provincia)
    {
        $this->provincia = $provincia;

        return $this;
    }

    /**
     * Get provincia
     *
     * @return string
     */
    public function getProvincia()
    {
        return $this->provincia;
    }

    /**
     * Set municipio
     *
     * @param string $municipio
     *
     * @return Credito
     */
    public function setMunicipio($municipio)
    {
        $this->municipio = $municipio;

        return $this;
    }

    /**
     * Get municipio
     *
     * @return string
     */
    public function getMunicipio()
    {
        return $this->municipio;
    }

    /**
     * Set codigoPostal
     *
     * @param integer $codigoPostal
     *
     * @return Credito
     */
    public function setCodigoPostal($codigoPostal)
    {
        $this->codigoPostal = $codigoPostal;

        return $this;
    }

    /**
     * Get codigoPostal
     *
     * @return integer
     */
    public function getCodigoPostal()
    {
        return $this->codigoPostal;
    }

    /**
     * Set direcccion
     *
     * @param string $direcccion
     *
     * @return Credito
     */
    public function setDirecccion($direcccion)
    {
        $this->direcccion = $direcccion;

        return $this;
    }

    /**
     * Get direcccion
     *
     * @return string
     */
    public function getDirecccion()
    {
        return $this->direcccion;
    }

    /**
     * Set importe
     *
     * @param integer $importe
     *
     * @return Credito
     */
    public function setImporte($importe)
    {
        $this->importe = $importe;

        return $this;
    }

    /**
     * Get importe
     *
     * @return integer
     */
    public function getImporte()
    {
        return $this->importe;
    }
	
	/**
     * Set identificador
     *
     * @param integer $identificador
     *
     * @return Credito
     */
    public function setIdentificador($identificador)
    {
        $this->identificador = $identificador;

        return $this;
    }

    /**
     * Get identificador
     *
     * @return string
     */
    public function getIdentificador()
    {
        return $this->identificador;
    }

    /**
     * Set fecha
     *
     * @param \DateTime $fecha
     *
     * @return Credito
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
     * Set recibido
     *
     * @param boolean $recibido
     *
     * @return Credito
     */
    public function setRecibido($recibido)
    {
        $this->recibido = $recibido;

        return $this;
    }

    /**
     * Get recibido
     *
     * @return boolean
     */
    public function getRecibido()
    {
        return $this->recibido;
    }
}

