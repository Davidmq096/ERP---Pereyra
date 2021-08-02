<?php

namespace AppBundle\Entity;

/**
 * Gradorepetido
 */
class Gradorepetido
{
    /**
     * @var string
     */
    private $causa;

    /**
     * @var integer
     */
    private $gradorepetidoid;

    /**
     * @var \AppBundle\Entity\Grado
     */
    private $gradoid;

    /**
     * @var \AppBundle\Entity\Datoaspirante
     */
    private $datoaspiranteid;


    /**
     * Set causa
     *
     * @param string $causa
     *
     * @return Gradorepetido
     */
    public function setCausa($causa)
    {
        $this->causa = $causa;

        return $this;
    }

    /**
     * Get causa
     *
     * @return string
     */
    public function getCausa()
    {
        return $this->causa;
    }

    /**
     * Get gradorepetidoid
     *
     * @return integer
     */
    public function getGradorepetidoid()
    {
        return $this->gradorepetidoid;
    }

    /**
     * Set gradoid
     *
     * @param \AppBundle\Entity\Grado $gradoid
     *
     * @return Gradorepetido
     */
    public function setGradoid(\AppBundle\Entity\Grado $gradoid = null)
    {
        $this->gradoid = $gradoid;

        return $this;
    }

    /**
     * Get gradoid
     *
     * @return \AppBundle\Entity\Grado
     */
    public function getGradoid()
    {
        return $this->gradoid;
    }

    /**
     * Set datoaspiranteid
     *
     * @param \AppBundle\Entity\Datoaspirante $datoaspiranteid
     *
     * @return Gradorepetido
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
}

