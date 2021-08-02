<?php

namespace AppBundle\Entity;

/**
 * Reporte
 */
class Reporte
{
    /**
     * @var string
     */
    private $html;

    /**
     * @var string
     */
    private $descripcion;

    /**
     * @var integer
     */
    private $reporteid;


    /**
     * Set html
     *
     * @param string $html
     *
     * @return Reporte
     */
    public function setHtml($html)
    {
        $this->html = $html;

        return $this;
    }

    /**
     * Get html
     *
     * @return string
     */
    public function getHtml()
    {
        return $this->html;
    }

    /**
     * Set descripcion
     *
     * @param string $descripcion
     *
     * @return Reporte
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
     * Get reporteid
     *
     * @return integer
     */
    public function getReporteid()
    {
        return $this->reporteid;
    }
}

