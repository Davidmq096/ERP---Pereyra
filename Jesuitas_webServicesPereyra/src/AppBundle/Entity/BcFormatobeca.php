<?php

namespace AppBundle\Entity;

/**
 * BcFormatobeca
 */
class BcFormatobeca
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
     * @var boolean
     */
    private $activo;

    /**
     * @var integer
     */
    private $formatobecaid;

    /**
     * @var \AppBundle\Entity\BcTipodocumento
     */
    private $tipodocumentoid;


    /**
     * Set nombrearchivo
     *
     * @param string $nombrearchivo
     *
     * @return BcFormatobeca
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
     * @return BcFormatobeca
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
     * @return BcFormatobeca
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
     * @return BcFormatobeca
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
     * Set activo
     *
     * @param boolean $activo
     *
     * @return BcFormatobeca
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
     * Get formatobecaid
     *
     * @return integer
     */
    public function getFormatobecaid()
    {
        return $this->formatobecaid;
    }

    /**
     * Set tipodocumentoid
     *
     * @param \AppBundle\Entity\BcTipodocumento $tipodocumentoid
     *
     * @return BcFormatobeca
     */
    public function setTipodocumentoid(\AppBundle\Entity\BcTipodocumento $tipodocumentoid = null)
    {
        $this->tipodocumentoid = $tipodocumentoid;

        return $this;
    }

    /**
     * Get tipodocumentoid
     *
     * @return \AppBundle\Entity\BcTipodocumento
     */
    public function getTipodocumentoid()
    {
        return $this->tipodocumentoid;
    }
}

