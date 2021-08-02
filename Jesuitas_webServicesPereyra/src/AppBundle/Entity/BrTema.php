<?php

namespace AppBundle\Entity;

/**
 * BrTema
 */
class BrTema
{
    /**
     * @var string
     */
    private $nombre;

    /**
     * @var boolean
     */
    private $activo;

    /**
     * @var integer
     */
    private $temaid;

    /**
     * @var \AppBundle\Entity\CeAreaacademica
     */
    private $areaid;

    /**
     * @var \AppBundle\Entity\Materia
     */
    private $materiaid;


    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return BrTema
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * Get nombre
     *
     * @return string
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Set activo
     *
     * @param boolean $activo
     *
     * @return BrTema
     */
    public function setActivo($activo)
    {
        $this->activo = $activo;

        return $this;
    }

    /**
     * Get activo
     *
     * @return boolean
     */
    public function getActivo()
    {
        return $this->activo;
    }

    /**
     * Get temaid
     *
     * @return integer
     */
    public function getTemaid()
    {
        return $this->temaid;
    }

    /**
     * Set areaid
     *
     * @param \AppBundle\Entity\CeAreaacademica $areaid
     *
     * @return BrTema
     */
    public function setAreaid(\AppBundle\Entity\CeAreaacademica $areaid = null)
    {
        $this->areaid = $areaid;

        return $this;
    }

    /**
     * Get areaid
     *
     * @return \AppBundle\Entity\CeAreaacademica
     */
    public function getAreaid()
    {
        return $this->areaid;
    }

    /**
     * Set materiaid
     *
     * @param \AppBundle\Entity\Materia $materiaid
     *
     * @return BrTema
     */
    public function setMateriaid(\AppBundle\Entity\Materia $materiaid = null)
    {
        $this->materiaid = $materiaid;

        return $this;
    }

    /**
     * Get materiaid
     *
     * @return \AppBundle\Entity\Materia
     */
    public function getMateriaid()
    {
        return $this->materiaid;
    }
}

