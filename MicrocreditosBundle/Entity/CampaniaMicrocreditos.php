<?php

namespace AhoraMadrid\MicrocreditosBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CampaniaMicrocreditos
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="AhoraMadrid\MicrocreditosBundle\Entity\CampaniaMicrocreditosRepository")
 */
class CampaniaMicrocreditos
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
     * @ORM\Column(name="finalidad", type="string", length=40)
     */
    private $finalidad;

    /**
     * @var string
     *
     * @ORM\Column(name="concepto", type="string", length=20)
     */
    private $concepto;

    /**
     * @var integer
     *
     * @ORM\Column(name="objetivo", type="integer", length=11)
     */
    private $objetivo;

    /**
     * @var boolean
     *
     * @ORM\Column(name="activa", type="boolean")
     */
    private $activa;
    
    /**
     * @var string
     *
     * @ORM\Column(name="fase", type="string", length=20, nullable=true)
     */
    private $fase;


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
     * Set finalidad
     *
     * @param string $finalidad
     *
     * @return CampaniaMicrocreditos
     */
    public function setFinalidad($finalidad)
    {
        $this->finalidad = $finalidad;

        return $this;
    }

    /**
     * Get finalidad
     *
     * @return string
     */
    public function getFinalidad()
    {
        return $this->finalidad;
    }

    /**
     * Set concepto
     *
     * @param string $concepto
     *
     * @return CampaniaMicrocreditos
     */
    public function setConcepto($concepto)
    {
        $this->concepto = $concepto;

        return $this;
    }

    /**
     * Get concepto
     *
     * @return string
     */
    public function getConcepto()
    {
        return $this->concepto;
    }

    /**
     * Set objetivo
     *
     * @param integer $objetivo
     *
     * @return CampaniaMicrocreditos
     */
    public function setObjetivo($objetivo)
    {
        $this->objetivo = $objetivo;

        return $this;
    }

    /**
     * Get objetivo
     *
     * @return integer
     */
    public function getObjetivo()
    {
        return $this->objetivo;
    }

    /**
     * Set activa
     *
     * @param boolean $activa
     *
     * @return CampaniaMicrocreditos
     */
    public function setActiva($activa)
    {
        $this->activa = $activa;

        return $this;
    }

    /**
     * Get activa
     *
     * @return boolean
     */
    public function getActiva()
    {
        return $this->activa;
    }
    
    /**
     * Set fase
     *
     * @param string $fase
     *
     * @return CampaniaMicrocreditos
     */
    public function setFase($fase)
    {
    	$this->fase = $fase;
    
    	return $this;
    }
    
    /**
     * Get fase
     *
     * @return string
     */
    public function getFase()
    {
    	return $this->fase;
    }
}

