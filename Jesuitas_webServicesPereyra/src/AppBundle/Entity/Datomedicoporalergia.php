<?php

namespace AppBundle\Entity;

/**
 * Datomedicoporalergia
 */
class Datomedicoporalergia
{
    /**
     * @var integer
     */
    private $datomedicoalergiaid;

    /**
     * @var \AppBundle\Entity\Alergia
     */
    private $alergiaid;

    /**
     * @var \AppBundle\Entity\Datomedico
     */
    private $datomedicoid;


    /**
     * Get datomedicoalergiaid
     *
     * @return integer
     */
    public function getDatomedicoalergiaid()
    {
        return $this->datomedicoalergiaid;
    }

    /**
     * Set alergiaid
     *
     * @param \AppBundle\Entity\Alergia $alergiaid
     *
     * @return Datomedicoporalergia
     */
    public function setAlergiaid(\AppBundle\Entity\Alergia $alergiaid = null)
    {
        $this->alergiaid = $alergiaid;

        return $this;
    }

    /**
     * Get alergiaid
     *
     * @return \AppBundle\Entity\Alergia
     */
    public function getAlergiaid()
    {
        return $this->alergiaid;
    }

    /**
     * Set datomedicoid
     *
     * @param \AppBundle\Entity\Datomedico $datomedicoid
     *
     * @return Datomedicoporalergia
     */
    public function setDatomedicoid(\AppBundle\Entity\Datomedico $datomedicoid = null)
    {
        $this->datomedicoid = $datomedicoid;

        return $this;
    }

    /**
     * Get datomedicoid
     *
     * @return \AppBundle\Entity\Datomedico
     */
    public function getDatomedicoid()
    {
        return $this->datomedicoid;
    }
}

