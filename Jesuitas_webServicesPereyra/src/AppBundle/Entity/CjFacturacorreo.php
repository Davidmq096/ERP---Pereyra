<?php

namespace AppBundle\Entity;

/**
 * CjFacturacorreo
 */
class CjFacturacorreo
{
    /**
     * @var string
     */
    private $correo;

    /**
     * @var integer
     */
    private $facturacorreoid;

    /**
     * @var \AppBundle\Entity\CjFactura
     */
    private $facturaid;


    /**
     * Set correo
     *
     * @param string $correo
     *
     * @return CjFacturacorreo
     */
    public function setCorreo($correo)
    {
        $this->correo = $correo;

        return $this;
    }

    /**
     * Get correo
     *
     * @return string
     */
    public function getCorreo()
    {
        return $this->correo;
    }

    /**
     * Get facturacorreoid
     *
     * @return integer
     */
    public function getFacturacorreoid()
    {
        return $this->facturacorreoid;
    }

    /**
     * Set facturaid
     *
     * @param \AppBundle\Entity\CjFactura $facturaid
     *
     * @return CjFacturacorreo
     */
    public function setFacturaid(\AppBundle\Entity\CjFactura $facturaid = null)
    {
        $this->facturaid = $facturaid;

        return $this;
    }

    /**
     * Get facturaid
     *
     * @return \AppBundle\Entity\CjFactura
     */
    public function getFacturaid()
    {
        return $this->facturaid;
    }
}

