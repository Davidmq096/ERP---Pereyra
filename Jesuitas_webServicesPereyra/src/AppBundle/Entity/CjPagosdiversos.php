<?php

namespace AppBundle\Entity;

/**
 * CjPagosdiversos
 */
class CjPagosdiversos
{
    /**
     * @var \DateTime
     */
    private $fechahora;

    /**
     * @var string
     */
    private $descripcion;

    /**
     * @var integer
     */
    private $pagodiversoid;

    /**
     * @var \AppBundle\Entity\CjSubconcepto
     */
    private $subconceptoid;

    /**
     * @var \AppBundle\Entity\Usuario
     */
    private $usuarioid;


    /**
     * Set fechahora
     *
     * @param \DateTime $fechahora
     *
     * @return CjPagosdiversos
     */
    public function setFechahora($fechahora)
    {
        $this->fechahora = $fechahora;

        return $this;
    }

    /**
     * Get fechahora
     *
     * @return \DateTime
     */
    public function getFechahora()
    {
        return $this->fechahora;
    }

    /**
     * Set descripcion
     *
     * @param string $descripcion
     *
     * @return CjPagosdiversos
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
     * Get pagodiversoid
     *
     * @return integer
     */
    public function getPagodiversoid()
    {
        return $this->pagodiversoid;
    }

    /**
     * Set subconceptoid
     *
     * @param \AppBundle\Entity\CjSubconcepto $subconceptoid
     *
     * @return CjPagosdiversos
     */
    public function setSubconceptoid(\AppBundle\Entity\CjSubconcepto $subconceptoid = null)
    {
        $this->subconceptoid = $subconceptoid;

        return $this;
    }

    /**
     * Get subconceptoid
     *
     * @return \AppBundle\Entity\CjSubconcepto
     */
    public function getSubconceptoid()
    {
        return $this->subconceptoid;
    }

    /**
     * Set usuarioid
     *
     * @param \AppBundle\Entity\Usuario $usuarioid
     *
     * @return CjPagosdiversos
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

