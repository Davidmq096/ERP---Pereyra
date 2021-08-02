<?php

namespace AppBundle\Entity;

/**
 * CeMateriahorarioporhorario
 */
class CeMateriahorarioporhorario
{
    /**
     * @var integer
     */
    private $materiahorarioporhorarioid;

    /**
     * @var \AppBundle\Entity\CeHorario
     */
    private $horarioid;

    /**
     * @var \AppBundle\Entity\CeMateriaporhorario
     */
    private $materiahorarioid;


    /**
     * Get materiahorarioporhorarioid
     *
     * @return integer
     */
    public function getMateriahorarioporhorarioid()
    {
        return $this->materiahorarioporhorarioid;
    }

    /**
     * Set horarioid
     *
     * @param \AppBundle\Entity\CeHorario $horarioid
     *
     * @return CeMateriahorarioporhorario
     */
    public function setHorarioid(\AppBundle\Entity\CeHorario $horarioid = null)
    {
        $this->horarioid = $horarioid;

        return $this;
    }

    /**
     * Get horarioid
     *
     * @return \AppBundle\Entity\CeHorario
     */
    public function getHorarioid()
    {
        return $this->horarioid;
    }

    /**
     * Set materiahorarioid
     *
     * @param \AppBundle\Entity\CeMateriaporhorario $materiahorarioid
     *
     * @return CeMateriahorarioporhorario
     */
    public function setMateriahorarioid(\AppBundle\Entity\CeMateriaporhorario $materiahorarioid = null)
    {
        $this->materiahorarioid = $materiahorarioid;

        return $this;
    }

    /**
     * Get materiahorarioid
     *
     * @return \AppBundle\Entity\CeMateriaporhorario
     */
    public function getMateriahorarioid()
    {
        return $this->materiahorarioid;
    }
}

