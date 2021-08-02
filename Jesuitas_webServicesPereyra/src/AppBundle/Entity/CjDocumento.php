<?php

namespace AppBundle\Entity;

/**
 * CjDocumento
 */
class CjDocumento
{
    /**
     * @var string
     */
    private $nombre;

    /**
     * @var string
     */
    private $alias;

    /**
     * @var boolean
     */
    private $nuevoingreso;

    /**
     * @var boolean
     */
    private $activo;

    /**
     * @var integer
     */
    private $documentoid;

    /**
     * @var \AppBundle\Entity\Ciclo
     */
    private $cicloid;

    /**
     * @var \AppBundle\Entity\Nivel
     */
    private $nivelid;

    /**
     * @var \AppBundle\Entity\CjTipodocumento
     */
    private $tipodocumento;


    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return CjDocumento
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
     * Set alias
     *
     * @param string $alias
     *
     * @return CjDocumento
     */
    public function setAlias($alias)
    {
        $this->alias = $alias;

        return $this;
    }

    /**
     * Get alias
     *
     * @return string
     */
    public function getAlias()
    {
        return $this->alias;
    }

    /**
     * Set nuevoingreso
     *
     * @param boolean $nuevoingreso
     *
     * @return CjDocumento
     */
    public function setNuevoingreso($nuevoingreso)
    {
        $this->nuevoingreso = $nuevoingreso;

        return $this;
    }

    /**
     * Get nuevoingreso
     *
     * @return boolean
     */
    public function getNuevoingreso()
    {
        return $this->nuevoingreso;
    }

    /**
     * Set activo
     *
     * @param boolean $activo
     *
     * @return CjDocumento
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
     * Get documentoid
     *
     * @return integer
     */
    public function getDocumentoid()
    {
        return $this->documentoid;
    }

    /**
     * Set cicloid
     *
     * @param \AppBundle\Entity\Ciclo $cicloid
     *
     * @return CjDocumento
     */
    public function setCicloid(\AppBundle\Entity\Ciclo $cicloid = null)
    {
        $this->cicloid = $cicloid;

        return $this;
    }

    /**
     * Get cicloid
     *
     * @return \AppBundle\Entity\Ciclo
     */
    public function getCicloid()
    {
        return $this->cicloid;
    }

    /**
     * Set nivelid
     *
     * @param \AppBundle\Entity\Nivel $nivelid
     *
     * @return CjDocumento
     */
    public function setNivelid(\AppBundle\Entity\Nivel $nivelid = null)
    {
        $this->nivelid = $nivelid;

        return $this;
    }

    /**
     * Get nivelid
     *
     * @return \AppBundle\Entity\Nivel
     */
    public function getNivelid()
    {
        return $this->nivelid;
    }

    /**
     * Set tipodocumento
     *
     * @param \AppBundle\Entity\CjTipodocumento $tipodocumento
     *
     * @return CjDocumento
     */
    public function setTipodocumento(\AppBundle\Entity\CjTipodocumento $tipodocumento = null)
    {
        $this->tipodocumento = $tipodocumento;

        return $this;
    }

    /**
     * Get tipodocumento
     *
     * @return \AppBundle\Entity\CjTipodocumento
     */
    public function getTipodocumento()
    {
        return $this->tipodocumento;
    }
}

