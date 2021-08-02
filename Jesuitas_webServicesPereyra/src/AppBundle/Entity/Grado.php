<?php

namespace AppBundle\Entity;

/**
 * Grado
 */
class Grado
{
    /**
     * @var string
     */
    private $grado;

    /**
     * @var boolean
     */
    private $activo = '1';

    /**
     * @var boolean
     */
    private $areaacademica = '0';

    /**
     * @var integer
     */
    private $gradoid;

    /**
     * @var \AppBundle\Entity\CeSemestre
     */
    private $semestreid;

    /**
     * @var \AppBundle\Entity\Nivel
     */
    private $nivelid;


    /**
     * Set grado
     *
     * @param string $grado
     *
     * @return Grado
     */
    public function setGrado($grado)
    {
        $this->grado = $grado;

        return $this;
    }

    /**
     * Get grado
     *
     * @return string
     */
    public function getGrado()
    {
        return $this->grado;
    }

    /**
     * Set activo
     *
     * @param boolean $activo
     *
     * @return Grado
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
     * Set areaacademica
     *
     * @param boolean $areaacademica
     *
     * @return Grado
     */
    public function setAreaacademica($areaacademica)
    {
        $this->areaacademica = $areaacademica;

        return $this;
    }

    /**
     * Get areaacademica
     *
     * @return boolean
     */
    public function getAreaacademica()
    {
        return $this->areaacademica;
    }

    /**
     * Get gradoid
     *
     * @return integer
     */
    public function getGradoid()
    {
        return $this->gradoid;
    }

    /**
     * Set semestreid
     *
     * @param \AppBundle\Entity\CeSemestre $semestreid
     *
     * @return Grado
     */
    public function setSemestreid(\AppBundle\Entity\CeSemestre $semestreid = null)
    {
        $this->semestreid = $semestreid;

        return $this;
    }

    /**
     * Get semestreid
     *
     * @return \AppBundle\Entity\CeSemestre
     */
    public function getSemestreid()
    {
        return $this->semestreid;
    }

    /**
     * Set nivelid
     *
     * @param \AppBundle\Entity\Nivel $nivelid
     *
     * @return Grado
     */
    public function setNivelid(\AppBundle\Entity\Nivel $nivelid = null)
    {
        $this->nivelid = $nivelid;

        return $this;
    }

    /**
     * Get nivelid
     *
     * @return \AppBundle\Entity\Nivel
     */
    public function getNivelid()
    {
        return $this->nivelid;
    }
}

