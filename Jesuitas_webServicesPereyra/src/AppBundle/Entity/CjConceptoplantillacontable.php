<?php

namespace AppBundle\Entity;

/**
 * CjConceptoplantillacontable
 */
class CjConceptoplantillacontable
{
    /**
     * @var boolean
     */
    private $tipomovimientoid;

    /**
     * @var string
     */
    private $porcentaje;

    /**
     * @var integer
     */
    private $tipoplantilla;

    /**
     * @var integer
     */
    private $conceptoplantillacontableid;

    /**
     * @var \AppBundle\Entity\CjCentrocosto
     */
    private $centrocostoid;

    /**
     * @var \AppBundle\Entity\CjConcepto
     */
    private $conceptoid;

    /**
     * @var \AppBundle\Entity\CjCuentacontable
     */
    private $cuentacontableid;


    /**
     * Set tipomovimientoid
     *
     * @param boolean $tipomovimientoid
     *
     * @return CjConceptoplantillacontable
     */
    public function setTipomovimientoid($tipomovimientoid)
    {
        $this->tipomovimientoid = $tipomovimientoid;

        return $this;
    }

    /**
     * Get tipomovimientoid
     *
     * @return boolean
     */
    public function getTipomovimientoid()
    {
        return $this->tipomovimientoid;
    }

    /**
     * Set porcentaje
     *
     * @param string $porcentaje
     *
     * @return CjConceptoplantillacontable
     */
    public function setPorcentaje($porcentaje)
    {
        $this->porcentaje = $porcentaje;

        return $this;
    }

    /**
     * Get porcentaje
     *
     * @return string
     */
    public function getPorcentaje()
    {
        return $this->porcentaje;
    }

    /**
     * Set tipoplantilla
     *
     * @param integer $tipoplantilla
     *
     * @return CjConceptoplantillacontable
     */
    public function setTipoplantilla($tipoplantilla)
    {
        $this->tipoplantilla = $tipoplantilla;

        return $this;
    }

    /**
     * Get tipoplantilla
     *
     * @return integer
     */
    public function getTipoplantilla()
    {
        return $this->tipoplantilla;
    }

    /**
     * Get conceptoplantillacontableid
     *
     * @return integer
     */
    public function getConceptoplantillacontableid()
    {
        return $this->conceptoplantillacontableid;
    }

    /**
     * Set centrocostoid
     *
     * @param \AppBundle\Entity\CjCentrocosto $centrocostoid
     *
     * @return CjConceptoplantillacontable
     */
    public function setCentrocostoid(\AppBundle\Entity\CjCentrocosto $centrocostoid = null)
    {
        $this->centrocostoid = $centrocostoid;

        return $this;
    }

    /**
     * Get centrocostoid
     *
     * @return \AppBundle\Entity\CjCentrocosto
     */
    public function getCentrocostoid()
    {
        return $this->centrocostoid;
    }

    /**
     * Set conceptoid
     *
     * @param \AppBundle\Entity\CjConcepto $conceptoid
     *
     * @return CjConceptoplantillacontable
     */
    public function setConceptoid(\AppBundle\Entity\CjConcepto $conceptoid = null)
    {
        $this->conceptoid = $conceptoid;

        return $this;
    }

    /**
     * Get conceptoid
     *
     * @return \AppBundle\Entity\CjConcepto
     */
    public function getConceptoid()
    {
        return $this->conceptoid;
    }

    /**
     * Set cuentacontableid
     *
     * @param \AppBundle\Entity\CjCuentacontable $cuentacontableid
     *
     * @return CjConceptoplantillacontable
     */
    public function setCuentacontableid(\AppBundle\Entity\CjCuentacontable $cuentacontableid = null)
    {
        $this->cuentacontableid = $cuentacontableid;

        return $this;
    }

    /**
     * Get cuentacontableid
     *
     * @return \AppBundle\Entity\CjCuentacontable
     */
    public function getCuentacontableid()
    {
        return $this->cuentacontableid;
    }
}

