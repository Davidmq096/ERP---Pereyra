<?php

namespace AppBundle\Entity;

/**
 * CmNotificacion
 */
class CmNotificacion
{
    /**
     * @var boolean
     */
    private $enviarpadres;

    /**
     * @var boolean
     */
    private $enviaralumnos;

    /**
     * @var \DateTime
     */
    private $fecha;

    /**
     * @var \DateTime
     */
    private $hora;

    /**
     * @var string
     */
    private $titulo;

    /**
     * @var string
     */
    private $mensaje;

    /**
     * @var string
     */
    private $vinculo;

    /**
     * @var string
     */
    private $formato;

    /**
     * @var integer
     */
    private $estatus = '0';

    /**
     * @var integer
     */
    private $tipoimagen;

    /**
     * @var \DateTime
     */
    private $fechamodificacion;

    /**
     * @var integer
     */
    private $notificacionid;

    /**
     * @var \AppBundle\Entity\Usuario
     */
    private $usuarioid;


    /**
     * Set enviarpadres
     *
     * @param boolean $enviarpadres
     *
     * @return CmNotificacion
     */
    public function setEnviarpadres($enviarpadres)
    {
        $this->enviarpadres = $enviarpadres;

        return $this;
    }

    /**
     * Get enviarpadres
     *
     * @return boolean
     */
    public function getEnviarpadres()
    {
        return $this->enviarpadres;
    }

    /**
     * Set enviaralumnos
     *
     * @param boolean $enviaralumnos
     *
     * @return CmNotificacion
     */
    public function setEnviaralumnos($enviaralumnos)
    {
        $this->enviaralumnos = $enviaralumnos;

        return $this;
    }

    /**
     * Get enviaralumnos
     *
     * @return boolean
     */
    public function getEnviaralumnos()
    {
        return $this->enviaralumnos;
    }

    /**
     * Set fecha
     *
     * @param \DateTime $fecha
     *
     * @return CmNotificacion
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
     * @return CmNotificacion
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
     * Set titulo
     *
     * @param string $titulo
     *
     * @return CmNotificacion
     */
    public function setTitulo($titulo)
    {
        $this->titulo = $titulo;

        return $this;
    }

    /**
     * Get titulo
     *
     * @return string
     */
    public function getTitulo()
    {
        return $this->titulo;
    }

    /**
     * Set mensaje
     *
     * @param string $mensaje
     *
     * @return CmNotificacion
     */
    public function setMensaje($mensaje)
    {
        $this->mensaje = $mensaje;

        return $this;
    }

    /**
     * Get mensaje
     *
     * @return string
     */
    public function getMensaje()
    {
        return $this->mensaje;
    }

    /**
     * Set vinculo
     *
     * @param string $vinculo
     *
     * @return CmNotificacion
     */
    public function setVinculo($vinculo)
    {
        $this->vinculo = $vinculo;

        return $this;
    }

    /**
     * Get vinculo
     *
     * @return string
     */
    public function getVinculo()
    {
        return $this->vinculo;
    }

    /**
     * Set formato
     *
     * @param string $formato
     *
     * @return CmNotificacion
     */
    public function setFormato($formato)
    {
        $this->formato = $formato;

        return $this;
    }

    /**
     * Get formato
     *
     * @return string
     */
    public function getFormato()
    {
        return $this->formato;
    }

    /**
     * Set estatus
     *
     * @param integer $estatus
     *
     * @return CmNotificacion
     */
    public function setEstatus($estatus)
    {
        $this->estatus = $estatus;

        return $this;
    }

    /**
     * Get estatus
     *
     * @return integer
     */
    public function getEstatus()
    {
        return $this->estatus;
    }

    /**
     * Set tipoimagen
     *
     * @param integer $tipoimagen
     *
     * @return CmNotificacion
     */
    public function setTipoimagen($tipoimagen)
    {
        $this->tipoimagen = $tipoimagen;

        return $this;
    }

    /**
     * Get tipoimagen
     *
     * @return integer
     */
    public function getTipoimagen()
    {
        return $this->tipoimagen;
    }

    /**
     * Set fechamodificacion
     *
     * @param \DateTime $fechamodificacion
     *
     * @return CmNotificacion
     */
    public function setFechamodificacion($fechamodificacion)
    {
        $this->fechamodificacion = $fechamodificacion;

        return $this;
    }

    /**
     * Get fechamodificacion
     *
     * @return \DateTime
     */
    public function getFechamodificacion()
    {
        return $this->fechamodificacion;
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
     * @return CmNotificacion
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

