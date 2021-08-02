<?php

namespace AppBundle\Entity;

/**
 * CeAlumnocicloportaller
 */
class CeAlumnocicloportaller
{
    /**
     * @var boolean
     */
    private $vigente;

    /**
     * @var integer
     */
    private $numerolista;

    /**
     * @var integer
     */
    private $alumnocicloportallerid;

    /**
     * @var \AppBundle\Entity\CeAlumnoporciclo
     */
    private $alumnoporcicloid;

    /**
     * @var \AppBundle\Entity\CeClasificadorparaescolares
     */
    private $clasificadorparaescolarid;

    /**
     * @var \AppBundle\Entity\CeTallercurricular
     */
    private $tallercurricularid;


    /**
     * Set vigente
     *
     * @param boolean $vigente
     *
     * @return CeAlumnocicloportaller
     */
    public function setVigente($vigente)
    {
        $this->vigente = $vigente;

        return $this;
    }

    /**
     * Get vigente
     *
     * @return boolean
     */
    public function getVigente()
    {
        return $this->vigente;
    }

    /**
     * Set numerolista
     *
     * @param integer $numerolista
     *
     * @return CeAlumnocicloportaller
     */
    public function setNumerolista($numerolista)
    {
        $this->numerolista = $numerolista;

        return $this;
    }

    /**
     * Get numerolista
     *
     * @return integer
     */
    public function getNumerolista()
    {
        return $this->numerolista;
    }

    /**
     * Get alumnocicloportallerid
     *
     * @return integer
     */
    public function getAlumnocicloportallerid()
    {
        return $this->alumnocicloportallerid;
    }

    /**
     * Set alumnoporcicloid
     *
     * @param \AppBundle\Entity\CeAlumnoporciclo $alumnoporcicloid
     *
     * @return CeAlumnocicloportaller
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
     * Set clasificadorparaescolarid
     *
     * @param \AppBundle\Entity\CeClasificadorparaescolares $clasificadorparaescolarid
     *
     * @return CeAlumnocicloportaller
     */
    public function setClasificadorparaescolarid(\AppBundle\Entity\CeClasificadorparaescolares $clasificadorparaescolarid = null)
    {
        $this->clasificadorparaescolarid = $clasificadorparaescolarid;

        return $this;
    }

    /**
     * Get clasificadorparaescolarid
     *
     * @return \AppBundle\Entity\CeClasificadorparaescolares
     */
    public function getClasificadorparaescolarid()
    {
        return $this->clasificadorparaescolarid;
    }

    /**
     * Set tallercurricularid
     *
     * @param \AppBundle\Entity\CeTallercurricular $tallercurricularid
     *
     * @return CeAlumnocicloportaller
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

