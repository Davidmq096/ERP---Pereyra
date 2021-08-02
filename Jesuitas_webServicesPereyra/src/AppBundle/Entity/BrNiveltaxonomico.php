<?php

namespace AppBundle\Entity;

/**
 * BrNiveltaxonomico
 */
class BrNiveltaxonomico
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
    private $niveltaxonomicoid;


    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return BrNiveltaxonomico
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
     * @return BrNiveltaxonomico
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
     * @return BrNiveltaxonomico
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
     * Get niveltaxonomicoid
     *
     * @return integer
     */
    public function getNiveltaxonomicoid()
    {
        return $this->niveltaxonomicoid;
    }
}

