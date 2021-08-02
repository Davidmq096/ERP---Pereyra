<?php

namespace AppBundle\Entity;

/**
 * CePadresotutoresclavefamiliar
 */
class CePadresotutoresclavefamiliar
{
    /**
     * @var integer
     */
    private $padresotutoresporclavefamiliar;

    /**
     * @var \AppBundle\Entity\CeClavefamiliar
     */
    private $clavefamiliarid;

    /**
     * @var \AppBundle\Entity\CePadresotutores
     */
    private $padresotutoresid;

    /**
     * @var \AppBundle\Entity\Tutor
     */
    private $tutorid;


    /**
     * Get padresotutoresporclavefamiliar
     *
     * @return integer
     */
    public function getPadresotutoresporclavefamiliar()
    {
        return $this->padresotutoresporclavefamiliar;
    }

    /**
     * Set clavefamiliarid
     *
     * @param \AppBundle\Entity\CeClavefamiliar $clavefamiliarid
     *
     * @return CePadresotutoresclavefamiliar
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
     * Set padresotutoresid
     *
     * @param \AppBundle\Entity\CePadresotutores $padresotutoresid
     *
     * @return CePadresotutoresclavefamiliar
     */
    public function setPadresotutoresid(\AppBundle\Entity\CePadresotutores $padresotutoresid = null)
    {
        $this->padresotutoresid = $padresotutoresid;

        return $this;
    }

    /**
     * Get padresotutoresid
     *
     * @return \AppBundle\Entity\CePadresotutores
     */
    public function getPadresotutoresid()
    {
        return $this->padresotutoresid;
    }

    /**
     * Set tutorid
     *
     * @param \AppBundle\Entity\Tutor $tutorid
     *
     * @return CePadresotutoresclavefamiliar
     */
    public function setTutorid(\AppBundle\Entity\Tutor $tutorid = null)
    {
        $this->tutorid = $tutorid;

        return $this;
    }

    /**
     * Get tutorid
     *
     * @return \AppBundle\Entity\Tutor
     */
    public function getTutorid()
    {
        return $this->tutorid;
    }
}

