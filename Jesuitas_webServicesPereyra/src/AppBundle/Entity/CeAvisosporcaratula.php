<?php

namespace AppBundle\Entity;

/**
 * CeAvisosporcaratula
 */
class CeAvisosporcaratula
{
    /**
     * @var string
     */
    private $descripcion;

    /**
     * @var \DateTime
     */
    private $fecha;

    /**
     * @var \DateTime
     */
    private $hora;

    /**
     * @var integer
     */
    private $avisocaratulaid;

    /**
     * @var \AppBundle\Entity\CeAvisosporcaratulaestatus
     */
    private $avisocaratulaestatusid;

    /**
     * @var \AppBundle\Entity\CeCaratula
     */
    private $caratulaid;


    /**
     * Set descripcion
     *
     * @param string $descripcion
     *
     * @return CeAvisosporcaratula
     */
    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    /**
     * Get descripcion
     *
     * @return string
     */
    public function getDescripcion()
    {
        return $this->descripcion;
    }

    /**
     * Set fecha
     *
     * @param \DateTime $fecha
     *
     * @return CeAvisosporcaratula
     */
    public function setFecha($fecha)
    {
        $this->fecha = $fecha;

        return $this;
    }

    /**
     * Get fecha
     *
     * @return \DateTime
     */
    public function getFecha()
    {
        return $this->fecha;
    }

    /**
     * Set hora
     *
     * @param \DateTime $hora
     *
     * @return CeAvisosporcaratula
     */
    public function setHora($hora)
    {
        $this->hora = $hora;

        return $this;
    }

    /**
     * Get hora
     *
     * @return \DateTime
     */
    public function getHora()
    {
        return $this->hora;
    }

    /**
     * Get avisocaratulaid
     *
     * @return integer
     */
    public function getAvisocaratulaid()
    {
        return $this->avisocaratulaid;
    }

    /**
     * Set avisocaratulaestatusid
     *
     * @param \AppBundle\Entity\CeAvisosporcaratulaestatus $avisocaratulaestatusid
     *
     * @return CeAvisosporcaratula
     */
    public function setAvisocaratulaestatusid(\AppBundle\Entity\CeAvisosporcaratulaestatus $avisocaratulaestatusid = null)
    {
        $this->avisocaratulaestatusid = $avisocaratulaestatusid;

        return $this;
    }

    /**
     * Get avisocaratulaestatusid
     *
     * @return \AppBundle\Entity\CeAvisosporcaratulaestatus
     */
    public function getAvisocaratulaestatusid()
    {
        return $this->avisocaratulaestatusid;
    }

    /**
     * Set caratulaid
     *
     * @param \AppBundle\Entity\CeCaratula $caratulaid
     *
     * @return CeAvisosporcaratula
     */
    public function setCaratulaid(\AppBundle\Entity\CeCaratula $caratulaid = null)
    {
        $this->caratulaid = $caratulaid;

        return $this;
    }

    /**
     * Get caratulaid
     *
     * @return \AppBundle\Entity\CeCaratula
     */
    public function getCaratulaid()
    {
        return $this->caratulaid;
    }
}

