<?php

namespace AppBundle\Entity;

/**
 * CeImagenporevento
 */
class CeImagenporevento
{
    /**
     * @var string
     */
    private $nombrearchivo;

    /**
     * @var string
     */
    private $archivo;

    /**
     * @var integer
     */
    private $archivosize;

    /**
     * @var string
     */
    private $archivotipo;

    /**
     * @var integer
     */
    private $imagenporeventoid;

    /**
     * @var \AppBundle\Entity\CeEvento
     */
    private $eventoid;


    /**
     * Set nombrearchivo
     *
     * @param string $nombrearchivo
     *
     * @return CeImagenporevento
     */
    public function setNombrearchivo($nombrearchivo)
    {
        $this->nombrearchivo = $nombrearchivo;

        return $this;
    }

    /**
     * Get nombrearchivo
     *
     * @return string
     */
    public function getNombrearchivo()
    {
        return $this->nombrearchivo;
    }

    /**
     * Set archivo
     *
     * @param string $archivo
     *
     * @return CeImagenporevento
     */
    public function setArchivo($archivo)
    {
        $this->archivo = $archivo;

        return $this;
    }

    /**
     * Get archivo
     *
     * @return string
     */
    public function getArchivo()
    {
        return $this->archivo;
    }

    /**
     * Set archivosize
     *
     * @param integer $archivosize
     *
     * @return CeImagenporevento
     */
    public function setArchivosize($archivosize)
    {
        $this->archivosize = $archivosize;

        return $this;
    }

    /**
     * Get archivosize
     *
     * @return integer
     */
    public function getArchivosize()
    {
        return $this->archivosize;
    }

    /**
     * Set archivotipo
     *
     * @param string $archivotipo
     *
     * @return CeImagenporevento
     */
    public function setArchivotipo($archivotipo)
    {
        $this->archivotipo = $archivotipo;

        return $this;
    }

    /**
     * Get archivotipo
     *
     * @return string
     */
    public function getArchivotipo()
    {
        return $this->archivotipo;
    }

    /**
     * Get imagenporeventoid
     *
     * @return integer
     */
    public function getImagenporeventoid()
    {
        return $this->imagenporeventoid;
    }

    /**
     * Set eventoid
     *
     * @param \AppBundle\Entity\CeEvento $eventoid
     *
     * @return CeImagenporevento
     */
    public function setEventoid(\AppBundle\Entity\CeEvento $eventoid = null)
    {
        $this->eventoid = $eventoid;

        return $this;
    }

    /**
     * Get eventoid
     *
     * @return \AppBundle\Entity\CeEvento
     */
    public function getEventoid()
    {
        return $this->eventoid;
    }
}

