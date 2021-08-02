<?php

namespace AppBundle\Entity;

/**
 * CeAprendizajeesperadopormateria
 */
class CeAprendizajeesperadopormateria
{
    /**
     * @var integer
     */
    private $aprendizajeesperadopormateriaid;

    /**
     * @var \AppBundle\Entity\CeAprendizajeesperado
     */
    private $aprendizajesesperadoid;

    /**
     * @var \AppBundle\Entity\CeMateriaporplanestudios
     */
    private $materiaporplanestudioid;


    /**
     * Get aprendizajeesperadopormateriaid
     *
     * @return integer
     */
    public function getAprendizajeesperadopormateriaid()
    {
        return $this->aprendizajeesperadopormateriaid;
    }

    /**
     * Set aprendizajesesperadoid
     *
     * @param \AppBundle\Entity\CeAprendizajeesperado $aprendizajesesperadoid
     *
     * @return CeAprendizajeesperadopormateria
     */
    public function setAprendizajesesperadoid(\AppBundle\Entity\CeAprendizajeesperado $aprendizajesesperadoid = null)
    {
        $this->aprendizajesesperadoid = $aprendizajesesperadoid;

        return $this;
    }

    /**
     * Get aprendizajesesperadoid
     *
     * @return \AppBundle\Entity\CeAprendizajeesperado
     */
    public function getAprendizajesesperadoid()
    {
        return $this->aprendizajesesperadoid;
    }

    /**
     * Set materiaporplanestudioid
     *
     * @param \AppBundle\Entity\CeMateriaporplanestudios $materiaporplanestudioid
     *
     * @return CeAprendizajeesperadopormateria
     */
    public function setMateriaporplanestudioid(\AppBundle\Entity\CeMateriaporplanestudios $materiaporplanestudioid = null)
    {
        $this->materiaporplanestudioid = $materiaporplanestudioid;

        return $this;
    }

    /**
     * Get materiaporplanestudioid
     *
     * @return \AppBundle\Entity\CeMateriaporplanestudios
     */
    public function getMateriaporplanestudioid()
    {
        return $this->materiaporplanestudioid;
    }
}

