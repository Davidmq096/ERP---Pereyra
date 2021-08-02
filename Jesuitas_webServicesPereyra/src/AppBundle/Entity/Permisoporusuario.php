<?php

namespace AppBundle\Entity;

/**
 * Permisoporusuario
 */
class Permisoporusuario
{
    /**
     * @var \DateTime
     */
    private $vigencia;

    /**
     * @var integer
     */
    private $permisoporusuarioid;

    /**
     * @var \AppBundle\Entity\Permisoporpantalla
     */
    private $permisoporpantallaid;

    /**
     * @var \AppBundle\Entity\Usuario
     */
    private $usuarioid;


    /**
     * Set vigencia
     *
     * @param \DateTime $vigencia
     *
     * @return Permisoporusuario
     */
    public function setVigencia($vigencia)
    {
        $this->vigencia = $vigencia;

        return $this;
    }

    /**
     * Get vigencia
     *
     * @return \DateTime
     */
    public function getVigencia()
    {
        return $this->vigencia;
    }

    /**
     * Get permisoporusuarioid
     *
     * @return integer
     */
    public function getPermisoporusuarioid()
    {
        return $this->permisoporusuarioid;
    }

    /**
     * Set permisoporpantallaid
     *
     * @param \AppBundle\Entity\Permisoporpantalla $permisoporpantallaid
     *
     * @return Permisoporusuario
     */
    public function setPermisoporpantallaid(\AppBundle\Entity\Permisoporpantalla $permisoporpantallaid = null)
    {
        $this->permisoporpantallaid = $permisoporpantallaid;

        return $this;
    }

    /**
     * Get permisoporpantallaid
     *
     * @return \AppBundle\Entity\Permisoporpantalla
     */
    public function getPermisoporpantallaid()
    {
        return $this->permisoporpantallaid;
    }

    /**
     * Set usuarioid
     *
     * @param \AppBundle\Entity\Usuario $usuarioid
     *
     * @return Permisoporusuario
     */
    public function setUsuarioid(\AppBundle\Entity\Usuario $usuarioid = null)
    {
        $this->usuarioid = $usuarioid;

        return $this;
    }

    /**
     * Get usuarioid
     *
     * @return \AppBundle\Entity\Usuario
     */
    public function getUsuarioid()
    {
        return $this->usuarioid;
    }
}

