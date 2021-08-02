<?php

namespace AppBundle\Entity;

/**
 * Nacionalidadpordatoaspirante
 */
class Nacionalidadpordatoaspirante
{
    /**
     * @var integer
     */
    private $nacionalidadpordatoaspiranteid;

    /**
     * @var \AppBundle\Entity\Datoaspirante
     */
    private $datoaspiranteid;

    /**
     * @var \AppBundle\Entity\Nacionalidad
     */
    private $nacionalidad;


    /**
     * Get nacionalidadpordatoaspiranteid
     *
     * @return integer
     */
    public function getNacionalidadpordatoaspiranteid()
    {
        return $this->nacionalidadpordatoaspiranteid;
    }

    /**
     * Set datoaspiranteid
     *
     * @param \AppBundle\Entity\Datoaspirante $datoaspiranteid
     *
     * @return Nacionalidadpordatoaspirante
     */
    public function setDatoaspiranteid(\AppBundle\Entity\Datoaspirante $datoaspiranteid = null)
    {
        $this->datoaspiranteid = $datoaspiranteid;

        return $this;
    }

    /**
     * Get datoaspiranteid
     *
     * @return \AppBundle\Entity\Datoaspirante
     */
    public function getDatoaspiranteid()
    {
        return $this->datoaspiranteid;
    }

    /**
     * Set nacionalidad
     *
     * @param \AppBundle\Entity\Nacionalidad $nacionalidad
     *
     * @return Nacionalidadpordatoaspirante
     */
    public function setNacionalidad(\AppBundle\Entity\Nacionalidad $nacionalidad = null)
    {
        $this->nacionalidad = $nacionalidad;

        return $this;
    }

    /**
     * Get nacionalidad
     *
     * @return \AppBundle\Entity\Nacionalidad
     */
    public function getNacionalidad()
    {
        return $this->nacionalidad;
    }
}

