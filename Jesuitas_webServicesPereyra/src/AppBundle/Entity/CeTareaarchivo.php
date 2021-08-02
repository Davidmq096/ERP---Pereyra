<?php

namespace AppBundle\Entity;

/**
 * CeTareaarchivo
 */
class CeTareaarchivo
{
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
    private $tareaarchivoid;

    /**
     * @var \AppBundle\Entity\CeTarea
     */
    private $tareaid;


    /**
     * Set contenido
     *
     * @param string $contenido
     *
     * @return CeTareaarchivo
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
     * @return CeTareaarchivo
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
     * @return CeTareaarchivo
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
     * @return CeTareaarchivo
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
     * Get tareaarchivoid
     *
     * @return integer
     */
    public function getTareaarchivoid()
    {
        return $this->tareaarchivoid;
    }

    /**
     * Set tareaid
     *
     * @param \AppBundle\Entity\CeTarea $tareaid
     *
     * @return CeTareaarchivo
     */
    public function setTareaid(\AppBundle\Entity\CeTarea $tareaid = null)
    {
        $this->tareaid = $tareaid;

        return $this;
    }

    /**
     * Get tareaid
     *
     * @return \AppBundle\Entity\CeTarea
     */
    public function getTareaid()
    {
        return $this->tareaid;
    }
}

