<?php

namespace AppBundle\Entity;

/**
 * Tipousuario
 */
class Tipousuario
{
    /**
     * @var string
     */
    private $nombre;

    /**
     * @var boolean
     */
    private $activo = '1';

    /**
     * @var string
     */
    private $expresion;

    /**
     * @var string
     */
    private $comentarioexpresion;

    /**
     * @var integer
     */
    private $tipousuarioid;


    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return Tipousuario
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
     * @return Tipousuario
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
     * Set expresion
     *
     * @param string $expresion
     *
     * @return Tipousuario
     */
    public function setExpresion($expresion)
    {
        $this->expresion = $expresion;

        return $this;
    }

    /**
     * Get expresion
     *
     * @return string
     */
    public function getExpresion()
    {
        return $this->expresion;
    }

    /**
     * Set comentarioexpresion
     *
     * @param string $comentarioexpresion
     *
     * @return Tipousuario
     */
    public function setComentarioexpresion($comentarioexpresion)
    {
        $this->comentarioexpresion = $comentarioexpresion;

        return $this;
    }

    /**
     * Get comentarioexpresion
     *
     * @return string
     */
    public function getComentarioexpresion()
    {
        return $this->comentarioexpresion;
    }

    /**
     * Get tipousuarioid
     *
     * @return integer
     */
    public function getTipousuarioid()
    {
        return $this->tipousuarioid;
    }
}

