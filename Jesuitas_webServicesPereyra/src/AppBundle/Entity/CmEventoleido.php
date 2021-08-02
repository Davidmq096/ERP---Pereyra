<?php

namespace AppBundle\Entity;

/**
 * CmEventoleido
 */
class CmEventoleido
{
    /**
     * @var boolean
     */
    private $leido = '0';

    /**
     * @var integer
     */
    private $id;

    /**
     * @var integer
     */
    private $tipo;

    /**
     * @var integer
     */
    private $eventoleidoid;

    /**
     * @var \AppBundle\Entity\CeAlumno
     */
    private $alumnoid;

    /**
     * @var \AppBundle\Entity\CeEvento
     */
    private $eventoid;

    /**
     * @var \AppBundle\Entity\CeEventopornivel
     */
    private $eventopornivelid;


    /**
     * Set leido
     *
     * @param boolean $leido
     *
     * @return CmEventoleido
     */
    public function setLeido($leido)
    {
        $this->leido = $leido;

        return $this;
    }

    /**
     * Get leido
     *
     * @return boolean
     */
    public function getLeido()
    {
        return $this->leido;
    }

    /**
     * Set id
     *
     * @param integer $id
     *
     * @return CmEventoleido
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set tipo
     *
     * @param integer $tipo
     *
     * @return CmEventoleido
     */
    public function setTipo($tipo)
    {
        $this->tipo = $tipo;

        return $this;
    }

    /**
     * Get tipo
     *
     * @return integer
     */
    public function getTipo()
    {
        return $this->tipo;
    }

    /**
     * Get eventoleidoid
     *
     * @return integer
     */
    public function getEventoleidoid()
    {
        return $this->eventoleidoid;
    }

    /**
     * Set alumnoid
     *
     * @param \AppBundle\Entity\CeAlumno $alumnoid
     *
     * @return CmEventoleido
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
     * Set eventoid
     *
     * @param \AppBundle\Entity\CeEvento $eventoid
     *
     * @return CmEventoleido
     */
    public function setEventoid(\AppBundle\Entity\CeEvento $eventoid = null)
    {
        $this->eventoid = $eventoid;

        return $this;
    }

    /**
     * Get eventoid
     *
     * @return \AppBundle\Entity\CeEvento
     */
    public function getEventoid()
    {
        return $this->eventoid;
    }

    /**
     * Set eventopornivelid
     *
     * @param \AppBundle\Entity\CeEventopornivel $eventopornivelid
     *
     * @return CmEventoleido
     */
    public function setEventopornivelid(\AppBundle\Entity\CeEventopornivel $eventopornivelid = null)
    {
        $this->eventopornivelid = $eventopornivelid;

        return $this;
    }

    /**
     * Get eventopornivelid
     *
     * @return \AppBundle\Entity\CeEventopornivel
     */
    public function getEventopornivelid()
    {
        return $this->eventopornivelid;
    }
}

