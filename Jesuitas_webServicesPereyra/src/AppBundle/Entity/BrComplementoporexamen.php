<?php

namespace AppBundle\Entity;

/**
 * BrComplementoporexamen
 */
class BrComplementoporexamen
{
    /**
     * @var integer
     */
    private $complementoporexamenid;

    /**
     * @var \AppBundle\Entity\Complemento
     */
    private $complementoid;

    /**
     * @var \AppBundle\Entity\BrExamen
     */
    private $examenid;


    /**
     * Get complementoporexamenid
     *
     * @return integer
     */
    public function getComplementoporexamenid()
    {
        return $this->complementoporexamenid;
    }

    /**
     * Set complementoid
     *
     * @param \AppBundle\Entity\Complemento $complementoid
     *
     * @return BrComplementoporexamen
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
     * Set examenid
     *
     * @param \AppBundle\Entity\BrExamen $examenid
     *
     * @return BrComplementoporexamen
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
}

