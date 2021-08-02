<?php

namespace AppBundle\Entity;

/**
 * CeNacionalidadporalumno
 */
class CeNacionalidadporalumno
{
    /**
     * @var integer
     */
    private $nacionalidadporalumnoid;

    /**
     * @var \AppBundle\Entity\CeAlumno
     */
    private $alumnoid;

    /**
     * @var \AppBundle\Entity\Nacionalidad
     */
    private $nacionalidadid;


    /**
     * Get nacionalidadporalumnoid
     *
     * @return integer
     */
    public function getNacionalidadporalumnoid()
    {
        return $this->nacionalidadporalumnoid;
    }

    /**
     * Set alumnoid
     *
     * @param \AppBundle\Entity\CeAlumno $alumnoid
     *
     * @return CeNacionalidadporalumno
     */
    public function setAlumnoid(\AppBundle\Entity\CeAlumno $alumnoid = null)
    {
        $this->alumnoid = $alumnoid;

        return $this;
    }

    /**
     * Get alumnoid
     *
     * @return \AppBundle\Entity\CeAlumno
     */
    public function getAlumnoid()
    {
        return $this->alumnoid;
    }

    /**
     * Set nacionalidadid
     *
     * @param \AppBundle\Entity\Nacionalidad $nacionalidadid
     *
     * @return CeNacionalidadporalumno
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
}

