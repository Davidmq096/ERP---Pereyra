<?php

namespace AppBundle\Entity;

/**
 * Permisoporpantalla
 */
class Permisoporpantalla
{
    /**
     * @var integer
     */
    private $permisoporpantallaid;

    /**
     * @var \AppBundle\Entity\Pantalla
     */
    private $pantallaid;

    /**
     * @var \AppBundle\Entity\Permiso
     */
    private $permisoid;


    /**
     * Get permisoporpantallaid
     *
     * @return integer
     */
    public function getPermisoporpantallaid()
    {
        return $this->permisoporpantallaid;
    }

    /**
     * Set pantallaid
     *
     * @param \AppBundle\Entity\Pantalla $pantallaid
     *
     * @return Permisoporpantalla
     */
    public function setPantallaid(\AppBundle\Entity\Pantalla $pantallaid = null)
    {
        $this->pantallaid = $pantallaid;

        return $this;
    }

    /**
     * Get pantallaid
     *
     * @return \AppBundle\Entity\Pantalla
     */
    public function getPantallaid()
    {
        return $this->pantallaid;
    }

    /**
     * Set permisoid
     *
     * @param \AppBundle\Entity\Permiso $permisoid
     *
     * @return Permisoporpantalla
     */
    public function setPermisoid(\AppBundle\Entity\Permiso $permisoid = null)
    {
        $this->permisoid = $permisoid;

        return $this;
    }

    /**
     * Get permisoid
     *
     * @return \AppBundle\Entity\Permiso
     */
    public function getPermisoid()
    {
        return $this->permisoid;
    }
}

