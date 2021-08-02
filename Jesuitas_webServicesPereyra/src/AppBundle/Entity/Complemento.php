<?php

namespace AppBundle\Entity;

/**
 * Complemento
 */
class Complemento
{
    /**
     * @var string
     */
    private $complemento;

    /**
     * @var string
     */
    private $complementosize;

    /**
     * @var string
     */
    private $complementotipo;

    /**
     * @var integer
     */
    private $complementoid;

    /**
     * @var \AppBundle\Entity\Tipocomplemento
     */
    private $tipocomplementoid;


    /**
     * Set complemento
     *
     * @param string $complemento
     *
     * @return Complemento
     */
    public function setComplemento($complemento)
    {
        $this->complemento = $complemento;

        return $this;
    }

    /**
     * Get complemento
     *
     * @return string
     */
    public function getComplemento()
    {
        return $this->complemento;
    }

    /**
     * Set complementosize
     *
     * @param string $complementosize
     *
     * @return Complemento
     */
    public function setComplementosize($complementosize)
    {
        $this->complementosize = $complementosize;

        return $this;
    }

    /**
     * Get complementosize
     *
     * @return string
     */
    public function getComplementosize()
    {
        return $this->complementosize;
    }

    /**
     * Set complementotipo
     *
     * @param string $complementotipo
     *
     * @return Complemento
     */
    public function setComplementotipo($complementotipo)
    {
        $this->complementotipo = $complementotipo;

        return $this;
    }

    /**
     * Get complementotipo
     *
     * @return string
     */
    public function getComplementotipo()
    {
        return $this->complementotipo;
    }

    /**
     * Get complementoid
     *
     * @return integer
     */
    public function getComplementoid()
    {
        return $this->complementoid;
    }

    /**
     * Set tipocomplementoid
     *
     * @param \AppBundle\Entity\Tipocomplemento $tipocomplementoid
     *
     * @return Complemento
     */
    public function setTipocomplementoid(\AppBundle\Entity\Tipocomplemento $tipocomplementoid = null)
    {
        $this->tipocomplementoid = $tipocomplementoid;

        return $this;
    }

    /**
     * Get tipocomplementoid
     *
     * @return \AppBundle\Entity\Tipocomplemento
     */
    public function getTipocomplementoid()
    {
        return $this->tipocomplementoid;
    }
}

