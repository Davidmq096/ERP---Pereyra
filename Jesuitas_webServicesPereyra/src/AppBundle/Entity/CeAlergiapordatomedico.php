<?php

namespace AppBundle\Entity;

/**
 * CeAlergiapordatomedico
 */
class CeAlergiapordatomedico
{
    /**
     * @var integer
     */
    private $alergiapordatomedicoid;

    /**
     * @var \AppBundle\Entity\Alergia
     */
    private $alergiaid;

    /**
     * @var \AppBundle\Entity\CeAlumnodatomedico
     */
    private $alumnodatomedicoid;


    /**
     * Get alergiapordatomedicoid
     *
     * @return integer
     */
    public function getAlergiapordatomedicoid()
    {
        return $this->alergiapordatomedicoid;
    }

    /**
     * Set alergiaid
     *
     * @param \AppBundle\Entity\Alergia $alergiaid
     *
     * @return CeAlergiapordatomedico
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
     * Set alumnodatomedicoid
     *
     * @param \AppBundle\Entity\CeAlumnodatomedico $alumnodatomedicoid
     *
     * @return CeAlergiapordatomedico
     */
    public function setAlumnodatomedicoid(\AppBundle\Entity\CeAlumnodatomedico $alumnodatomedicoid = null)
    {
        $this->alumnodatomedicoid = $alumnodatomedicoid;

        return $this;
    }

    /**
     * Get alumnodatomedicoid
     *
     * @return \AppBundle\Entity\CeAlumnodatomedico
     */
    public function getAlumnodatomedicoid()
    {
        return $this->alumnodatomedicoid;
    }
}

