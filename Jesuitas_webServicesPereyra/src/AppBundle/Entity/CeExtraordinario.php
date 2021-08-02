<?php

namespace AppBundle\Entity;

/**
 * CeExtraordinario
 */
class CeExtraordinario
{
    /**
     * @var integer
     */
    private $extraordinarioid;

    /**
     * @var \AppBundle\Entity\CeAlumno
     */
    private $alumnoid;

    /**
     * @var \AppBundle\Entity\CeEstatusextraordinario
     */
    private $estatusextraordinarioid;

    /**
     * @var \AppBundle\Entity\CeProfesorpormateriaplanestudios
     */
    private $profesorpormateriaplanestudiosid;


    /**
     * Get extraordinarioid
     *
     * @return integer
     */
    public function getExtraordinarioid()
    {
        return $this->extraordinarioid;
    }

    /**
     * Set alumnoid
     *
     * @param \AppBundle\Entity\CeAlumno $alumnoid
     *
     * @return CeExtraordinario
     */
    public function setAlumnoid(\AppBundle\Entity\CeAlumno $alumnoid = null)
    {
        $this->alumnoid = $alumnoid;

        return $this;
    }

    /**
     * Get alumnoid
     *
     * @return \AppBundle\Entity\CeAlumno
     */
    public function getAlumnoid()
    {
        return $this->alumnoid;
    }

    /**
     * Set estatusextraordinarioid
     *
     * @param \AppBundle\Entity\CeEstatusextraordinario $estatusextraordinarioid
     *
     * @return CeExtraordinario
     */
    public function setEstatusextraordinarioid(\AppBundle\Entity\CeEstatusextraordinario $estatusextraordinarioid = null)
    {
        $this->estatusextraordinarioid = $estatusextraordinarioid;

        return $this;
    }

    /**
     * Get estatusextraordinarioid
     *
     * @return \AppBundle\Entity\CeEstatusextraordinario
     */
    public function getEstatusextraordinarioid()
    {
        return $this->estatusextraordinarioid;
    }

    /**
     * Set profesorpormateriaplanestudiosid
     *
     * @param \AppBundle\Entity\CeProfesorpormateriaplanestudios $profesorpormateriaplanestudiosid
     *
     * @return CeExtraordinario
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

