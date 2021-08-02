<?php

namespace AppBundle\Entity;

/**
 * Nacionalidadporpadresotutores
 */
class Nacionalidadporpadresotutores
{
    /**
     * @var integer
     */
    private $nacionalidadporpadresotutoresid;

    /**
     * @var \AppBundle\Entity\Nacionalidad
     */
    private $nacionalidadid;

    /**
     * @var \AppBundle\Entity\Padresotutores
     */
    private $padresotutoresid;


    /**
     * Get nacionalidadporpadresotutoresid
     *
     * @return integer
     */
    public function getNacionalidadporpadresotutoresid()
    {
        return $this->nacionalidadporpadresotutoresid;
    }

    /**
     * Set nacionalidadid
     *
     * @param \AppBundle\Entity\Nacionalidad $nacionalidadid
     *
     * @return Nacionalidadporpadresotutores
     */
    public function setNacionalidadid(\AppBundle\Entity\Nacionalidad $nacionalidadid = null)
    {
        $this->nacionalidadid = $nacionalidadid;

        return $this;
    }

    /**
     * Get nacionalidadid
     *
     * @return \AppBundle\Entity\Nacionalidad
     */
    public function getNacionalidadid()
    {
        return $this->nacionalidadid;
    }

    /**
     * Set padresotutoresid
     *
     * @param \AppBundle\Entity\Padresotutores $padresotutoresid
     *
     * @return Nacionalidadporpadresotutores
     */
    public function setPadresotutoresid(\AppBundle\Entity\Padresotutores $padresotutoresid = null)
    {
        $this->padresotutoresid = $padresotutoresid;

        return $this;
    }

    /**
     * Get padresotutoresid
     *
     * @return \AppBundle\Entity\Padresotutores
     */
    public function getPadresotutoresid()
    {
        return $this->padresotutoresid;
    }
}

