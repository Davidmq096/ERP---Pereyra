<?php

namespace AppBundle\Entity;

/**
 * Cicloporperfil
 */
class Cicloporperfil
{
    /**
     * @var integer
     */
    private $cicloporperfilid;

    /**
     * @var \AppBundle\Entity\Ciclo
     */
    private $cicloid;

    /**
     * @var \AppBundle\Entity\Perfil
     */
    private $perfilid;


    /**
     * Get cicloporperfilid
     *
     * @return integer
     */
    public function getCicloporperfilid()
    {
        return $this->cicloporperfilid;
    }

    /**
     * Set cicloid
     *
     * @param \AppBundle\Entity\Ciclo $cicloid
     *
     * @return Cicloporperfil
     */
    public function setCicloid(\AppBundle\Entity\Ciclo $cicloid = null)
    {
        $this->cicloid = $cicloid;

        return $this;
    }

    /**
     * Get cicloid
     *
     * @return \AppBundle\Entity\Ciclo
     */
    public function getCicloid()
    {
        return $this->cicloid;
    }

    /**
     * Set perfilid
     *
     * @param \AppBundle\Entity\Perfil $perfilid
     *
     * @return Cicloporperfil
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
}

