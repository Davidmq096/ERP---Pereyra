<?php

namespace AppBundle\Entity;

/**
 * CeAprendizajepormateriaporsubmateria
 */
class CeAprendizajepormateriaporsubmateria
{
    /**
     * @var integer
     */
    private $aprendizajeesperadopormaterisubmateriaid;

    /**
     * @var \AppBundle\Entity\CeAprendizajeesperadopormateria
     */
    private $aprendizajepormateriaid;

    /**
     * @var \AppBundle\Entity\Materia
     */
    private $materiaid;


    /**
     * Get aprendizajeesperadopormaterisubmateriaid
     *
     * @return integer
     */
    public function getAprendizajeesperadopormaterisubmateriaid()
    {
        return $this->aprendizajeesperadopormaterisubmateriaid;
    }

    /**
     * Set aprendizajepormateriaid
     *
     * @param \AppBundle\Entity\CeAprendizajeesperadopormateria $aprendizajepormateriaid
     *
     * @return CeAprendizajepormateriaporsubmateria
     */
    public function setAprendizajepormateriaid(\AppBundle\Entity\CeAprendizajeesperadopormateria $aprendizajepormateriaid = null)
    {
        $this->aprendizajepormateriaid = $aprendizajepormateriaid;

        return $this;
    }

    /**
     * Get aprendizajepormateriaid
     *
     * @return \AppBundle\Entity\CeAprendizajeesperadopormateria
     */
    public function getAprendizajepormateriaid()
    {
        return $this->aprendizajepormateriaid;
    }

    /**
     * Set materiaid
     *
     * @param \AppBundle\Entity\Materia $materiaid
     *
     * @return CeAprendizajepormateriaporsubmateria
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

