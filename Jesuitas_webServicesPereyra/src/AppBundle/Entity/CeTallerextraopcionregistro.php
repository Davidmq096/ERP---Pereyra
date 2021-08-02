<?php

namespace AppBundle\Entity;

/**
 * CeTallerextraopcionregistro
 */
class CeTallerextraopcionregistro
{
    /**
     * @var integer
     */
    private $tipopago;

    /**
     * @var integer
     */
    private $notalleres;

    /**
     * @var integer
     */
    private $tallerextraopcionregistroid;

    /**
     * @var \AppBundle\Entity\CeTallerfrecuenciapago
     */
    private $frecuenciapagoid;

    /**
     * @var \AppBundle\Entity\Grado
     */
    private $gradoid;


    /**
     * Set tipopago
     *
     * @param integer $tipopago
     *
     * @return CeTallerextraopcionregistro
     */
    public function setTipopago($tipopago)
    {
        $this->tipopago = $tipopago;

        return $this;
    }

    /**
     * Get tipopago
     *
     * @return integer
     */
    public function getTipopago()
    {
        return $this->tipopago;
    }

    /**
     * Set notalleres
     *
     * @param integer $notalleres
     *
     * @return CeTallerextraopcionregistro
     */
    public function setNotalleres($notalleres)
    {
        $this->notalleres = $notalleres;

        return $this;
    }

    /**
     * Get notalleres
     *
     * @return integer
     */
    public function getNotalleres()
    {
        return $this->notalleres;
    }

    /**
     * Get tallerextraopcionregistroid
     *
     * @return integer
     */
    public function getTallerextraopcionregistroid()
    {
        return $this->tallerextraopcionregistroid;
    }

    /**
     * Set frecuenciapagoid
     *
     * @param \AppBundle\Entity\CeTallerfrecuenciapago $frecuenciapagoid
     *
     * @return CeTallerextraopcionregistro
     */
    public function setFrecuenciapagoid(\AppBundle\Entity\CeTallerfrecuenciapago $frecuenciapagoid = null)
    {
        $this->frecuenciapagoid = $frecuenciapagoid;

        return $this;
    }

    /**
     * Get frecuenciapagoid
     *
     * @return \AppBundle\Entity\CeTallerfrecuenciapago
     */
    public function getFrecuenciapagoid()
    {
        return $this->frecuenciapagoid;
    }

    /**
     * Set gradoid
     *
     * @param \AppBundle\Entity\Grado $gradoid
     *
     * @return CeTallerextraopcionregistro
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
}

