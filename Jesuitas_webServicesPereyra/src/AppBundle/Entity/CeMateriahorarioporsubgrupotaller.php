<?php

namespace AppBundle\Entity;

/**
 * CeMateriahorarioporsubgrupotaller
 */
class CeMateriahorarioporsubgrupotaller
{
    /**
     * @var string
     */
    private $salon;

    /**
     * @var integer
     */
    private $materiahorariosubgrupotallerid;

    /**
     * @var \AppBundle\Entity\CeMateriaporhorario
     */
    private $materiaporhorarioid;

    /**
     * @var \AppBundle\Entity\CeProfesorpormateriaplanestudios
     */
    private $profesorpormateriaplanestudiosid;


    /**
     * Set salon
     *
     * @param string $salon
     *
     * @return CeMateriahorarioporsubgrupotaller
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
     * Get materiahorariosubgrupotallerid
     *
     * @return integer
     */
    public function getMateriahorariosubgrupotallerid()
    {
        return $this->materiahorariosubgrupotallerid;
    }

    /**
     * Set materiaporhorarioid
     *
     * @param \AppBundle\Entity\CeMateriaporhorario $materiaporhorarioid
     *
     * @return CeMateriahorarioporsubgrupotaller
     */
    public function setMateriaporhorarioid(\AppBundle\Entity\CeMateriaporhorario $materiaporhorarioid = null)
    {
        $this->materiaporhorarioid = $materiaporhorarioid;

        return $this;
    }

    /**
     * Get materiaporhorarioid
     *
     * @return \AppBundle\Entity\CeMateriaporhorario
     */
    public function getMateriaporhorarioid()
    {
        return $this->materiaporhorarioid;
    }

    /**
     * Set profesorpormateriaplanestudiosid
     *
     * @param \AppBundle\Entity\CeProfesorpormateriaplanestudios $profesorpormateriaplanestudiosid
     *
     * @return CeMateriahorarioporsubgrupotaller
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

