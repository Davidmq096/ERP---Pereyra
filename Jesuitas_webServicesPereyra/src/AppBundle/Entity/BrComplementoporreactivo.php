<?php

namespace AppBundle\Entity;

/**
 * BrComplementoporreactivo
 */
class BrComplementoporreactivo
{
    /**
     * @var integer
     */
    private $orden;

    /**
     * @var integer
     */
    private $complementoporreacivoid;

    /**
     * @var \AppBundle\Entity\Complemento
     */
    private $complementoid;

    /**
     * @var \AppBundle\Entity\BrReactivo
     */
    private $reactivoid;


    /**
     * Set orden
     *
     * @param integer $orden
     *
     * @return BrComplementoporreactivo
     */
    public function setOrden($orden)
    {
        $this->orden = $orden;

        return $this;
    }

    /**
     * Get orden
     *
     * @return integer
     */
    public function getOrden()
    {
        return $this->orden;
    }

    /**
     * Get complementoporreacivoid
     *
     * @return integer
     */
    public function getComplementoporreacivoid()
    {
        return $this->complementoporreacivoid;
    }

    /**
     * Set complementoid
     *
     * @param \AppBundle\Entity\Complemento $complementoid
     *
     * @return BrComplementoporreactivo
     */
    public function setComplementoid(\AppBundle\Entity\Complemento $complementoid = null)
    {
        $this->complementoid = $complementoid;

        return $this;
    }

    /**
     * Get complementoid
     *
     * @return \AppBundle\Entity\Complemento
     */
    public function getComplementoid()
    {
        return $this->complementoid;
    }

    /**
     * Set reactivoid
     *
     * @param \AppBundle\Entity\BrReactivo $reactivoid
     *
     * @return BrComplementoporreactivo
     */
    public function setReactivoid(\AppBundle\Entity\BrReactivo $reactivoid = null)
    {
        $this->reactivoid = $reactivoid;

        return $this;
    }

    /**
     * Get reactivoid
     *
     * @return \AppBundle\Entity\BrReactivo
     */
    public function getReactivoid()
    {
        return $this->reactivoid;
    }
}

