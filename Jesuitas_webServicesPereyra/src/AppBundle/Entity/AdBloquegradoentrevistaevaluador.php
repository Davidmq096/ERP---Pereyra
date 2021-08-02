<?php

namespace AppBundle\Entity;

/**
 * AdBloquegradoentrevistaevaluador
 */
class AdBloquegradoentrevistaevaluador
{
    /**
     * @var string
     */
    private $casillasbloqueadas;

    /**
     * @var integer
     */
    private $bloquegradoentrevistaevaluadorid;

    /**
     * @var \AppBundle\Entity\AdBloquegradoentrevista
     */
    private $bloquegradoentrevistaid;

    /**
     * @var \AppBundle\Entity\Lugar
     */
    private $lugarid;

    /**
     * @var \AppBundle\Entity\Usuario
     */
    private $usuarioid;


    /**
     * Set casillasbloqueadas
     *
     * @param string $casillasbloqueadas
     *
     * @return AdBloquegradoentrevistaevaluador
     */
    public function setCasillasbloqueadas($casillasbloqueadas)
    {
        $this->casillasbloqueadas = $casillasbloqueadas;

        return $this;
    }

    /**
     * Get casillasbloqueadas
     *
     * @return string
     */
    public function getCasillasbloqueadas()
    {
        return $this->casillasbloqueadas;
    }

    /**
     * Get bloquegradoentrevistaevaluadorid
     *
     * @return integer
     */
    public function getBloquegradoentrevistaevaluadorid()
    {
        return $this->bloquegradoentrevistaevaluadorid;
    }

    /**
     * Set bloquegradoentrevistaid
     *
     * @param \AppBundle\Entity\AdBloquegradoentrevista $bloquegradoentrevistaid
     *
     * @return AdBloquegradoentrevistaevaluador
     */
    public function setBloquegradoentrevistaid(\AppBundle\Entity\AdBloquegradoentrevista $bloquegradoentrevistaid = null)
    {
        $this->bloquegradoentrevistaid = $bloquegradoentrevistaid;

        return $this;
    }

    /**
     * Get bloquegradoentrevistaid
     *
     * @return \AppBundle\Entity\AdBloquegradoentrevista
     */
    public function getBloquegradoentrevistaid()
    {
        return $this->bloquegradoentrevistaid;
    }

    /**
     * Set lugarid
     *
     * @param \AppBundle\Entity\Lugar $lugarid
     *
     * @return AdBloquegradoentrevistaevaluador
     */
    public function setLugarid(\AppBundle\Entity\Lugar $lugarid = null)
    {
        $this->lugarid = $lugarid;

        return $this;
    }

    /**
     * Get lugarid
     *
     * @return \AppBundle\Entity\Lugar
     */
    public function getLugarid()
    {
        return $this->lugarid;
    }

    /**
     * Set usuarioid
     *
     * @param \AppBundle\Entity\Usuario $usuarioid
     *
     * @return AdBloquegradoentrevistaevaluador
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

