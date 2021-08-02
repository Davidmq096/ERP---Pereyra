<?php

namespace AppBundle\Entity;

/**
 * Permisoporperfil
 */
class Permisoporperfil
{
    /**
     * @var \DateTime
     */
    private $vigencia;

    /**
     * @var integer
     */
    private $permisoporperfilid;

    /**
     * @var \AppBundle\Entity\Perfil
     */
    private $perfilid;

    /**
     * @var \AppBundle\Entity\Permisoporpantalla
     */
    private $permisoporpantallaid;


    /**
     * Set vigencia
     *
     * @param \DateTime $vigencia
     *
     * @return Permisoporperfil
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
     * Get permisoporperfilid
     *
     * @return integer
     */
    public function getPermisoporperfilid()
    {
        return $this->permisoporperfilid;
    }

    /**
     * Set perfilid
     *
     * @param \AppBundle\Entity\Perfil $perfilid
     *
     * @return Permisoporperfil
     */
    public function setPerfilid(\AppBundle\Entity\Perfil $perfilid = null)
    {
        $this->perfilid = $perfilid;

        return $this;
    }

    /**
     * Get perfilid
     *
     * @return \AppBundle\Entity\Perfil
     */
    public function getPerfilid()
    {
        return $this->perfilid;
    }

    /**
     * Set permisoporpantallaid
     *
     * @param \AppBundle\Entity\Permisoporpantalla $permisoporpantallaid
     *
     * @return Permisoporperfil
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
}

