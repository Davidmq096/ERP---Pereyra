<?php

namespace AppBundle\Entity;

/**
 * CeTarea
 */
class CeTarea
{
    /**
     * @var string
     */
    private $nombre;

    /**
     * @var string
     */
    private $descripcion;

    /**
     * @var integer
     */
    private $captura;

    /**
     * @var \DateTime
     */
    private $fechainicio;

    /**
     * @var \DateTime
     */
    private $fechafin;

    /**
     * @var \DateTime
     */
    private $horalimite;

    /**
     * @var integer
     */
    private $entregaextemporanea = '0';

    /**
     * @var integer
     */
    private $tareaid;

    /**
     * @var \AppBundle\Entity\CeCriterioevaluaciongrupo
     */
    private $criterioevaluaciongrupoid;

    /**
     * @var \AppBundle\Entity\CeTipoentrega
     */
    private $tipoentregaid;

    /**
     * @var \AppBundle\Entity\Materia
     */
    private $materiaid;


    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return CeTarea
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
     * Set descripcion
     *
     * @param string $descripcion
     *
     * @return CeTarea
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
     * Set captura
     *
     * @param integer $captura
     *
     * @return CeTarea
     */
    public function setCaptura($captura)
    {
        $this->captura = $captura;

        return $this;
    }

    /**
     * Get captura
     *
     * @return integer
     */
    public function getCaptura()
    {
        return $this->captura;
    }

    /**
     * Set fechainicio
     *
     * @param \DateTime $fechainicio
     *
     * @return CeTarea
     */
    public function setFechainicio($fechainicio)
    {
        $this->fechainicio = $fechainicio;

        return $this;
    }

    /**
     * Get fechainicio
     *
     * @return \DateTime
     */
    public function getFechainicio()
    {
        return $this->fechainicio;
    }

    /**
     * Set fechafin
     *
     * @param \DateTime $fechafin
     *
     * @return CeTarea
     */
    public function setFechafin($fechafin)
    {
        $this->fechafin = $fechafin;

        return $this;
    }

    /**
     * Get fechafin
     *
     * @return \DateTime
     */
    public function getFechafin()
    {
        return $this->fechafin;
    }

    /**
     * Set horalimite
     *
     * @param \DateTime $horalimite
     *
     * @return CeTarea
     */
    public function setHoralimite($horalimite)
    {
        $this->horalimite = $horalimite;

        return $this;
    }

    /**
     * Get horalimite
     *
     * @return \DateTime
     */
    public function getHoralimite()
    {
        return $this->horalimite;
    }

    /**
     * Set entregaextemporanea
     *
     * @param integer $entregaextemporanea
     *
     * @return CeTarea
     */
    public function setEntregaextemporanea($entregaextemporanea)
    {
        $this->entregaextemporanea = $entregaextemporanea;

        return $this;
    }

    /**
     * Get entregaextemporanea
     *
     * @return integer
     */
    public function getEntregaextemporanea()
    {
        return $this->entregaextemporanea;
    }

    /**
     * Get tareaid
     *
     * @return integer
     */
    public function getTareaid()
    {
        return $this->tareaid;
    }

    /**
     * Set criterioevaluaciongrupoid
     *
     * @param \AppBundle\Entity\CeCriterioevaluaciongrupo $criterioevaluaciongrupoid
     *
     * @return CeTarea
     */
    public function setCriterioevaluaciongrupoid(\AppBundle\Entity\CeCriterioevaluaciongrupo $criterioevaluaciongrupoid = null)
    {
        $this->criterioevaluaciongrupoid = $criterioevaluaciongrupoid;

        return $this;
    }

    /**
     * Get criterioevaluaciongrupoid
     *
     * @return \AppBundle\Entity\CeCriterioevaluaciongrupo
     */
    public function getCriterioevaluaciongrupoid()
    {
        return $this->criterioevaluaciongrupoid;
    }

    /**
     * Set tipoentregaid
     *
     * @param \AppBundle\Entity\CeTipoentrega $tipoentregaid
     *
     * @return CeTarea
     */
    public function setTipoentregaid(\AppBundle\Entity\CeTipoentrega $tipoentregaid = null)
    {
        $this->tipoentregaid = $tipoentregaid;

        return $this;
    }

    /**
     * Get tipoentregaid
     *
     * @return \AppBundle\Entity\CeTipoentrega
     */
    public function getTipoentregaid()
    {
        return $this->tipoentregaid;
    }

    /**
     * Set materiaid
     *
     * @param \AppBundle\Entity\Materia $materiaid
     *
     * @return CeTarea
     */
    public function setMateriaid(\AppBundle\Entity\Materia $materiaid = null)
    {
        $this->materiaid = $materiaid;

        return $this;
    }

    /**
     * Get materiaid
     *
     * @return \AppBundle\Entity\Materia
     */
    public function getMateriaid()
    {
        return $this->materiaid;
    }
}

