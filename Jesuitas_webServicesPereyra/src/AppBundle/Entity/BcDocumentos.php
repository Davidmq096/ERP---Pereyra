<?php

namespace AppBundle\Entity;

/**
 * BcDocumentos
 */
class BcDocumentos
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
    private $documentoid;


    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return BcDocumentos
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
     * @return BcDocumentos
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
     * Get documentoid
     *
     * @return integer
     */
    public function getDocumentoid()
    {
        return $this->documentoid;
    }
}

