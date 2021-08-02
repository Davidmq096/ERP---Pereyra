<?php

namespace AppBundle\Entity;

/**
 * BcArchivosituacioneconomica
 */
class BcArchivosituacioneconomica
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
     * @var string
     */
    private $archivotipo;

    /**
     * @var integer
     */
    private $archivosize;

    /**
     * @var boolean
     */
    private $activo = '1';

    /**
     * @var integer
     */
    private $archivosituacioneconomicaid;

    /**
     * @var \AppBundle\Entity\BcSolicitudbeca
     */
    private $solicitudid;


    /**
     * Set nombrearchivo
     *
     * @param string $nombrearchivo
     *
     * @return BcArchivosituacioneconomica
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
     * @return BcArchivosituacioneconomica
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
     * Set archivotipo
     *
     * @param string $archivotipo
     *
     * @return BcArchivosituacioneconomica
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
     * Set archivosize
     *
     * @param integer $archivosize
     *
     * @return BcArchivosituacioneconomica
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
     * Set activo
     *
     * @param boolean $activo
     *
     * @return BcArchivosituacioneconomica
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
     * Get archivosituacioneconomicaid
     *
     * @return integer
     */
    public function getArchivosituacioneconomicaid()
    {
        return $this->archivosituacioneconomicaid;
    }

    /**
     * Set solicitudid
     *
     * @param \AppBundle\Entity\BcSolicitudbeca $solicitudid
     *
     * @return BcArchivosituacioneconomica
     */
    public function setSolicitudid(\AppBundle\Entity\BcSolicitudbeca $solicitudid = null)
    {
        $this->solicitudid = $solicitudid;

        return $this;
    }

    /**
     * Get solicitudid
     *
     * @return \AppBundle\Entity\BcSolicitudbeca
     */
    public function getSolicitudid()
    {
        return $this->solicitudid;
    }
}

