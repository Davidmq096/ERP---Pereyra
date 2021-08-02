<?php

namespace AppBundle\Entity;

/**
 * CjConceptopornivel
 */
class CjConceptopornivel
{
    /**
     * @var integer
     */
    private $conceptopornivelid;

    /**
     * @var \AppBundle\Entity\CjConcepto
     */
    private $conceptoid;

    /**
     * @var \AppBundle\Entity\Nivel
     */
    private $nivelid;


    /**
     * Get conceptopornivelid
     *
     * @return integer
     */
    public function getConceptopornivelid()
    {
        return $this->conceptopornivelid;
    }

    /**
     * Set conceptoid
     *
     * @param \AppBundle\Entity\CjConcepto $conceptoid
     *
     * @return CjConceptopornivel
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
     * Set nivelid
     *
     * @param \AppBundle\Entity\Nivel $nivelid
     *
     * @return CjConceptopornivel
     */
    public function setNivelid(\AppBundle\Entity\Nivel $nivelid = null)
    {
        $this->nivelid = $nivelid;

        return $this;
    }

    /**
     * Get nivelid
     *
     * @return \AppBundle\Entity\Nivel
     */
    public function getNivelid()
    {
        return $this->nivelid;
    }
}

