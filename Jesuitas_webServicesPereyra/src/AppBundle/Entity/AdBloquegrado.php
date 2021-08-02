<?php

namespace AppBundle\Entity;

/**
 * AdBloquegrado
 */
class AdBloquegrado
{
    /**
     * @var string
     */
    private $nombre;

    /**
     * @var integer
     */
    private $bloquegradoid;

    /**
     * @var \AppBundle\Entity\Ciclo
     */
    private $cicloid;

    /**
     * @var \AppBundle\Entity\AdMetodoasignacioncita
     */
    private $metodoasignacioncitaid;

    /**
     * @var \AppBundle\Entity\Nivel
     */
    private $nivelid;


    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return AdBloquegrado
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * Get nombre
     *
     * @return string
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Get bloquegradoid
     *
     * @return integer
     */
    public function getBloquegradoid()
    {
        return $this->bloquegradoid;
    }

    /**
     * Set cicloid
     *
     * @param \AppBundle\Entity\Ciclo $cicloid
     *
     * @return AdBloquegrado
     */
    public function setCicloid(\AppBundle\Entity\Ciclo $cicloid = null)
    {
        $this->cicloid = $cicloid;

        return $this;
    }

    /**
     * Get cicloid
     *
     * @return \AppBundle\Entity\Ciclo
     */
    public function getCicloid()
    {
        return $this->cicloid;
    }

    /**
     * Set metodoasignacioncitaid
     *
     * @param \AppBundle\Entity\AdMetodoasignacioncita $metodoasignacioncitaid
     *
     * @return AdBloquegrado
     */
    public function setMetodoasignacioncitaid(\AppBundle\Entity\AdMetodoasignacioncita $metodoasignacioncitaid = null)
    {
        $this->metodoasignacioncitaid = $metodoasignacioncitaid;

        return $this;
    }

    /**
     * Get metodoasignacioncitaid
     *
     * @return \AppBundle\Entity\AdMetodoasignacioncita
     */
    public function getMetodoasignacioncitaid()
    {
        return $this->metodoasignacioncitaid;
    }

    /**
     * Set nivelid
     *
     * @param \AppBundle\Entity\Nivel $nivelid
     *
     * @return AdBloquegrado
     */
    public function setNivelid(\AppBundle\Entity\Nivel $nivelid = null)
    {
        $this->nivelid = $nivelid;

        return $this;
    }

    /**
     * Get nivelid
     *
     * @return \AppBundle\Entity\Nivel
     */
    public function getNivelid()
    {
        return $this->nivelid;
    }
}

