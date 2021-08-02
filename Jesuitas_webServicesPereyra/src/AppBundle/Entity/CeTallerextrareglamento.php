<?php

namespace AppBundle\Entity;

/**
 * CeTallerextrareglamento
 */
class CeTallerextrareglamento
{
    /**
     * @var string
     */
    private $nombre;

    /**
     * @var string
     */
    private $contenido;

    /**
     * @var integer
     */
    private $size;

    /**
     * @var string
     */
    private $tipo;

    /**
     * @var integer
     */
    private $tallerextrareglamentoid;


    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return CeTallerextrareglamento
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
     * Set contenido
     *
     * @param string $contenido
     *
     * @return CeTallerextrareglamento
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
     * @param integer $size
     *
     * @return CeTallerextrareglamento
     */
    public function setSize($size)
    {
        $this->size = $size;

        return $this;
    }

    /**
     * Get size
     *
     * @return integer
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
     * @return CeTallerextrareglamento
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
     * Get tallerextrareglamentoid
     *
     * @return integer
     */
    public function getTallerextrareglamentoid()
    {
        return $this->tallerextrareglamentoid;
    }
}

