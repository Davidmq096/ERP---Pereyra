<?php

namespace AppBundle\Entity;

/**
 * BrExamen
 */
class BrExamen
{
    /**
     * @var string
     */
    private $clave;

    /**
     * @var string
     */
    private $nombre;

    /**
     * @var string
     */
    private $descripcion;

    /**
     * @var boolean
     */
    private $activo;

    /**
     * @var integer
     */
    private $examenid;

    /**
     * @var \AppBundle\Entity\CeAreaacademica
     */
    private $areaid;

    /**
     * @var \AppBundle\Entity\Ciclo
     */
    private $cicloid;

    /**
     * @var \AppBundle\Entity\BrExamenpresentacion
     */
    private $examenpresentacionid;

    /**
     * @var \AppBundle\Entity\Grado
     */
    private $gradoid;

    /**
     * @var \AppBundle\Entity\Materia
     */
    private $materiaid;

    /**
     * @var \AppBundle\Entity\BrSistemacalificacion
     */
    private $sistemacalificacionid;

    /**
     * @var \AppBundle\Entity\BrTipoexamen
     */
    private $tipoexamenid;


    /**
     * Set clave
     *
     * @param string $clave
     *
     * @return BrExamen
     */
    public function setClave($clave)
    {
        $this->clave = $clave;

        return $this;
    }

    /**
     * Get clave
     *
     * @return string
     */
    public function getClave()
    {
        return $this->clave;
    }

    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return BrExamen
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
     * @return BrExamen
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
     * Set activo
     *
     * @param boolean $activo
     *
     * @return BrExamen
     */
    public function setActivo($activo)
    {
        $this->activo = $activo;

        return $this;
    }

    /**
     * Get activo
     *
     * @return boolean
     */
    public function getActivo()
    {
        return $this->activo;
    }

    /**
     * Get examenid
     *
     * @return integer
     */
    public function getExamenid()
    {
        return $this->examenid;
    }

    /**
     * Set areaid
     *
     * @param \AppBundle\Entity\CeAreaacademica $areaid
     *
     * @return BrExamen
     */
    public function setAreaid(\AppBundle\Entity\CeAreaacademica $areaid = null)
    {
        $this->areaid = $areaid;

        return $this;
    }

    /**
     * Get areaid
     *
     * @return \AppBundle\Entity\CeAreaacademica
     */
    public function getAreaid()
    {
        return $this->areaid;
    }

    /**
     * Set cicloid
     *
     * @param \AppBundle\Entity\Ciclo $cicloid
     *
     * @return BrExamen
     */
    public function setCicloid(\AppBundle\Entity\Ciclo $cicloid = null)
    {
        $this->cicloid = $cicloid;

        return $this;
    }

    /**
     * Get cicloid
     *
     * @return \AppBundle\Entity\Ciclo
     */
    public function getCicloid()
    {
        return $this->cicloid;
    }

    /**
     * Set examenpresentacionid
     *
     * @param \AppBundle\Entity\BrExamenpresentacion $examenpresentacionid
     *
     * @return BrExamen
     */
    public function setExamenpresentacionid(\AppBundle\Entity\BrExamenpresentacion $examenpresentacionid = null)
    {
        $this->examenpresentacionid = $examenpresentacionid;

        return $this;
    }

    /**
     * Get examenpresentacionid
     *
     * @return \AppBundle\Entity\BrExamenpresentacion
     */
    public function getExamenpresentacionid()
    {
        return $this->examenpresentacionid;
    }

    /**
     * Set gradoid
     *
     * @param \AppBundle\Entity\Grado $gradoid
     *
     * @return BrExamen
     */
    public function setGradoid(\AppBundle\Entity\Grado $gradoid = null)
    {
        $this->gradoid = $gradoid;

        return $this;
    }

    /**
     * Get gradoid
     *
     * @return \AppBundle\Entity\Grado
     */
    public function getGradoid()
    {
        return $this->gradoid;
    }

    /**
     * Set materiaid
     *
     * @param \AppBundle\Entity\Materia $materiaid
     *
     * @return BrExamen
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

    /**
     * Set sistemacalificacionid
     *
     * @param \AppBundle\Entity\BrSistemacalificacion $sistemacalificacionid
     *
     * @return BrExamen
     */
    public function setSistemacalificacionid(\AppBundle\Entity\BrSistemacalificacion $sistemacalificacionid = null)
    {
        $this->sistemacalificacionid = $sistemacalificacionid;

        return $this;
    }

    /**
     * Get sistemacalificacionid
     *
     * @return \AppBundle\Entity\BrSistemacalificacion
     */
    public function getSistemacalificacionid()
    {
        return $this->sistemacalificacionid;
    }

    /**
     * Set tipoexamenid
     *
     * @param \AppBundle\Entity\BrTipoexamen $tipoexamenid
     *
     * @return BrExamen
     */
    public function setTipoexamenid(\AppBundle\Entity\BrTipoexamen $tipoexamenid = null)
    {
        $this->tipoexamenid = $tipoexamenid;

        return $this;
    }

    /**
     * Get tipoexamenid
     *
     * @return \AppBundle\Entity\BrTipoexamen
     */
    public function getTipoexamenid()
    {
        return $this->tipoexamenid;
    }
}

