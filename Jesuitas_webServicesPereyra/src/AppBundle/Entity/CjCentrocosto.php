<?php

namespace AppBundle\Entity;

/**
 * CjCentrocosto
 */
class CjCentrocosto
{
    /**
     * @var string
     */
    private $nombre;

    /**
     * @var string
     */
    private $alias;

    /**
     * @var boolean
     */
    private $activo;

    /**
     * @var integer
     */
    private $centrocostoid;

    /**
     * @var \AppBundle\Entity\CjEmpresa
     */
    private $empresaid;


    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return CjCentrocosto
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
     * Set alias
     *
     * @param string $alias
     *
     * @return CjCentrocosto
     */
    public function setAlias($alias)
    {
        $this->alias = $alias;

        return $this;
    }

    /**
     * Get alias
     *
     * @return string
     */
    public function getAlias()
    {
        return $this->alias;
    }

    /**
     * Set activo
     *
     * @param boolean $activo
     *
     * @return CjCentrocosto
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
     * Get centrocostoid
     *
     * @return integer
     */
    public function getCentrocostoid()
    {
        return $this->centrocostoid;
    }

    /**
     * Set empresaid
     *
     * @param \AppBundle\Entity\CjEmpresa $empresaid
     *
     * @return CjCentrocosto
     */
    public function setEmpresaid(\AppBundle\Entity\CjEmpresa $empresaid = null)
    {
        $this->empresaid = $empresaid;

        return $this;
    }

    /**
     * Get empresaid
     *
     * @return \AppBundle\Entity\CjEmpresa
     */
    public function getEmpresaid()
    {
        return $this->empresaid;
    }
}

