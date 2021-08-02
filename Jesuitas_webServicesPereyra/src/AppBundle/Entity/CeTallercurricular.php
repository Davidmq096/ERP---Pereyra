<?php

namespace AppBundle\Entity;

/**
 * CeTallercurricular
 */
class CeTallercurricular
{
    /**
     * @var string
     */
    private $nombre;

    /**
     * @var integer
     */
    private $cupo;

    /**
     * @var integer
     */
    private $cupomaxmasculino;

    /**
     * @var integer
     */
    private $cupomaxfemenino;

    /**
     * @var boolean
     */
    private $inscripcionweb;

    /**
     * @var string
     */
    private $descripcion;

    /**
     * @var integer
     */
    private $orden;

    /**
     * @var integer
     */
    private $tallercurricularid;

    /**
     * @var \AppBundle\Entity\CeProfesor
     */
    private $cotitularid;

    /**
     * @var \AppBundle\Entity\CeProfesor
     */
    private $suplenteid;

    /**
     * @var \AppBundle\Entity\CeClasificadorparaescolares
     */
    private $clasificadorparaescolaresid;

    /**
     * @var \AppBundle\Entity\CeProfesor
     */
    private $profesorid;

    /**
     * @var \AppBundle\Entity\CeTallercurricular
     */
    private $talleranteriorid;

    /**
     * @var \AppBundle\Entity\Ciclo
     */
    private $cicloid;


    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return CeTallercurricular
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
     * Set cupo
     *
     * @param integer $cupo
     *
     * @return CeTallercurricular
     */
    public function setCupo($cupo)
    {
        $this->cupo = $cupo;

        return $this;
    }

    /**
     * Get cupo
     *
     * @return integer
     */
    public function getCupo()
    {
        return $this->cupo;
    }

    /**
     * Set cupomaxmasculino
     *
     * @param integer $cupomaxmasculino
     *
     * @return CeTallercurricular
     */
    public function setCupomaxmasculino($cupomaxmasculino)
    {
        $this->cupomaxmasculino = $cupomaxmasculino;

        return $this;
    }

    /**
     * Get cupomaxmasculino
     *
     * @return integer
     */
    public function getCupomaxmasculino()
    {
        return $this->cupomaxmasculino;
    }

    /**
     * Set cupomaxfemenino
     *
     * @param integer $cupomaxfemenino
     *
     * @return CeTallercurricular
     */
    public function setCupomaxfemenino($cupomaxfemenino)
    {
        $this->cupomaxfemenino = $cupomaxfemenino;

        return $this;
    }

    /**
     * Get cupomaxfemenino
     *
     * @return integer
     */
    public function getCupomaxfemenino()
    {
        return $this->cupomaxfemenino;
    }

    /**
     * Set inscripcionweb
     *
     * @param boolean $inscripcionweb
     *
     * @return CeTallercurricular
     */
    public function setInscripcionweb($inscripcionweb)
    {
        $this->inscripcionweb = $inscripcionweb;

        return $this;
    }

    /**
     * Get inscripcionweb
     *
     * @return boolean
     */
    public function getInscripcionweb()
    {
        return $this->inscripcionweb;
    }

    /**
     * Set descripcion
     *
     * @param string $descripcion
     *
     * @return CeTallercurricular
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
     * Set orden
     *
     * @param integer $orden
     *
     * @return CeTallercurricular
     */
    public function setOrden($orden)
    {
        $this->orden = $orden;

        return $this;
    }

    /**
     * Get orden
     *
     * @return integer
     */
    public function getOrden()
    {
        return $this->orden;
    }

    /**
     * Get tallercurricularid
     *
     * @return integer
     */
    public function getTallercurricularid()
    {
        return $this->tallercurricularid;
    }

    /**
     * Set cotitularid
     *
     * @param \AppBundle\Entity\CeProfesor $cotitularid
     *
     * @return CeTallercurricular
     */
    public function setCotitularid(\AppBundle\Entity\CeProfesor $cotitularid = null)
    {
        $this->cotitularid = $cotitularid;

        return $this;
    }

    /**
     * Get cotitularid
     *
     * @return \AppBundle\Entity\CeProfesor
     */
    public function getCotitularid()
    {
        return $this->cotitularid;
    }

    /**
     * Set suplenteid
     *
     * @param \AppBundle\Entity\CeProfesor $suplenteid
     *
     * @return CeTallercurricular
     */
    public function setSuplenteid(\AppBundle\Entity\CeProfesor $suplenteid = null)
    {
        $this->suplenteid = $suplenteid;

        return $this;
    }

    /**
     * Get suplenteid
     *
     * @return \AppBundle\Entity\CeProfesor
     */
    public function getSuplenteid()
    {
        return $this->suplenteid;
    }

    /**
     * Set clasificadorparaescolaresid
     *
     * @param \AppBundle\Entity\CeClasificadorparaescolares $clasificadorparaescolaresid
     *
     * @return CeTallercurricular
     */
    public function setClasificadorparaescolaresid(\AppBundle\Entity\CeClasificadorparaescolares $clasificadorparaescolaresid = null)
    {
        $this->clasificadorparaescolaresid = $clasificadorparaescolaresid;

        return $this;
    }

    /**
     * Get clasificadorparaescolaresid
     *
     * @return \AppBundle\Entity\CeClasificadorparaescolares
     */
    public function getClasificadorparaescolaresid()
    {
        return $this->clasificadorparaescolaresid;
    }

    /**
     * Set profesorid
     *
     * @param \AppBundle\Entity\CeProfesor $profesorid
     *
     * @return CeTallercurricular
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
     * Set talleranteriorid
     *
     * @param \AppBundle\Entity\CeTallercurricular $talleranteriorid
     *
     * @return CeTallercurricular
     */
    public function setTalleranteriorid(\AppBundle\Entity\CeTallercurricular $talleranteriorid = null)
    {
        $this->talleranteriorid = $talleranteriorid;

        return $this;
    }

    /**
     * Get talleranteriorid
     *
     * @return \AppBundle\Entity\CeTallercurricular
     */
    public function getTalleranteriorid()
    {
        return $this->talleranteriorid;
    }

    /**
     * Set cicloid
     *
     * @param \AppBundle\Entity\Ciclo $cicloid
     *
     * @return CeTallercurricular
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
}

