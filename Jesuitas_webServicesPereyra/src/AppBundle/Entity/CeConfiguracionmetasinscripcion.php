<?php

namespace AppBundle\Entity;

/**
 * CeConfiguracionmetasinscripcion
 */
class CeConfiguracionmetasinscripcion
{
    /**
     * @var integer
     */
    private $meta;

    /**
     * @var integer
     */
    private $configuracionmetainscripcionid;

    /**
     * @var \AppBundle\Entity\Grado
     */
    private $gradoid;

    /**
     * @var \AppBundle\Entity\Ciclo
     */
    private $cicloid;


    /**
     * Set meta
     *
     * @param integer $meta
     *
     * @return CeConfiguracionmetasinscripcion
     */
    public function setMeta($meta)
    {
        $this->meta = $meta;

        return $this;
    }

    /**
     * Get meta
     *
     * @return integer
     */
    public function getMeta()
    {
        return $this->meta;
    }

    /**
     * Get configuracionmetainscripcionid
     *
     * @return integer
     */
    public function getConfiguracionmetainscripcionid()
    {
        return $this->configuracionmetainscripcionid;
    }

    /**
     * Set gradoid
     *
     * @param \AppBundle\Entity\Grado $gradoid
     *
     * @return CeConfiguracionmetasinscripcion
     */
    public function setGradoid(\AppBundle\Entity\Grado $gradoid = null)
    {
        $this->gradoid = $gradoid;

        return $this;
    }

    /**
     * Get gradoid
     *
     * @return \AppBundle\Entity\Grado
     */
    public function getGradoid()
    {
        return $this->gradoid;
    }

    /**
     * Set cicloid
     *
     * @param \AppBundle\Entity\Ciclo $cicloid
     *
     * @return CeConfiguracionmetasinscripcion
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
}

