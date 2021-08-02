<?php

namespace AppBundle\Entity;

/**
 * Datomedicoantecedente
 */
class Datomedicoantecedente
{
    /**
     * @var integer
     */
    private $datomedicoantecedenteid;

    /**
     * @var \AppBundle\Entity\Antecedentefamiliarimportante
     */
    private $antecedentefamiliarimportanteid;

    /**
     * @var \AppBundle\Entity\Datomedico
     */
    private $datomedicoid;


    /**
     * Get datomedicoantecedenteid
     *
     * @return integer
     */
    public function getDatomedicoantecedenteid()
    {
        return $this->datomedicoantecedenteid;
    }

    /**
     * Set antecedentefamiliarimportanteid
     *
     * @param \AppBundle\Entity\Antecedentefamiliarimportante $antecedentefamiliarimportanteid
     *
     * @return Datomedicoantecedente
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

    /**
     * Set datomedicoid
     *
     * @param \AppBundle\Entity\Datomedico $datomedicoid
     *
     * @return Datomedicoantecedente
     */
    public function setDatomedicoid(\AppBundle\Entity\Datomedico $datomedicoid = null)
    {
        $this->datomedicoid = $datomedicoid;

        return $this;
    }

    /**
     * Get datomedicoid
     *
     * @return \AppBundle\Entity\Datomedico
     */
    public function getDatomedicoid()
    {
        return $this->datomedicoid;
    }
}

