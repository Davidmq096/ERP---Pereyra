<?php

namespace AppBundle\Entity;

/**
 * TpContrato
 */
class TpContrato
{
    /**
     * @var \DateTime
     */
    private $vigenciainicio;

    /**
     * @var \DateTime
     */
    private $vigenciafin;

    /**
     * @var integer
     */
    private $contratoid;

    /**
     * @var \AppBundle\Entity\Ciclo
     */
    private $cicloid;

    /**
     * @var \AppBundle\Entity\CeClavefamiliar
     */
    private $clavefamiliarid;

    /**
     * @var \AppBundle\Entity\CePadresotutores
     */
    private $padreotutorid;


    /**
     * Set vigenciainicio
     *
     * @param \DateTime $vigenciainicio
     *
     * @return TpContrato
     */
    public function setVigenciainicio($vigenciainicio)
    {
        $this->vigenciainicio = $vigenciainicio;

        return $this;
    }

    /**
     * Get vigenciainicio
     *
     * @return \DateTime
     */
    public function getVigenciainicio()
    {
        return $this->vigenciainicio;
    }

    /**
     * Set vigenciafin
     *
     * @param \DateTime $vigenciafin
     *
     * @return TpContrato
     */
    public function setVigenciafin($vigenciafin)
    {
        $this->vigenciafin = $vigenciafin;

        return $this;
    }

    /**
     * Get vigenciafin
     *
     * @return \DateTime
     */
    public function getVigenciafin()
    {
        return $this->vigenciafin;
    }

    /**
     * Get contratoid
     *
     * @return integer
     */
    public function getContratoid()
    {
        return $this->contratoid;
    }

    /**
     * Set cicloid
     *
     * @param \AppBundle\Entity\Ciclo $cicloid
     *
     * @return TpContrato
     */
    public function setCicloid(\AppBundle\Entity\Ciclo $cicloid = null)
    {
        $this->cicloid = $cicloid;

        return $this;
    }

    /**
     * Get cicloid
     *
     * @return \AppBundle\Entity\Ciclo
     */
    public function getCicloid()
    {
        return $this->cicloid;
    }

    /**
     * Set clavefamiliarid
     *
     * @param \AppBundle\Entity\CeClavefamiliar $clavefamiliarid
     *
     * @return TpContrato
     */
    public function setClavefamiliarid(\AppBundle\Entity\CeClavefamiliar $clavefamiliarid = null)
    {
        $this->clavefamiliarid = $clavefamiliarid;

        return $this;
    }

    /**
     * Get clavefamiliarid
     *
     * @return \AppBundle\Entity\CeClavefamiliar
     */
    public function getClavefamiliarid()
    {
        return $this->clavefamiliarid;
    }

    /**
     * Set padreotutorid
     *
     * @param \AppBundle\Entity\CePadresotutores $padreotutorid
     *
     * @return TpContrato
     */
    public function setPadreotutorid(\AppBundle\Entity\CePadresotutores $padreotutorid = null)
    {
        $this->padreotutorid = $padreotutorid;

        return $this;
    }

    /**
     * Get padreotutorid
     *
     * @return \AppBundle\Entity\CePadresotutores
     */
    public function getPadreotutorid()
    {
        return $this->padreotutorid;
    }
}

