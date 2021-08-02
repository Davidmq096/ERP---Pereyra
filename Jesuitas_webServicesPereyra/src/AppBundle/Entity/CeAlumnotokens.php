<?php

namespace AppBundle\Entity;

/**
 * CeAlumnotokens
 */
class CeAlumnotokens
{
    /**
     * @var string
     */
    private $descripcion;

    /**
     * @var string
     */
    private $token;

    /**
     * @var boolean
     */
    private $preescolar;

    /**
     * @var boolean
     */
    private $primaria;

    /**
     * @var boolean
     */
    private $secundaria;

    /**
     * @var boolean
     */
    private $bachillerato;

    /**
     * @var integer
     */
    private $tokenid;


    /**
     * Set descripcion
     *
     * @param string $descripcion
     *
     * @return CeAlumnotokens
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
     * Set token
     *
     * @param string $token
     *
     * @return CeAlumnotokens
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
     * Set preescolar
     *
     * @param boolean $preescolar
     *
     * @return CeAlumnotokens
     */
    public function setPreescolar($preescolar)
    {
        $this->preescolar = $preescolar;

        return $this;
    }

    /**
     * Get preescolar
     *
     * @return boolean
     */
    public function getPreescolar()
    {
        return $this->preescolar;
    }

    /**
     * Set primaria
     *
     * @param boolean $primaria
     *
     * @return CeAlumnotokens
     */
    public function setPrimaria($primaria)
    {
        $this->primaria = $primaria;

        return $this;
    }

    /**
     * Get primaria
     *
     * @return boolean
     */
    public function getPrimaria()
    {
        return $this->primaria;
    }

    /**
     * Set secundaria
     *
     * @param boolean $secundaria
     *
     * @return CeAlumnotokens
     */
    public function setSecundaria($secundaria)
    {
        $this->secundaria = $secundaria;

        return $this;
    }

    /**
     * Get secundaria
     *
     * @return boolean
     */
    public function getSecundaria()
    {
        return $this->secundaria;
    }

    /**
     * Set bachillerato
     *
     * @param boolean $bachillerato
     *
     * @return CeAlumnotokens
     */
    public function setBachillerato($bachillerato)
    {
        $this->bachillerato = $bachillerato;

        return $this;
    }

    /**
     * Get bachillerato
     *
     * @return boolean
     */
    public function getBachillerato()
    {
        return $this->bachillerato;
    }

    /**
     * Get tokenid
     *
     * @return integer
     */
    public function getTokenid()
    {
        return $this->tokenid;
    }
}

