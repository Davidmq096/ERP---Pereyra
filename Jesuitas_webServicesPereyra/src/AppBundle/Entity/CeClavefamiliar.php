<?php

namespace AppBundle\Entity;

/**
 * CeClavefamiliar
 */
class CeClavefamiliar
{
    /**
     * @var string
     */
    private $clave;

    /**
     * @var string
     */
    private $apellidopaterno;

    /**
     * @var string
     */
    private $apellidomaterno;

    /**
     * @var integer
     */
    private $clavefamiliarid;

    /**
     * @var \AppBundle\Entity\CeSituacionfamiliar
     */
    private $situacionfamiliarid;


    /**
     * Set clave
     *
     * @param string $clave
     *
     * @return CeClavefamiliar
     */
    public function setClave($clave)
    {
        $this->clave = $clave;

        return $this;
    }

    /**
     * Get clave
     *
     * @return string
     */
    public function getClave()
    {
        return $this->clave;
    }

    /**
     * Set apellidopaterno
     *
     * @param string $apellidopaterno
     *
     * @return CeClavefamiliar
     */
    public function setApellidopaterno($apellidopaterno)
    {
        $this->apellidopaterno = $apellidopaterno;

        return $this;
    }

    /**
     * Get apellidopaterno
     *
     * @return string
     */
    public function getApellidopaterno()
    {
        return $this->apellidopaterno;
    }

    /**
     * Set apellidomaterno
     *
     * @param string $apellidomaterno
     *
     * @return CeClavefamiliar
     */
    public function setApellidomaterno($apellidomaterno)
    {
        $this->apellidomaterno = $apellidomaterno;

        return $this;
    }

    /**
     * Get apellidomaterno
     *
     * @return string
     */
    public function getApellidomaterno()
    {
        return $this->apellidomaterno;
    }

    /**
     * Get clavefamiliarid
     *
     * @return integer
     */
    public function getClavefamiliarid()
    {
        return $this->clavefamiliarid;
    }

    /**
     * Set situacionfamiliarid
     *
     * @param \AppBundle\Entity\CeSituacionfamiliar $situacionfamiliarid
     *
     * @return CeClavefamiliar
     */
    public function setSituacionfamiliarid(\AppBundle\Entity\CeSituacionfamiliar $situacionfamiliarid = null)
    {
        $this->situacionfamiliarid = $situacionfamiliarid;

        return $this;
    }

    /**
     * Get situacionfamiliarid
     *
     * @return \AppBundle\Entity\CeSituacionfamiliar
     */
    public function getSituacionfamiliarid()
    {
        return $this->situacionfamiliarid;
    }
}

