<?php

namespace AppBundle\Entity;

/**
 * CeTallerextracurricular
 */
class CeTallerextracurricular
{
    /**
     * @var string
     */
    private $nombre;

    /**
     * @var integer
     */
    private $tipoinscripcion;

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
     * @var integer
     */
    private $anonacimientomin;

    /**
     * @var integer
     */
    private $anonacimientomax;

    /**
     * @var string
     */
    private $colorplayera;

    /**
     * @var string
     */
    private $descripcion;

    /**
     * @var integer
     */
    private $activo;

    /**
     * @var string
     */
    private $formato;

    /**
     * @var integer
     */
    private $tallerextracurricularid;

    /**
     * @var \AppBundle\Entity\CeProfesor
     */
    private $profesorid;

    /**
     * @var \AppBundle\Entity\CeTallerextrareglamento
     */
    private $reglamentoid;

    /**
     * @var \AppBundle\Entity\Ciclo
     */
    private $cicloid;

    /**
     * @var \AppBundle\Entity\Lugar
     */
    private $lugarid;

    /**
     * @var \AppBundle\Entity\Usuario
     */
    private $usuarioid;


    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return CeTallerextracurricular
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
     * Set tipoinscripcion
     *
     * @param integer $tipoinscripcion
     *
     * @return CeTallerextracurricular
     */
    public function setTipoinscripcion($tipoinscripcion)
    {
        $this->tipoinscripcion = $tipoinscripcion;

        return $this;
    }

    /**
     * Get tipoinscripcion
     *
     * @return integer
     */
    public function getTipoinscripcion()
    {
        return $this->tipoinscripcion;
    }

    /**
     * Set cupo
     *
     * @param integer $cupo
     *
     * @return CeTallerextracurricular
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
     * @return CeTallerextracurricular
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
     * @return CeTallerextracurricular
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
     * Set anonacimientomin
     *
     * @param integer $anonacimientomin
     *
     * @return CeTallerextracurricular
     */
    public function setAnonacimientomin($anonacimientomin)
    {
        $this->anonacimientomin = $anonacimientomin;

        return $this;
    }

    /**
     * Get anonacimientomin
     *
     * @return integer
     */
    public function getAnonacimientomin()
    {
        return $this->anonacimientomin;
    }

    /**
     * Set anonacimientomax
     *
     * @param integer $anonacimientomax
     *
     * @return CeTallerextracurricular
     */
    public function setAnonacimientomax($anonacimientomax)
    {
        $this->anonacimientomax = $anonacimientomax;

        return $this;
    }

    /**
     * Get anonacimientomax
     *
     * @return integer
     */
    public function getAnonacimientomax()
    {
        return $this->anonacimientomax;
    }

    /**
     * Set colorplayera
     *
     * @param string $colorplayera
     *
     * @return CeTallerextracurricular
     */
    public function setColorplayera($colorplayera)
    {
        $this->colorplayera = $colorplayera;

        return $this;
    }

    /**
     * Get colorplayera
     *
     * @return string
     */
    public function getColorplayera()
    {
        return $this->colorplayera;
    }

    /**
     * Set descripcion
     *
     * @param string $descripcion
     *
     * @return CeTallerextracurricular
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
     * @param integer $activo
     *
     * @return CeTallerextracurricular
     */
    public function setActivo($activo)
    {
        $this->activo = $activo;

        return $this;
    }

    /**
     * Get activo
     *
     * @return integer
     */
    public function getActivo()
    {
        return $this->activo;
    }

    /**
     * Set formato
     *
     * @param string $formato
     *
     * @return CeTallerextracurricular
     */
    public function setFormato($formato)
    {
        $this->formato = $formato;

        return $this;
    }

    /**
     * Get formato
     *
     * @return string
     */
    public function getFormato()
    {
        return $this->formato;
    }

    /**
     * Get tallerextracurricularid
     *
     * @return integer
     */
    public function getTallerextracurricularid()
    {
        return $this->tallerextracurricularid;
    }

    /**
     * Set profesorid
     *
     * @param \AppBundle\Entity\CeProfesor $profesorid
     *
     * @return CeTallerextracurricular
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
     * Set reglamentoid
     *
     * @param \AppBundle\Entity\CeTallerextrareglamento $reglamentoid
     *
     * @return CeTallerextracurricular
     */
    public function setReglamentoid(\AppBundle\Entity\CeTallerextrareglamento $reglamentoid = null)
    {
        $this->reglamentoid = $reglamentoid;

        return $this;
    }

    /**
     * Get reglamentoid
     *
     * @return \AppBundle\Entity\CeTallerextrareglamento
     */
    public function getReglamentoid()
    {
        return $this->reglamentoid;
    }

    /**
     * Set cicloid
     *
     * @param \AppBundle\Entity\Ciclo $cicloid
     *
     * @return CeTallerextracurricular
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
     * Set lugarid
     *
     * @param \AppBundle\Entity\Lugar $lugarid
     *
     * @return CeTallerextracurricular
     */
    public function setLugarid(\AppBundle\Entity\Lugar $lugarid = null)
    {
        $this->lugarid = $lugarid;

        return $this;
    }

    /**
     * Get lugarid
     *
     * @return \AppBundle\Entity\Lugar
     */
    public function getLugarid()
    {
        return $this->lugarid;
    }

    /**
     * Set usuarioid
     *
     * @param \AppBundle\Entity\Usuario $usuarioid
     *
     * @return CeTallerextracurricular
     */
    public function setUsuarioid(\AppBundle\Entity\Usuario $usuarioid = null)
    {
        $this->usuarioid = $usuarioid;

        return $this;
    }

    /**
     * Get usuarioid
     *
     * @return \AppBundle\Entity\Usuario
     */
    public function getUsuarioid()
    {
        return $this->usuarioid;
    }
}

