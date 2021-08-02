<?php

namespace AppBundle\Entity;

/**
 * CeAvisosporcaratulaarchivo
 */
class CeAvisosporcaratulaarchivo
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
    private $avisocaratulaarchivoid;

    /**
     * @var \AppBundle\Entity\CeAvisosporcaratula
     */
    private $avisocaratulaid;


    /**
     * Set contenido
     *
     * @param string $contenido
     *
     * @return CeAvisosporcaratulaarchivo
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
     * @return CeAvisosporcaratulaarchivo
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
     * @return CeAvisosporcaratulaarchivo
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
     * @return CeAvisosporcaratulaarchivo
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
     * Get avisocaratulaarchivoid
     *
     * @return integer
     */
    public function getAvisocaratulaarchivoid()
    {
        return $this->avisocaratulaarchivoid;
    }

    /**
     * Set avisocaratulaid
     *
     * @param \AppBundle\Entity\CeAvisosporcaratula $avisocaratulaid
     *
     * @return CeAvisosporcaratulaarchivo
     */
    public function setAvisocaratulaid(\AppBundle\Entity\CeAvisosporcaratula $avisocaratulaid = null)
    {
        $this->avisocaratulaid = $avisocaratulaid;

        return $this;
    }

    /**
     * Get avisocaratulaid
     *
     * @return \AppBundle\Entity\CeAvisosporcaratula
     */
    public function getAvisocaratulaid()
    {
        return $this->avisocaratulaid;
    }
}

