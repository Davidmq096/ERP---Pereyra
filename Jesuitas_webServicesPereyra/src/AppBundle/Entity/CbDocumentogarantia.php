<?php

namespace AppBundle\Entity;

/**
 * CbDocumentogarantia
 */
class CbDocumentogarantia
{
    /**
     * @var float
     */
    private $importe;

    /**
     * @var string
     */
    private $descripcion;

    /**
     * @var string
     */
    private $archivo;

    /**
     * @var string
     */
    private $archivosize;

    /**
     * @var string
     */
    private $archivotipo;

    /**
     * @var integer
     */
    private $documentogarantiaid;

    /**
     * @var \AppBundle\Entity\CbAcuerdo
     */
    private $acuerdoid;

    /**
     * @var \AppBundle\Entity\CbTipogarantia
     */
    private $tipogarantiaid;


    /**
     * Set importe
     *
     * @param float $importe
     *
     * @return CbDocumentogarantia
     */
    public function setImporte($importe)
    {
        $this->importe = $importe;

        return $this;
    }

    /**
     * Get importe
     *
     * @return float
     */
    public function getImporte()
    {
        return $this->importe;
    }

    /**
     * Set descripcion
     *
     * @param string $descripcion
     *
     * @return CbDocumentogarantia
     */
    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    /**
     * Get descripcion
     *
     * @return string
     */
    public function getDescripcion()
    {
        return $this->descripcion;
    }

    /**
     * Set archivo
     *
     * @param string $archivo
     *
     * @return CbDocumentogarantia
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
     * @param string $archivosize
     *
     * @return CbDocumentogarantia
     */
    public function setArchivosize($archivosize)
    {
        $this->archivosize = $archivosize;

        return $this;
    }

    /**
     * Get archivosize
     *
     * @return string
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
     * @return CbDocumentogarantia
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
     * Get documentogarantiaid
     *
     * @return integer
     */
    public function getDocumentogarantiaid()
    {
        return $this->documentogarantiaid;
    }

    /**
     * Set acuerdoid
     *
     * @param \AppBundle\Entity\CbAcuerdo $acuerdoid
     *
     * @return CbDocumentogarantia
     */
    public function setAcuerdoid(\AppBundle\Entity\CbAcuerdo $acuerdoid = null)
    {
        $this->acuerdoid = $acuerdoid;

        return $this;
    }

    /**
     * Get acuerdoid
     *
     * @return \AppBundle\Entity\CbAcuerdo
     */
    public function getAcuerdoid()
    {
        return $this->acuerdoid;
    }

    /**
     * Set tipogarantiaid
     *
     * @param \AppBundle\Entity\CbTipogarantia $tipogarantiaid
     *
     * @return CbDocumentogarantia
     */
    public function setTipogarantiaid(\AppBundle\Entity\CbTipogarantia $tipogarantiaid = null)
    {
        $this->tipogarantiaid = $tipogarantiaid;

        return $this;
    }

    /**
     * Get tipogarantiaid
     *
     * @return \AppBundle\Entity\CbTipogarantia
     */
    public function getTipogarantiaid()
    {
        return $this->tipogarantiaid;
    }
}

