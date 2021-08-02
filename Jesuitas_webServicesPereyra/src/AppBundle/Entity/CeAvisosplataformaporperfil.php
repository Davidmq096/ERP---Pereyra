<?php

namespace AppBundle\Entity;

/**
 * CeAvisosplataformaporperfil
 */
class CeAvisosplataformaporperfil
{
    /**
     * @var integer
     */
    private $avisoplataformaporperfilid;

    /**
     * @var \AppBundle\Entity\CeAvisosplataforma
     */
    private $avisoplataformaid;

    /**
     * @var \AppBundle\Entity\Perfil
     */
    private $perfilid;


    /**
     * Get avisoplataformaporperfilid
     *
     * @return integer
     */
    public function getAvisoplataformaporperfilid()
    {
        return $this->avisoplataformaporperfilid;
    }

    /**
     * Set avisoplataformaid
     *
     * @param \AppBundle\Entity\CeAvisosplataforma $avisoplataformaid
     *
     * @return CeAvisosplataformaporperfil
     */
    public function setAvisoplataformaid(\AppBundle\Entity\CeAvisosplataforma $avisoplataformaid = null)
    {
        $this->avisoplataformaid = $avisoplataformaid;

        return $this;
    }

    /**
     * Get avisoplataformaid
     *
     * @return \AppBundle\Entity\CeAvisosplataforma
     */
    public function getAvisoplataformaid()
    {
        return $this->avisoplataformaid;
    }

    /**
     * Set perfilid
     *
     * @param \AppBundle\Entity\Perfil $perfilid
     *
     * @return CeAvisosplataformaporperfil
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

