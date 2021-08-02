<?php

namespace AppBundle\Entity;

/**
 * Documentoporgrado
 */
class Documentoporgrado
{
    /**
     * @var boolean
     */
    private $original;

    /**
     * @var boolean
     */
    private $copia;

    /**
     * @var boolean
     */
    private $activo;

    /**
     * @var integer
     */
    private $documentoporgradoid;

    /**
     * @var \AppBundle\Entity\Documento
     */
    private $documentoid;

    /**
     * @var \AppBundle\Entity\Grado
     */
    private $gradoid;


    /**
     * Set original
     *
     * @param boolean $original
     *
     * @return Documentoporgrado
     */
    public function setOriginal($original)
    {
        $this->original = $original;

        return $this;
    }

    /**
     * Get original
     *
     * @return boolean
     */
    public function getOriginal()
    {
        return $this->original;
    }

    /**
     * Set copia
     *
     * @param boolean $copia
     *
     * @return Documentoporgrado
     */
    public function setCopia($copia)
    {
        $this->copia = $copia;

        return $this;
    }

    /**
     * Get copia
     *
     * @return boolean
     */
    public function getCopia()
    {
        return $this->copia;
    }

    /**
     * Set activo
     *
     * @param boolean $activo
     *
     * @return Documentoporgrado
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
     * Get documentoporgradoid
     *
     * @return integer
     */
    public function getDocumentoporgradoid()
    {
        return $this->documentoporgradoid;
    }

    /**
     * Set documentoid
     *
     * @param \AppBundle\Entity\Documento $documentoid
     *
     * @return Documentoporgrado
     */
    public function setDocumentoid(\AppBundle\Entity\Documento $documentoid = null)
    {
        $this->documentoid = $documentoid;

        return $this;
    }

    /**
     * Get documentoid
     *
     * @return \AppBundle\Entity\Documento
     */
    public function getDocumentoid()
    {
        return $this->documentoid;
    }

    /**
     * Set gradoid
     *
     * @param \AppBundle\Entity\Grado $gradoid
     *
     * @return Documentoporgrado
     */
    public function setGradoid(\AppBundle\Entity\Grado $gradoid = null)
    {
        $this->gradoid = $gradoid;

        return $this;
    }

    /**
     * Get gradoid
     *
     * @return \AppBundle\Entity\Grado
     */
    public function getGradoid()
    {
        return $this->gradoid;
    }
}

