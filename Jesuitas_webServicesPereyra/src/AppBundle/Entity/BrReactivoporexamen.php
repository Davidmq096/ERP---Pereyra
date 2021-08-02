<?php

namespace AppBundle\Entity;

/**
 * BrReactivoporexamen
 */
class BrReactivoporexamen
{
    /**
     * @var integer
     */
    private $reactivoporexamenid;

    /**
     * @var \AppBundle\Entity\BrExamen
     */
    private $examenid;

    /**
     * @var \AppBundle\Entity\BrReactivo
     */
    private $reactivoid;


    /**
     * Get reactivoporexamenid
     *
     * @return integer
     */
    public function getReactivoporexamenid()
    {
        return $this->reactivoporexamenid;
    }

    /**
     * Set examenid
     *
     * @param \AppBundle\Entity\BrExamen $examenid
     *
     * @return BrReactivoporexamen
     */
    public function setExamenid(\AppBundle\Entity\BrExamen $examenid = null)
    {
        $this->examenid = $examenid;

        return $this;
    }

    /**
     * Get examenid
     *
     * @return \AppBundle\Entity\BrExamen
     */
    public function getExamenid()
    {
        return $this->examenid;
    }

    /**
     * Set reactivoid
     *
     * @param \AppBundle\Entity\BrReactivo $reactivoid
     *
     * @return BrReactivoporexamen
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

