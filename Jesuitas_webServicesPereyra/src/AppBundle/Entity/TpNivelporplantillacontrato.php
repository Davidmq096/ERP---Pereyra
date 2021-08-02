<?php

namespace AppBundle\Entity;

/**
 * TpNivelporplantillacontrato
 */
class TpNivelporplantillacontrato
{
    /**
     * @var integer
     */
    private $nivelporplantillacontratoid;

    /**
     * @var \AppBundle\Entity\Nivel
     */
    private $nivelid;

    /**
     * @var \AppBundle\Entity\TpPlantillacontrato
     */
    private $plantillacontratoid;


    /**
     * Get nivelporplantillacontratoid
     *
     * @return integer
     */
    public function getNivelporplantillacontratoid()
    {
        return $this->nivelporplantillacontratoid;
    }

    /**
     * Set nivelid
     *
     * @param \AppBundle\Entity\Nivel $nivelid
     *
     * @return TpNivelporplantillacontrato
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

    /**
     * Set plantillacontratoid
     *
     * @param \AppBundle\Entity\TpPlantillacontrato $plantillacontratoid
     *
     * @return TpNivelporplantillacontrato
     */
    public function setPlantillacontratoid(\AppBundle\Entity\TpPlantillacontrato $plantillacontratoid = null)
    {
        $this->plantillacontratoid = $plantillacontratoid;

        return $this;
    }

    /**
     * Get plantillacontratoid
     *
     * @return \AppBundle\Entity\TpPlantillacontrato
     */
    public function getPlantillacontratoid()
    {
        return $this->plantillacontratoid;
    }
}

