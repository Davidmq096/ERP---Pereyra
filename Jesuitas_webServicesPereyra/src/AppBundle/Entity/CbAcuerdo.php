<?php

namespace AppBundle\Entity;

/**
 * CbAcuerdo
 */
class CbAcuerdo
{
    /**
     * @var \DateTime
     */
    private $fechacreacion;

    /**
     * @var \DateTime
     */
    private $fechaultimamodificacion;

    /**
     * @var \DateTime
     */
    private $vigenciainicio;

    /**
     * @var \DateTime
     */
    private $vigenciafin;

    /**
     * @var boolean
     */
    private $pagoparciales = '0';

    /**
     * @var integer
     */
    private $acuerdoid;

    /**
     * @var \AppBundle\Entity\Ciclo
     */
    private $cicloid;

    /**
     * @var \AppBundle\Entity\CbEstatusacuerdo
     */
    private $estatusacuerdoid;

    /**
     * @var \AppBundle\Entity\CePadresotutores
     */
    private $padresotutoresid;

    /**
     * @var \AppBundle\Entity\Usuario
     */
    private $usuarioid;


    /**
     * Set fechacreacion
     *
     * @param \DateTime $fechacreacion
     *
     * @return CbAcuerdo
     */
    public function setFechacreacion($fechacreacion)
    {
        $this->fechacreacion = $fechacreacion;

        return $this;
    }

    /**
     * Get fechacreacion
     *
     * @return \DateTime
     */
    public function getFechacreacion()
    {
        return $this->fechacreacion;
    }

    /**
     * Set fechaultimamodificacion
     *
     * @param \DateTime $fechaultimamodificacion
     *
     * @return CbAcuerdo
     */
    public function setFechaultimamodificacion($fechaultimamodificacion)
    {
        $this->fechaultimamodificacion = $fechaultimamodificacion;

        return $this;
    }

    /**
     * Get fechaultimamodificacion
     *
     * @return \DateTime
     */
    public function getFechaultimamodificacion()
    {
        return $this->fechaultimamodificacion;
    }

    /**
     * Set vigenciainicio
     *
     * @param \DateTime $vigenciainicio
     *
     * @return CbAcuerdo
     */
    public function setVigenciainicio($vigenciainicio)
    {
        $this->vigenciainicio = $vigenciainicio;

        return $this;
    }

    /**
     * Get vigenciainicio
     *
     * @return \DateTime
     */
    public function getVigenciainicio()
    {
        return $this->vigenciainicio;
    }

    /**
     * Set vigenciafin
     *
     * @param \DateTime $vigenciafin
     *
     * @return CbAcuerdo
     */
    public function setVigenciafin($vigenciafin)
    {
        $this->vigenciafin = $vigenciafin;

        return $this;
    }

    /**
     * Get vigenciafin
     *
     * @return \DateTime
     */
    public function getVigenciafin()
    {
        return $this->vigenciafin;
    }

    /**
     * Set pagoparciales
     *
     * @param boolean $pagoparciales
     *
     * @return CbAcuerdo
     */
    public function setPagoparciales($pagoparciales)
    {
        $this->pagoparciales = $pagoparciales;

        return $this;
    }

    /**
     * Get pagoparciales
     *
     * @return boolean
     */
    public function getPagoparciales()
    {
        return $this->pagoparciales;
    }

    /**
     * Get acuerdoid
     *
     * @return integer
     */
    public function getAcuerdoid()
    {
        return $this->acuerdoid;
    }

    /**
     * Set cicloid
     *
     * @param \AppBundle\Entity\Ciclo $cicloid
     *
     * @return CbAcuerdo
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
     * Set estatusacuerdoid
     *
     * @param \AppBundle\Entity\CbEstatusacuerdo $estatusacuerdoid
     *
     * @return CbAcuerdo
     */
    public function setEstatusacuerdoid(\AppBundle\Entity\CbEstatusacuerdo $estatusacuerdoid = null)
    {
        $this->estatusacuerdoid = $estatusacuerdoid;

        return $this;
    }

    /**
     * Get estatusacuerdoid
     *
     * @return \AppBundle\Entity\CbEstatusacuerdo
     */
    public function getEstatusacuerdoid()
    {
        return $this->estatusacuerdoid;
    }

    /**
     * Set padresotutoresid
     *
     * @param \AppBundle\Entity\CePadresotutores $padresotutoresid
     *
     * @return CbAcuerdo
     */
    public function setPadresotutoresid(\AppBundle\Entity\CePadresotutores $padresotutoresid = null)
    {
        $this->padresotutoresid = $padresotutoresid;

        return $this;
    }

    /**
     * Get padresotutoresid
     *
     * @return \AppBundle\Entity\CePadresotutores
     */
    public function getPadresotutoresid()
    {
        return $this->padresotutoresid;
    }

    /**
     * Set usuarioid
     *
     * @param \AppBundle\Entity\Usuario $usuarioid
     *
     * @return CbAcuerdo
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

