<?php

namespace AppBundle\Entity;

/**
 * CmNotificaciondestinatarios
 */
class CmNotificaciondestinatarios
{
    /**
     * @var integer
     */
    private $nivelid;

    /**
     * @var integer
     */
    private $gradoid;

    /**
     * @var integer
     */
    private $grupoid;

    /**
     * @var integer
     */
    private $alumnoid;

    /**
     * @var integer
     */
    private $notificaciondestinatariosid;

    /**
     * @var \AppBundle\Entity\CmNotificacion
     */
    private $notificacionid;


    /**
     * Set nivelid
     *
     * @param integer $nivelid
     *
     * @return CmNotificaciondestinatarios
     */
    public function setNivelid($nivelid)
    {
        $this->nivelid = $nivelid;

        return $this;
    }

    /**
     * Get nivelid
     *
     * @return integer
     */
    public function getNivelid()
    {
        return $this->nivelid;
    }

    /**
     * Set gradoid
     *
     * @param integer $gradoid
     *
     * @return CmNotificaciondestinatarios
     */
    public function setGradoid($gradoid)
    {
        $this->gradoid = $gradoid;

        return $this;
    }

    /**
     * Get gradoid
     *
     * @return integer
     */
    public function getGradoid()
    {
        return $this->gradoid;
    }

    /**
     * Set grupoid
     *
     * @param integer $grupoid
     *
     * @return CmNotificaciondestinatarios
     */
    public function setGrupoid($grupoid)
    {
        $this->grupoid = $grupoid;

        return $this;
    }

    /**
     * Get grupoid
     *
     * @return integer
     */
    public function getGrupoid()
    {
        return $this->grupoid;
    }

    /**
     * Set alumnoid
     *
     * @param integer $alumnoid
     *
     * @return CmNotificaciondestinatarios
     */
    public function setAlumnoid($alumnoid)
    {
        $this->alumnoid = $alumnoid;

        return $this;
    }

    /**
     * Get alumnoid
     *
     * @return integer
     */
    public function getAlumnoid()
    {
        return $this->alumnoid;
    }

    /**
     * Get notificaciondestinatariosid
     *
     * @return integer
     */
    public function getNotificaciondestinatariosid()
    {
        return $this->notificaciondestinatariosid;
    }

    /**
     * Set notificacionid
     *
     * @param \AppBundle\Entity\CmNotificacion $notificacionid
     *
     * @return CmNotificaciondestinatarios
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
}

