<?php

namespace AppBundle\Entity;

/**
 * CeMateriaporhorario
 */
class CeMateriaporhorario
{
    /**
     * @var integer
     */
    private $dia;

    /**
     * @var string
     */
    private $salon;

    /**
     * @var integer
     */
    private $materiaporhorarioid;

    /**
     * @var \AppBundle\Entity\CeConfiguracionhorario
     */
    private $configuracionhorarioid;

    /**
     * @var \AppBundle\Entity\CeGrupo
     */
    private $grupoid;

    /**
     * @var \AppBundle\Entity\CeProfesorpormateriaplanestudios
     */
    private $profesorpormateriaplanestudiosid;


    /**
     * Set dia
     *
     * @param integer $dia
     *
     * @return CeMateriaporhorario
     */
    public function setDia($dia)
    {
        $this->dia = $dia;

        return $this;
    }

    /**
     * Get dia
     *
     * @return integer
     */
    public function getDia()
    {
        return $this->dia;
    }

    /**
     * Set salon
     *
     * @param string $salon
     *
     * @return CeMateriaporhorario
     */
    public function setSalon($salon)
    {
        $this->salon = $salon;

        return $this;
    }

    /**
     * Get salon
     *
     * @return string
     */
    public function getSalon()
    {
        return $this->salon;
    }

    /**
     * Get materiaporhorarioid
     *
     * @return integer
     */
    public function getMateriaporhorarioid()
    {
        return $this->materiaporhorarioid;
    }

    /**
     * Set configuracionhorarioid
     *
     * @param \AppBundle\Entity\CeConfiguracionhorario $configuracionhorarioid
     *
     * @return CeMateriaporhorario
     */
    public function setConfiguracionhorarioid(\AppBundle\Entity\CeConfiguracionhorario $configuracionhorarioid = null)
    {
        $this->configuracionhorarioid = $configuracionhorarioid;

        return $this;
    }

    /**
     * Get configuracionhorarioid
     *
     * @return \AppBundle\Entity\CeConfiguracionhorario
     */
    public function getConfiguracionhorarioid()
    {
        return $this->configuracionhorarioid;
    }

    /**
     * Set grupoid
     *
     * @param \AppBundle\Entity\CeGrupo $grupoid
     *
     * @return CeMateriaporhorario
     */
    public function setGrupoid(\AppBundle\Entity\CeGrupo $grupoid = null)
    {
        $this->grupoid = $grupoid;

        return $this;
    }

    /**
     * Get grupoid
     *
     * @return \AppBundle\Entity\CeGrupo
     */
    public function getGrupoid()
    {
        return $this->grupoid;
    }

    /**
     * Set profesorpormateriaplanestudiosid
     *
     * @param \AppBundle\Entity\CeProfesorpormateriaplanestudios $profesorpormateriaplanestudiosid
     *
     * @return CeMateriaporhorario
     */
    public function setProfesorpormateriaplanestudiosid(\AppBundle\Entity\CeProfesorpormateriaplanestudios $profesorpormateriaplanestudiosid = null)
    {
        $this->profesorpormateriaplanestudiosid = $profesorpormateriaplanestudiosid;

        return $this;
    }

    /**
     * Get profesorpormateriaplanestudiosid
     *
     * @return \AppBundle\Entity\CeProfesorpormateriaplanestudios
     */
    public function getProfesorpormateriaplanestudiosid()
    {
        return $this->profesorpormateriaplanestudiosid;
    }
}

