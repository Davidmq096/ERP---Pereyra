<?php

namespace AppBundle\Entity;

/**
 * CeFormaconfiguracionsubmateria
 */
class CeFormaconfiguracionsubmateria
{
    /**
     * @var integer
     */
    private $formacalificar;

    /**
     * @var integer
     */
    private $formacaptura;

    /**
     * @var integer
     */
    private $formaconfiguracionsubmateriaid;

    /**
     * @var \AppBundle\Entity\CeMateriaporplanestudios
     */
    private $materiaporplanestudioid;


    /**
     * Set formacalificar
     *
     * @param integer $formacalificar
     *
     * @return CeFormaconfiguracionsubmateria
     */
    public function setFormacalificar($formacalificar)
    {
        $this->formacalificar = $formacalificar;

        return $this;
    }

    /**
     * Get formacalificar
     *
     * @return integer
     */
    public function getFormacalificar()
    {
        return $this->formacalificar;
    }

    /**
     * Set formacaptura
     *
     * @param integer $formacaptura
     *
     * @return CeFormaconfiguracionsubmateria
     */
    public function setFormacaptura($formacaptura)
    {
        $this->formacaptura = $formacaptura;

        return $this;
    }

    /**
     * Get formacaptura
     *
     * @return integer
     */
    public function getFormacaptura()
    {
        return $this->formacaptura;
    }

    /**
     * Get formaconfiguracionsubmateriaid
     *
     * @return integer
     */
    public function getFormaconfiguracionsubmateriaid()
    {
        return $this->formaconfiguracionsubmateriaid;
    }

    /**
     * Set materiaporplanestudioid
     *
     * @param \AppBundle\Entity\CeMateriaporplanestudios $materiaporplanestudioid
     *
     * @return CeFormaconfiguracionsubmateria
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

