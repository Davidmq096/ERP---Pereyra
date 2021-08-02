<?php

namespace AppBundle\Entity;

/**
 * CeMateriaporconductacalificacion
 */
class CeMateriaporconductacalificacion
{
    /**
     * @var integer
     */
    private $materiaporconductacalificacionid;

    /**
     * @var \AppBundle\Entity\CeConductacalificacion
     */
    private $conductacalificacionid;

    /**
     * @var \AppBundle\Entity\Materia
     */
    private $materiaid;


    /**
     * Get materiaporconductacalificacionid
     *
     * @return integer
     */
    public function getMateriaporconductacalificacionid()
    {
        return $this->materiaporconductacalificacionid;
    }

    /**
     * Set conductacalificacionid
     *
     * @param \AppBundle\Entity\CeConductacalificacion $conductacalificacionid
     *
     * @return CeMateriaporconductacalificacion
     */
    public function setConductacalificacionid(\AppBundle\Entity\CeConductacalificacion $conductacalificacionid = null)
    {
        $this->conductacalificacionid = $conductacalificacionid;

        return $this;
    }

    /**
     * Get conductacalificacionid
     *
     * @return \AppBundle\Entity\CeConductacalificacion
     */
    public function getConductacalificacionid()
    {
        return $this->conductacalificacionid;
    }

    /**
     * Set materiaid
     *
     * @param \AppBundle\Entity\Materia $materiaid
     *
     * @return CeMateriaporconductacalificacion
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

