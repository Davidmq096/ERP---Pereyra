<?php

namespace AppBundle\Entity;

/**
 * BrTipousuarioexterno
 */
class BrTipousuarioexterno
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
    private $tipousuarioexternoid;


    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return BrTipousuarioexterno
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
     * @return BrTipousuarioexterno
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
     * Get tipousuarioexternoid
     *
     * @return integer
     */
    public function getTipousuarioexternoid()
    {
        return $this->tipousuarioexternoid;
    }
}

