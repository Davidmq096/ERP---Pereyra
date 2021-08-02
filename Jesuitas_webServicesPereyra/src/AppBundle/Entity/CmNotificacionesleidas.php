<?php

namespace AppBundle\Entity;

/**
 * CmNotificacionesleidas
 */
class CmNotificacionesleidas
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var boolean
     */
    private $leido;

    /**
     * @var boolean
     */
    private $hecho;

    /**
     * @var integer
     */
    private $tipo;

    /**
     * @var integer
     */
    private $notificacionleidaid;

    /**
     * @var \AppBundle\Entity\CeAlumno
     */
    private $alumnoid;

    /**
     * @var \AppBundle\Entity\CmNotificacion
     */
    private $notificacionid;

    /**
     * @var \AppBundle\Entity\CmNotificaciondestinatarios
     */
    private $notificaciondestinatarioid;


    /**
     * Set id
     *
     * @param integer $id
     *
     * @return CmNotificacionesleidas
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set leido
     *
     * @param boolean $leido
     *
     * @return CmNotificacionesleidas
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
     * Set hecho
     *
     * @param boolean $hecho
     *
     * @return CmNotificacionesleidas
     */
    public function setHecho($hecho)
    {
        $this->hecho = $hecho;

        return $this;
    }

    /**
     * Get hecho
     *
     * @return boolean
     */
    public function getHecho()
    {
        return $this->hecho;
    }

    /**
     * Set tipo
     *
     * @param integer $tipo
     *
     * @return CmNotificacionesleidas
     */
    public function setTipo($tipo)
    {
        $this->tipo = $tipo;

        return $this;
    }

    /**
     * Get tipo
     *
     * @return integer
     */
    public function getTipo()
    {
        return $this->tipo;
    }

    /**
     * Get notificacionleidaid
     *
     * @return integer
     */
    public function getNotificacionleidaid()
    {
        return $this->notificacionleidaid;
    }

    /**
     * Set alumnoid
     *
     * @param \AppBundle\Entity\CeAlumno $alumnoid
     *
     * @return CmNotificacionesleidas
     */
    public function setAlumnoid(\AppBundle\Entity\CeAlumno $alumnoid = null)
    {
        $this->alumnoid = $alumnoid;

        return $this;
    }

    /**
     * Get alumnoid
     *
     * @return \AppBundle\Entity\CeAlumno
     */
    public function getAlumnoid()
    {
        return $this->alumnoid;
    }

    /**
     * Set notificacionid
     *
     * @param \AppBundle\Entity\CmNotificacion $notificacionid
     *
     * @return CmNotificacionesleidas
     */
    public function setNotificacionid(\AppBundle\Entity\CmNotificacion $notificacionid = null)
    {
        $this->notificacionid = $notificacionid;

        return $this;
    }

    /**
     * Get notificacionid
     *
     * @return \AppBundle\Entity\CmNotificacion
     */
    public function getNotificacionid()
    {
        return $this->notificacionid;
    }

    /**
     * Set notificaciondestinatarioid
     *
     * @param \AppBundle\Entity\CmNotificaciondestinatarios $notificaciondestinatarioid
     *
     * @return CmNotificacionesleidas
     */
    public function setNotificaciondestinatarioid(\AppBundle\Entity\CmNotificaciondestinatarios $notificaciondestinatarioid = null)
    {
        $this->notificaciondestinatarioid = $notificaciondestinatarioid;

        return $this;
    }

    /**
     * Get notificaciondestinatarioid
     *
     * @return \AppBundle\Entity\CmNotificaciondestinatarios
     */
    public function getNotificaciondestinatarioid()
    {
        return $this->notificaciondestinatarioid;
    }
}

