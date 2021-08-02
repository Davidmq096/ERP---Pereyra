<?php

namespace AppBundle\Entity;

/**
 * CeMotivoextraordinarioporextraordinario
 */
class CeMotivoextraordinarioporextraordinario
{
    /**
     * @var integer
     */
    private $motivoextraordinarioporextraordinarioid;

    /**
     * @var \AppBundle\Entity\CeExtraordinario
     */
    private $extraordinarioid;

    /**
     * @var \AppBundle\Entity\CeMotivoextraordinario
     */
    private $motivoextraordinarioid;


    /**
     * Get motivoextraordinarioporextraordinarioid
     *
     * @return integer
     */
    public function getMotivoextraordinarioporextraordinarioid()
    {
        return $this->motivoextraordinarioporextraordinarioid;
    }

    /**
     * Set extraordinarioid
     *
     * @param \AppBundle\Entity\CeExtraordinario $extraordinarioid
     *
     * @return CeMotivoextraordinarioporextraordinario
     */
    public function setExtraordinarioid(\AppBundle\Entity\CeExtraordinario $extraordinarioid = null)
    {
        $this->extraordinarioid = $extraordinarioid;

        return $this;
    }

    /**
     * Get extraordinarioid
     *
     * @return \AppBundle\Entity\CeExtraordinario
     */
    public function getExtraordinarioid()
    {
        return $this->extraordinarioid;
    }

    /**
     * Set motivoextraordinarioid
     *
     * @param \AppBundle\Entity\CeMotivoextraordinario $motivoextraordinarioid
     *
     * @return CeMotivoextraordinarioporextraordinario
     */
    public function setMotivoextraordinarioid(\AppBundle\Entity\CeMotivoextraordinario $motivoextraordinarioid = null)
    {
        $this->motivoextraordinarioid = $motivoextraordinarioid;

        return $this;
    }

    /**
     * Get motivoextraordinarioid
     *
     * @return \AppBundle\Entity\CeMotivoextraordinario
     */
    public function getMotivoextraordinarioid()
    {
        return $this->motivoextraordinarioid;
    }
}

