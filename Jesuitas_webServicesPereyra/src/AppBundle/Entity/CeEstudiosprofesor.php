<?php

namespace AppBundle\Entity;

/**
 * CeEstudiosprofesor
 */
class CeEstudiosprofesor
{
    /**
     * @var string
     */
    private $institucioneducativa;

    /**
     * @var string
     */
    private $cedulaprofesional;

    /**
     * @var string
     */
    private $titulo;

    /**
     * @var integer
     */
    private $estudioprofesorid;

    /**
     * @var \AppBundle\Entity\CeEstatusestudio
     */
    private $estatusestudioid;

    /**
     * @var \AppBundle\Entity\CeProfesor
     */
    private $profesorid;

    /**
     * @var \AppBundle\Entity\Escolaridad
     */
    private $escolaridadid;


    /**
     * Set institucioneducativa
     *
     * @param string $institucioneducativa
     *
     * @return CeEstudiosprofesor
     */
    public function setInstitucioneducativa($institucioneducativa)
    {
        $this->institucioneducativa = $institucioneducativa;

        return $this;
    }

    /**
     * Get institucioneducativa
     *
     * @return string
     */
    public function getInstitucioneducativa()
    {
        return $this->institucioneducativa;
    }

    /**
     * Set cedulaprofesional
     *
     * @param string $cedulaprofesional
     *
     * @return CeEstudiosprofesor
     */
    public function setCedulaprofesional($cedulaprofesional)
    {
        $this->cedulaprofesional = $cedulaprofesional;

        return $this;
    }

    /**
     * Get cedulaprofesional
     *
     * @return string
     */
    public function getCedulaprofesional()
    {
        return $this->cedulaprofesional;
    }

    /**
     * Set titulo
     *
     * @param string $titulo
     *
     * @return CeEstudiosprofesor
     */
    public function setTitulo($titulo)
    {
        $this->titulo = $titulo;

        return $this;
    }

    /**
     * Get titulo
     *
     * @return string
     */
    public function getTitulo()
    {
        return $this->titulo;
    }

    /**
     * Get estudioprofesorid
     *
     * @return integer
     */
    public function getEstudioprofesorid()
    {
        return $this->estudioprofesorid;
    }

    /**
     * Set estatusestudioid
     *
     * @param \AppBundle\Entity\CeEstatusestudio $estatusestudioid
     *
     * @return CeEstudiosprofesor
     */
    public function setEstatusestudioid(\AppBundle\Entity\CeEstatusestudio $estatusestudioid = null)
    {
        $this->estatusestudioid = $estatusestudioid;

        return $this;
    }

    /**
     * Get estatusestudioid
     *
     * @return \AppBundle\Entity\CeEstatusestudio
     */
    public function getEstatusestudioid()
    {
        return $this->estatusestudioid;
    }

    /**
     * Set profesorid
     *
     * @param \AppBundle\Entity\CeProfesor $profesorid
     *
     * @return CeEstudiosprofesor
     */
    public function setProfesorid(\AppBundle\Entity\CeProfesor $profesorid = null)
    {
        $this->profesorid = $profesorid;

        return $this;
    }

    /**
     * Get profesorid
     *
     * @return \AppBundle\Entity\CeProfesor
     */
    public function getProfesorid()
    {
        return $this->profesorid;
    }

    /**
     * Set escolaridadid
     *
     * @param \AppBundle\Entity\Escolaridad $escolaridadid
     *
     * @return CeEstudiosprofesor
     */
    public function setEscolaridadid(\AppBundle\Entity\Escolaridad $escolaridadid = null)
    {
        $this->escolaridadid = $escolaridadid;

        return $this;
    }

    /**
     * Get escolaridadid
     *
     * @return \AppBundle\Entity\Escolaridad
     */
    public function getEscolaridadid()
    {
        return $this->escolaridadid;
    }
}

