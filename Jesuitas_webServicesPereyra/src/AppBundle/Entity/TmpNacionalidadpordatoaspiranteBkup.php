<?php

namespace AppBundle\Entity;

/**
 * TmpNacionalidadpordatoaspiranteBkup
 */
class TmpNacionalidadpordatoaspiranteBkup
{
    /**
     * @var integer
     */
    private $datoaspiranteid;

    /**
     * @var integer
     */
    private $nacionalidad;

    /**
     * @var integer
     */
    private $nacionalidadpordatoaspiranteid;


    /**
     * Set datoaspiranteid
     *
     * @param integer $datoaspiranteid
     *
     * @return TmpNacionalidadpordatoaspiranteBkup
     */
    public function setDatoaspiranteid($datoaspiranteid)
    {
        $this->datoaspiranteid = $datoaspiranteid;

        return $this;
    }

    /**
     * Get datoaspiranteid
     *
     * @return integer
     */
    public function getDatoaspiranteid()
    {
        return $this->datoaspiranteid;
    }

    /**
     * Set nacionalidad
     *
     * @param integer $nacionalidad
     *
     * @return TmpNacionalidadpordatoaspiranteBkup
     */
    public function setNacionalidad($nacionalidad)
    {
        $this->nacionalidad = $nacionalidad;

        return $this;
    }

    /**
     * Get nacionalidad
     *
     * @return integer
     */
    public function getNacionalidad()
    {
        return $this->nacionalidad;
    }

    /**
     * Get nacionalidadpordatoaspiranteid
     *
     * @return integer
     */
    public function getNacionalidadpordatoaspiranteid()
    {
        return $this->nacionalidadpordatoaspiranteid;
    }
}

