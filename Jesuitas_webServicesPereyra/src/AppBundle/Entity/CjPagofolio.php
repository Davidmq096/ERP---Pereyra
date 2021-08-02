<?php

namespace AppBundle\Entity;

/**
 * CjPagofolio
 */
class CjPagofolio
{
    /**
     * @var string
     */
    private $folio;

    /**
     * @var integer
     */
    private $pagofolioid;


    /**
     * Set folio
     *
     * @param string $folio
     *
     * @return CjPagofolio
     */
    public function setFolio($folio)
    {
        $this->folio = $folio;

        return $this;
    }

    /**
     * Get folio
     *
     * @return string
     */
    public function getFolio()
    {
        return $this->folio;
    }

    /**
     * Get pagofolioid
     *
     * @return integer
     */
    public function getPagofolioid()
    {
        return $this->pagofolioid;
    }
}

