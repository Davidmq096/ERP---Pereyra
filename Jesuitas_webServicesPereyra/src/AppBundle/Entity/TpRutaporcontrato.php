<?php

namespace AppBundle\Entity;

/**
 * TpRutaporcontrato
 */
class TpRutaporcontrato
{
    /**
     * @var integer
     */
    private $rutaporcontratoid;

    /**
     * @var \AppBundle\Entity\TpRuta
     */
    private $rutaid;

    /**
     * @var \AppBundle\Entity\TpContrato
     */
    private $contratoid;


    /**
     * Get rutaporcontratoid
     *
     * @return integer
     */
    public function getRutaporcontratoid()
    {
        return $this->rutaporcontratoid;
    }

    /**
     * Set rutaid
     *
     * @param \AppBundle\Entity\TpRuta $rutaid
     *
     * @return TpRutaporcontrato
     */
    public function setRutaid(\AppBundle\Entity\TpRuta $rutaid = null)
    {
        $this->rutaid = $rutaid;

        return $this;
    }

    /**
     * Get rutaid
     *
     * @return \AppBundle\Entity\TpRuta
     */
    public function getRutaid()
    {
        return $this->rutaid;
    }

    /**
     * Set contratoid
     *
     * @param \AppBundle\Entity\TpContrato $contratoid
     *
     * @return TpRutaporcontrato
     */
    public function setContratoid(\AppBundle\Entity\TpContrato $contratoid = null)
    {
        $this->contratoid = $contratoid;

        return $this;
    }

    /**
     * Get contratoid
     *
     * @return \AppBundle\Entity\TpContrato
     */
    public function getContratoid()
    {
        return $this->contratoid;
    }
}

