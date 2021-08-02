<?php

namespace AppBundle\Entity;

/**
 * CeAlumnociclopreregistroportaller
 */
class CeAlumnociclopreregistroportaller
{
    /**
     * @var \DateTime
     */
    private $fechapreregistro;

    /**
     * @var integer
     */
    private $prioridad;

    /**
     * @var integer
     */
    private $alumnociclopreregistroportallerid;

    /**
     * @var \AppBundle\Entity\CeAlumnoporciclo
     */
    private $alumnoporcicloid;

    /**
     * @var \AppBundle\Entity\CeClasificadorparaescolares
     */
    private $clasificadorparaescolaresid;

    /**
     * @var \AppBundle\Entity\CeTallercurricular
     */
    private $tallercurricularid;


    /**
     * Set fechapreregistro
     *
     * @param \DateTime $fechapreregistro
     *
     * @return CeAlumnociclopreregistroportaller
     */
    public function setFechapreregistro($fechapreregistro)
    {
        $this->fechapreregistro = $fechapreregistro;

        return $this;
    }

    /**
     * Get fechapreregistro
     *
     * @return \DateTime
     */
    public function getFechapreregistro()
    {
        return $this->fechapreregistro;
    }

    /**
     * Set prioridad
     *
     * @param integer $prioridad
     *
     * @return CeAlumnociclopreregistroportaller
     */
    public function setPrioridad($prioridad)
    {
        $this->prioridad = $prioridad;

        return $this;
    }

    /**
     * Get prioridad
     *
     * @return integer
     */
    public function getPrioridad()
    {
        return $this->prioridad;
    }

    /**
     * Get alumnociclopreregistroportallerid
     *
     * @return integer
     */
    public function getAlumnociclopreregistroportallerid()
    {
        return $this->alumnociclopreregistroportallerid;
    }

    /**
     * Set alumnoporcicloid
     *
     * @param \AppBundle\Entity\CeAlumnoporciclo $alumnoporcicloid
     *
     * @return CeAlumnociclopreregistroportaller
     */
    public function setAlumnoporcicloid(\AppBundle\Entity\CeAlumnoporciclo $alumnoporcicloid = null)
    {
        $this->alumnoporcicloid = $alumnoporcicloid;

        return $this;
    }

    /**
     * Get alumnoporcicloid
     *
     * @return \AppBundle\Entity\CeAlumnoporciclo
     */
    public function getAlumnoporcicloid()
    {
        return $this->alumnoporcicloid;
    }

    /**
     * Set clasificadorparaescolaresid
     *
     * @param \AppBundle\Entity\CeClasificadorparaescolares $clasificadorparaescolaresid
     *
     * @return CeAlumnociclopreregistroportaller
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
     * Set tallercurricularid
     *
     * @param \AppBundle\Entity\CeTallercurricular $tallercurricularid
     *
     * @return CeAlumnociclopreregistroportaller
     */
    public function setTallercurricularid(\AppBundle\Entity\CeTallercurricular $tallercurricularid = null)
    {
        $this->tallercurricularid = $tallercurricularid;

        return $this;
    }

    /**
     * Get tallercurricularid
     *
     * @return \AppBundle\Entity\CeTallercurricular
     */
    public function getTallercurricularid()
    {
        return $this->tallercurricularid;
    }
}

