<?php

namespace AppBundle\Entity;

/**
 * CePadresotutoresnacionalidad
 */
class CePadresotutoresnacionalidad
{
    /**
     * @var integer
     */
    private $padresotutoresnacionalidad;

    /**
     * @var \AppBundle\Entity\Nacionalidad
     */
    private $nacionalidadid;

    /**
     * @var \AppBundle\Entity\CePadresotutores
     */
    private $padresotutoresid;


    /**
     * Get padresotutoresnacionalidad
     *
     * @return integer
     */
    public function getPadresotutoresnacionalidad()
    {
        return $this->padresotutoresnacionalidad;
    }

    /**
     * Set nacionalidadid
     *
     * @param \AppBundle\Entity\Nacionalidad $nacionalidadid
     *
     * @return CePadresotutoresnacionalidad
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
     * @param \AppBundle\Entity\CePadresotutores $padresotutoresid
     *
     * @return CePadresotutoresnacionalidad
     */
    public function setPadresotutoresid(\AppBundle\Entity\CePadresotutores $padresotutoresid = null)
    {
        $this->padresotutoresid = $padresotutoresid;

        return $this;
    }

    /**
     * Get padresotutoresid
     *
     * @return \AppBundle\Entity\CePadresotutores
     */
    public function getPadresotutoresid()
    {
        return $this->padresotutoresid;
    }
}

