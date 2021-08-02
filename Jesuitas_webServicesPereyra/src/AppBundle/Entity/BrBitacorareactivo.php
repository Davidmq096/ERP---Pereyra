<?php

namespace AppBundle\Entity;

/**
 * BrBitacorareactivo
 */
class BrBitacorareactivo
{
    /**
     * @var string
     */
    private $comentariorechazo;

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
    private $bitacorareactivoid;

    /**
     * @var \AppBundle\Entity\BrMotivorechazo
     */
    private $motivorechazoid;

    /**
     * @var \AppBundle\Entity\BrReactivo
     */
    private $reactivoid;

    /**
     * @var \AppBundle\Entity\BrTipoaccionbitacorareactivo
     */
    private $tipoaccionbitacorareactivoid;

    /**
     * @var \AppBundle\Entity\Usuario
     */
    private $usuarioid;


    /**
     * Set comentariorechazo
     *
     * @param string $comentariorechazo
     *
     * @return BrBitacorareactivo
     */
    public function setComentariorechazo($comentariorechazo)
    {
        $this->comentariorechazo = $comentariorechazo;

        return $this;
    }

    /**
     * Get comentariorechazo
     *
     * @return string
     */
    public function getComentariorechazo()
    {
        return $this->comentariorechazo;
    }

    /**
     * Set fecha
     *
     * @param \DateTime $fecha
     *
     * @return BrBitacorareactivo
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
     * @return BrBitacorareactivo
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
     * Get bitacorareactivoid
     *
     * @return integer
     */
    public function getBitacorareactivoid()
    {
        return $this->bitacorareactivoid;
    }

    /**
     * Set motivorechazoid
     *
     * @param \AppBundle\Entity\BrMotivorechazo $motivorechazoid
     *
     * @return BrBitacorareactivo
     */
    public function setMotivorechazoid(\AppBundle\Entity\BrMotivorechazo $motivorechazoid = null)
    {
        $this->motivorechazoid = $motivorechazoid;

        return $this;
    }

    /**
     * Get motivorechazoid
     *
     * @return \AppBundle\Entity\BrMotivorechazo
     */
    public function getMotivorechazoid()
    {
        return $this->motivorechazoid;
    }

    /**
     * Set reactivoid
     *
     * @param \AppBundle\Entity\BrReactivo $reactivoid
     *
     * @return BrBitacorareactivo
     */
    public function setReactivoid(\AppBundle\Entity\BrReactivo $reactivoid = null)
    {
        $this->reactivoid = $reactivoid;

        return $this;
    }

    /**
     * Get reactivoid
     *
     * @return \AppBundle\Entity\BrReactivo
     */
    public function getReactivoid()
    {
        return $this->reactivoid;
    }

    /**
     * Set tipoaccionbitacorareactivoid
     *
     * @param \AppBundle\Entity\BrTipoaccionbitacorareactivo $tipoaccionbitacorareactivoid
     *
     * @return BrBitacorareactivo
     */
    public function setTipoaccionbitacorareactivoid(\AppBundle\Entity\BrTipoaccionbitacorareactivo $tipoaccionbitacorareactivoid = null)
    {
        $this->tipoaccionbitacorareactivoid = $tipoaccionbitacorareactivoid;

        return $this;
    }

    /**
     * Get tipoaccionbitacorareactivoid
     *
     * @return \AppBundle\Entity\BrTipoaccionbitacorareactivo
     */
    public function getTipoaccionbitacorareactivoid()
    {
        return $this->tipoaccionbitacorareactivoid;
    }

    /**
     * Set usuarioid
     *
     * @param \AppBundle\Entity\Usuario $usuarioid
     *
     * @return BrBitacorareactivo
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

