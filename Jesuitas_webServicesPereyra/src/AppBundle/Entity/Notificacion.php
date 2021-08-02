<?php

namespace AppBundle\Entity;

/**
 * Notificacion
 */
class Notificacion
{
    /**
     * @var boolean
     */
    private $leido = '0';

    /**
     * @var integer
     */
    private $tiponotificacionid = '1';

    /**
     * @var \DateTime
     */
    private $fechacreacion;

    /**
     * @var \DateTime
     */
    private $fechaenvio;

    /**
     * @var integer
     */
    private $notificacionid;

    /**
     * @var \AppBundle\Entity\Usuario
     */
    private $usuarioid;


    /**
     * Set leido
     *
     * @param boolean $leido
     *
     * @return Notificacion
     */
    public function setLeido($leido)
    {
        $this->leido = $leido;

        return $this;
    }

    /**
     * Get leido
     *
     * @return boolean
     */
    public function getLeido()
    {
        return $this->leido;
    }

    /**
     * Set tiponotificacionid
     *
     * @param integer $tiponotificacionid
     *
     * @return Notificacion
     */
    public function setTiponotificacionid($tiponotificacionid)
    {
        $this->tiponotificacionid = $tiponotificacionid;

        return $this;
    }

    /**
     * Get tiponotificacionid
     *
     * @return integer
     */
    public function getTiponotificacionid()
    {
        return $this->tiponotificacionid;
    }

    /**
     * Set fechacreacion
     *
     * @param \DateTime $fechacreacion
     *
     * @return Notificacion
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
     * Set fechaenvio
     *
     * @param \DateTime $fechaenvio
     *
     * @return Notificacion
     */
    public function setFechaenvio($fechaenvio)
    {
        $this->fechaenvio = $fechaenvio;

        return $this;
    }

    /**
     * Get fechaenvio
     *
     * @return \DateTime
     */
    public function getFechaenvio()
    {
        return $this->fechaenvio;
    }

    /**
     * Get notificacionid
     *
     * @return integer
     */
    public function getNotificacionid()
    {
        return $this->notificacionid;
    }

    /**
     * Set usuarioid
     *
     * @param \AppBundle\Entity\Usuario $usuarioid
     *
     * @return Notificacion
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

