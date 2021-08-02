<?php

namespace AppBundle\Entity;

/**
 * TpPlantillacontrato
 */
class TpPlantillacontrato
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
    private $plantillacontratoid;


    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return TpPlantillacontrato
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
     * @return TpPlantillacontrato
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
     * Set contenido
     *
     * @param string $contenido
     *
     * @return TpPlantillacontrato
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
     * @return TpPlantillacontrato
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
     * @return TpPlantillacontrato
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
     * Get plantillacontratoid
     *
     * @return integer
     */
    public function getPlantillacontratoid()
    {
        return $this->plantillacontratoid;
    }
}

