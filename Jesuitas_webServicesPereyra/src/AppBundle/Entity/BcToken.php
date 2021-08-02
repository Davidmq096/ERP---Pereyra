<?php

namespace AppBundle\Entity;

/**
 * BcToken
 */
class BcToken
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
    private $preescolar = '1';

    /**
     * @var boolean
     */
    private $primaria = '1';

    /**
     * @var boolean
     */
    private $secundaria = '1';

    /**
     * @var boolean
     */
    private $bachillerato = '1';

    /**
     * @var integer
     */
    private $tipo = '1';

    /**
     * @var integer
     */
    private $tokenid;


    /**
     * Set descripcion
     *
     * @param string $descripcion
     *
     * @return BcToken
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
     * @return BcToken
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
     * @return BcToken
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
     * @return BcToken
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
     * @return BcToken
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
     * @return BcToken
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
     * Set tipo
     *
     * @param integer $tipo
     *
     * @return BcToken
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
     * Get tokenid
     *
     * @return integer
     */
    public function getTokenid()
    {
        return $this->tokenid;
    }
}

