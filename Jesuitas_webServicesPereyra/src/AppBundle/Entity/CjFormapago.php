<?php

namespace AppBundle\Entity;

/**
 * CjFormapago
 */
class CjFormapago
{
    /**
     * @var string
     */
    private $nombre;

    /**
     * @var boolean
     */
    private $esefectivo;

    /**
     * @var boolean
     */
    private $doblecaptura;

    /**
     * @var string
     */
    private $comisionporcentaje;

    /**
     * @var string
     */
    private $comisionmontofijo;

    /**
     * @var boolean
     */
    private $pidereferencia;

    /**
     * @var integer
     */
    private $bancoid;

    /**
     * @var boolean
     */
    private $activo;

    /**
     * @var integer
     */
    private $formapagoid;


    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return CjFormapago
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
     * Set esefectivo
     *
     * @param boolean $esefectivo
     *
     * @return CjFormapago
     */
    public function setEsefectivo($esefectivo)
    {
        $this->esefectivo = $esefectivo;

        return $this;
    }

    /**
     * Get esefectivo
     *
     * @return boolean
     */
    public function getEsefectivo()
    {
        return $this->esefectivo;
    }

    /**
     * Set doblecaptura
     *
     * @param boolean $doblecaptura
     *
     * @return CjFormapago
     */
    public function setDoblecaptura($doblecaptura)
    {
        $this->doblecaptura = $doblecaptura;

        return $this;
    }

    /**
     * Get doblecaptura
     *
     * @return boolean
     */
    public function getDoblecaptura()
    {
        return $this->doblecaptura;
    }

    /**
     * Set comisionporcentaje
     *
     * @param string $comisionporcentaje
     *
     * @return CjFormapago
     */
    public function setComisionporcentaje($comisionporcentaje)
    {
        $this->comisionporcentaje = $comisionporcentaje;

        return $this;
    }

    /**
     * Get comisionporcentaje
     *
     * @return string
     */
    public function getComisionporcentaje()
    {
        return $this->comisionporcentaje;
    }

    /**
     * Set comisionmontofijo
     *
     * @param string $comisionmontofijo
     *
     * @return CjFormapago
     */
    public function setComisionmontofijo($comisionmontofijo)
    {
        $this->comisionmontofijo = $comisionmontofijo;

        return $this;
    }

    /**
     * Get comisionmontofijo
     *
     * @return string
     */
    public function getComisionmontofijo()
    {
        return $this->comisionmontofijo;
    }

    /**
     * Set pidereferencia
     *
     * @param boolean $pidereferencia
     *
     * @return CjFormapago
     */
    public function setPidereferencia($pidereferencia)
    {
        $this->pidereferencia = $pidereferencia;

        return $this;
    }

    /**
     * Get pidereferencia
     *
     * @return boolean
     */
    public function getPidereferencia()
    {
        return $this->pidereferencia;
    }

    /**
     * Set bancoid
     *
     * @param integer $bancoid
     *
     * @return CjFormapago
     */
    public function setBancoid($bancoid)
    {
        $this->bancoid = $bancoid;

        return $this;
    }

    /**
     * Get bancoid
     *
     * @return integer
     */
    public function getBancoid()
    {
        return $this->bancoid;
    }

    /**
     * Set activo
     *
     * @param boolean $activo
     *
     * @return CjFormapago
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
     * Get formapagoid
     *
     * @return integer
     */
    public function getFormapagoid()
    {
        return $this->formapagoid;
    }
}

