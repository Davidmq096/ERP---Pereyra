<?php

namespace AppBundle\Entity;

/**
 * CeAntecedentefamiliarpordatomedico
 */
class CeAntecedentefamiliarpordatomedico
{
    /**
     * @var integer
     */
    private $antecedentefamiliarpordatomedicoid;

    /**
     * @var \AppBundle\Entity\CeAlumnodatomedico
     */
    private $alumnodatomedicoid;

    /**
     * @var \AppBundle\Entity\Antecedentefamiliarimportante
     */
    private $antecedentefamiliarimportanteid;


    /**
     * Get antecedentefamiliarpordatomedicoid
     *
     * @return integer
     */
    public function getAntecedentefamiliarpordatomedicoid()
    {
        return $this->antecedentefamiliarpordatomedicoid;
    }

    /**
     * Set alumnodatomedicoid
     *
     * @param \AppBundle\Entity\CeAlumnodatomedico $alumnodatomedicoid
     *
     * @return CeAntecedentefamiliarpordatomedico
     */
    public function setAlumnodatomedicoid(\AppBundle\Entity\CeAlumnodatomedico $alumnodatomedicoid = null)
    {
        $this->alumnodatomedicoid = $alumnodatomedicoid;

        return $this;
    }

    /**
     * Get alumnodatomedicoid
     *
     * @return \AppBundle\Entity\CeAlumnodatomedico
     */
    public function getAlumnodatomedicoid()
    {
        return $this->alumnodatomedicoid;
    }

    /**
     * Set antecedentefamiliarimportanteid
     *
     * @param \AppBundle\Entity\Antecedentefamiliarimportante $antecedentefamiliarimportanteid
     *
     * @return CeAntecedentefamiliarpordatomedico
     */
    public function setAntecedentefamiliarimportanteid(\AppBundle\Entity\Antecedentefamiliarimportante $antecedentefamiliarimportanteid = null)
    {
        $this->antecedentefamiliarimportanteid = $antecedentefamiliarimportanteid;

        return $this;
    }

    /**
     * Get antecedentefamiliarimportanteid
     *
     * @return \AppBundle\Entity\Antecedentefamiliarimportante
     */
    public function getAntecedentefamiliarimportanteid()
    {
        return $this->antecedentefamiliarimportanteid;
    }
}

