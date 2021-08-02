<?php

namespace AppBundle\Entity;

/**
 * CeAvisosporplataformaarchivo
 */
class CeAvisosporplataformaarchivo
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
    private $avisoplataformaarchivoid;

    /**
     * @var \AppBundle\Entity\CeAvisosplataforma
     */
    private $avisoplataformaid;


    /**
     * Set contenido
     *
     * @param string $contenido
     *
     * @return CeAvisosporplataformaarchivo
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
     * @return CeAvisosporplataformaarchivo
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
     * @return CeAvisosporplataformaarchivo
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
     * @return CeAvisosporplataformaarchivo
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
     * Get avisoplataformaarchivoid
     *
     * @return integer
     */
    public function getAvisoplataformaarchivoid()
    {
        return $this->avisoplataformaarchivoid;
    }

    /**
     * Set avisoplataformaid
     *
     * @param \AppBundle\Entity\CeAvisosplataforma $avisoplataformaid
     *
     * @return CeAvisosporplataformaarchivo
     */
    public function setAvisoplataformaid(\AppBundle\Entity\CeAvisosplataforma $avisoplataformaid = null)
    {
        $this->avisoplataformaid = $avisoplataformaid;

        return $this;
    }

    /**
     * Get avisoplataformaid
     *
     * @return \AppBundle\Entity\CeAvisosplataforma
     */
    public function getAvisoplataformaid()
    {
        return $this->avisoplataformaid;
    }
}

