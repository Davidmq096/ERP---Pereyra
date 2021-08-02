<?php

namespace AppBundle\Entity;

/**
 * Sesion
 */
class Sesion
{
    /**
     * @var string
     */
    private $token;

    /**
     * @var \DateTime
     */
    private $finaliza;

    /**
     * @var \DateTime
     */
    private $inicia = 'CURRENT_TIMESTAMP';

    /**
     * @var string
     */
    private $direccionip;

    /**
     * @var string
     */
    private $pantalla;

    /**
     * @var integer
     */
    private $sesionid;

    /**
     * @var \AppBundle\Entity\Usuario
     */
    private $usuarioid;


    /**
     * Set token
     *
     * @param string $token
     *
     * @return Sesion
     */
    public function setToken($token)
    {
        $this->token = $token;

        return $this;
    }

    /**
     * Get token
     *
     * @return string
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * Set finaliza
     *
     * @param \DateTime $finaliza
     *
     * @return Sesion
     */
    public function setFinaliza($finaliza)
    {
        $this->finaliza = $finaliza;

        return $this;
    }

    /**
     * Get finaliza
     *
     * @return \DateTime
     */
    public function getFinaliza()
    {
        return $this->finaliza;
    }

    /**
     * Set inicia
     *
     * @param \DateTime $inicia
     *
     * @return Sesion
     */
    public function setInicia($inicia)
    {
        $this->inicia = $inicia;

        return $this;
    }

    /**
     * Get inicia
     *
     * @return \DateTime
     */
    public function getInicia()
    {
        return $this->inicia;
    }

    /**
     * Set direccionip
     *
     * @param string $direccionip
     *
     * @return Sesion
     */
    public function setDireccionip($direccionip)
    {
        $this->direccionip = $direccionip;

        return $this;
    }

    /**
     * Get direccionip
     *
     * @return string
     */
    public function getDireccionip()
    {
        return $this->direccionip;
    }

    /**
     * Set pantalla
     *
     * @param string $pantalla
     *
     * @return Sesion
     */
    public function setPantalla($pantalla)
    {
        $this->pantalla = $pantalla;

        return $this;
    }

    /**
     * Get pantalla
     *
     * @return string
     */
    public function getPantalla()
    {
        return $this->pantalla;
    }

    /**
     * Get sesionid
     *
     * @return integer
     */
    public function getSesionid()
    {
        return $this->sesionid;
    }

    /**
     * Set usuarioid
     *
     * @param \AppBundle\Entity\Usuario $usuarioid
     *
     * @return Sesion
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

