<?php

namespace AppBundle\Entity;

/**
 * MaHigienemarcado
 */
class MaHigienemarcado
{
    /**
     * @var boolean
     */
    private $hecho;

    /**
     * @var boolean
     */
    private $archivado;

    /**
     * @var integer
     */
    private $higienemarcadoid;

    /**
     * @var \AppBundle\Entity\MaHigiene
     */
    private $higieneid;

    /**
     * @var \AppBundle\Entity\MaInforme
     */
    private $informeid;


    /**
     * Set hecho
     *
     * @param boolean $hecho
     *
     * @return MaHigienemarcado
     */
    public function setHecho($hecho)
    {
        $this->hecho = $hecho;

        return $this;
    }

    /**
     * Get hecho
     *
     * @return boolean
     */
    public function getHecho()
    {
        return $this->hecho;
    }

    /**
     * Set archivado
     *
     * @param boolean $archivado
     *
     * @return MaHigienemarcado
     */
    public function setArchivado($archivado)
    {
        $this->archivado = $archivado;

        return $this;
    }

    /**
     * Get archivado
     *
     * @return boolean
     */
    public function getArchivado()
    {
        return $this->archivado;
    }

    /**
     * Get higienemarcadoid
     *
     * @return integer
     */
    public function getHigienemarcadoid()
    {
        return $this->higienemarcadoid;
    }

    /**
     * Set higieneid
     *
     * @param \AppBundle\Entity\MaHigiene $higieneid
     *
     * @return MaHigienemarcado
     */
    public function setHigieneid(\AppBundle\Entity\MaHigiene $higieneid = null)
    {
        $this->higieneid = $higieneid;

        return $this;
    }

    /**
     * Get higieneid
     *
     * @return \AppBundle\Entity\MaHigiene
     */
    public function getHigieneid()
    {
        return $this->higieneid;
    }

    /**
     * Set informeid
     *
     * @param \AppBundle\Entity\MaInforme $informeid
     *
     * @return MaHigienemarcado
     */
    public function setInformeid(\AppBundle\Entity\MaInforme $informeid = null)
    {
        $this->informeid = $informeid;

        return $this;
    }

    /**
     * Get informeid
     *
     * @return \AppBundle\Entity\MaInforme
     */
    public function getInformeid()
    {
        return $this->informeid;
    }
}

