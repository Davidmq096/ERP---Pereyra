<?php

namespace AppBundle\Entity;

/**
 * CeTareaalumnoarchivo
 */
class CeTareaalumnoarchivo
{
    /**
     * @var integer
     */
    private $tareaalumnoid;

    /**
     * @var string
     */
    private $contenido;

    /**
     * @var string
     */
    private $size;

    /**
     * @var string
     */
    private $tipo;

    /**
     * @var string
     */
    private $nombre;

    /**
     * @var integer
     */
    private $tareaalumnoarchivoid;


    /**
     * Set tareaalumnoid
     *
     * @param integer $tareaalumnoid
     *
     * @return CeTareaalumnoarchivo
     */
    public function setTareaalumnoid($tareaalumnoid)
    {
        $this->tareaalumnoid = $tareaalumnoid;

        return $this;
    }

    /**
     * Get tareaalumnoid
     *
     * @return integer
     */
    public function getTareaalumnoid()
    {
        return $this->tareaalumnoid;
    }

    /**
     * Set contenido
     *
     * @param string $contenido
     *
     * @return CeTareaalumnoarchivo
     */
    public function setContenido($contenido)
    {
        $this->contenido = $contenido;

        return $this;
    }

    /**
     * Get contenido
     *
     * @return string
     */
    public function getContenido()
    {
        return $this->contenido;
    }

    /**
     * Set size
     *
     * @param string $size
     *
     * @return CeTareaalumnoarchivo
     */
    public function setSize($size)
    {
        $this->size = $size;

        return $this;
    }

    /**
     * Get size
     *
     * @return string
     */
    public function getSize()
    {
        return $this->size;
    }

    /**
     * Set tipo
     *
     * @param string $tipo
     *
     * @return CeTareaalumnoarchivo
     */
    public function setTipo($tipo)
    {
        $this->tipo = $tipo;

        return $this;
    }

    /**
     * Get tipo
     *
     * @return string
     */
    public function getTipo()
    {
        return $this->tipo;
    }

    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return CeTareaalumnoarchivo
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
     * Get tareaalumnoarchivoid
     *
     * @return integer
     */
    public function getTareaalumnoarchivoid()
    {
        return $this->tareaalumnoarchivoid;
    }
}

