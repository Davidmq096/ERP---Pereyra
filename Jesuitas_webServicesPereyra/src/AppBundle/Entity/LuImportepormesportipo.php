<?php

namespace AppBundle\Entity;

/**
 * LuImportepormesportipo
 */
class LuImportepormesportipo
{
    /**
     * @var integer
     */
    private $mes;

    /**
     * @var float
     */
    private $importe;

    /**
     * @var integer
     */
    private $importepormesportipoid;

    /**
     * @var \AppBundle\Entity\LuTipo
     */
    private $tipoid;


    /**
     * Set mes
     *
     * @param integer $mes
     *
     * @return LuImportepormesportipo
     */
    public function setMes($mes)
    {
        $this->mes = $mes;

        return $this;
    }

    /**
     * Get mes
     *
     * @return integer
     */
    public function getMes()
    {
        return $this->mes;
    }

    /**
     * Set importe
     *
     * @param float $importe
     *
     * @return LuImportepormesportipo
     */
    public function setImporte($importe)
    {
        $this->importe = $importe;

        return $this;
    }

    /**
     * Get importe
     *
     * @return float
     */
    public function getImporte()
    {
        return $this->importe;
    }

    /**
     * Get importepormesportipoid
     *
     * @return integer
     */
    public function getImportepormesportipoid()
    {
        return $this->importepormesportipoid;
    }

    /**
     * Set tipoid
     *
     * @param \AppBundle\Entity\LuTipo $tipoid
     *
     * @return LuImportepormesportipo
     */
    public function setTipoid(\AppBundle\Entity\LuTipo $tipoid = null)
    {
        $this->tipoid = $tipoid;

        return $this;
    }

    /**
     * Get tipoid
     *
     * @return \AppBundle\Entity\LuTipo
     */
    public function getTipoid()
    {
        return $this->tipoid;
    }
}

