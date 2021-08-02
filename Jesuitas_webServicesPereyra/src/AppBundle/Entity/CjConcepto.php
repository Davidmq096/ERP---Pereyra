<?php

namespace AppBundle\Entity;

/**
 * CjConcepto
 */
class CjConcepto
{
    /**
     * @var string
     */
    private $clave;

    /**
     * @var string
     */
    private $alias;

    /**
     * @var string
     */
    private $nombre;

    /**
     * @var boolean
     */
    private $tipomovimiento;

    /**
     * @var boolean
     */
    private $clasificacion;

    /**
     * @var boolean
     */
    private $esdiverso;

    /**
     * @var boolean
     */
    private $escurricular;

    /**
     * @var boolean
     */
    private $esfijo;

    /**
     * @var boolean
     */
    private $gravado;

    /**
     * @var boolean
     */
    private $tipoasignacion;

    /**
     * @var boolean
     */
    private $activo;

    /**
     * @var integer
     */
    private $conceptoid;

    /**
     * @var \AppBundle\Entity\CjCentrocosto
     */
    private $centrocostoid;

    /**
     * @var \AppBundle\Entity\CjEmpresa
     */
    private $empresaid;


    /**
     * Set clave
     *
     * @param string $clave
     *
     * @return CjConcepto
     */
    public function setClave($clave)
    {
        $this->clave = $clave;

        return $this;
    }

    /**
     * Get clave
     *
     * @return string
     */
    public function getClave()
    {
        return $this->clave;
    }

    /**
     * Set alias
     *
     * @param string $alias
     *
     * @return CjConcepto
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
     * Set nombre
     *
     * @param string $nombre
     *
     * @return CjConcepto
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
     * Set tipomovimiento
     *
     * @param boolean $tipomovimiento
     *
     * @return CjConcepto
     */
    public function setTipomovimiento($tipomovimiento)
    {
        $this->tipomovimiento = $tipomovimiento;

        return $this;
    }

    /**
     * Get tipomovimiento
     *
     * @return boolean
     */
    public function getTipomovimiento()
    {
        return $this->tipomovimiento;
    }

    /**
     * Set clasificacion
     *
     * @param boolean $clasificacion
     *
     * @return CjConcepto
     */
    public function setClasificacion($clasificacion)
    {
        $this->clasificacion = $clasificacion;

        return $this;
    }

    /**
     * Get clasificacion
     *
     * @return boolean
     */
    public function getClasificacion()
    {
        return $this->clasificacion;
    }

    /**
     * Set esdiverso
     *
     * @param boolean $esdiverso
     *
     * @return CjConcepto
     */
    public function setEsdiverso($esdiverso)
    {
        $this->esdiverso = $esdiverso;

        return $this;
    }

    /**
     * Get esdiverso
     *
     * @return boolean
     */
    public function getEsdiverso()
    {
        return $this->esdiverso;
    }

    /**
     * Set escurricular
     *
     * @param boolean $escurricular
     *
     * @return CjConcepto
     */
    public function setEscurricular($escurricular)
    {
        $this->escurricular = $escurricular;

        return $this;
    }

    /**
     * Get escurricular
     *
     * @return boolean
     */
    public function getEscurricular()
    {
        return $this->escurricular;
    }

    /**
     * Set esfijo
     *
     * @param boolean $esfijo
     *
     * @return CjConcepto
     */
    public function setEsfijo($esfijo)
    {
        $this->esfijo = $esfijo;

        return $this;
    }

    /**
     * Get esfijo
     *
     * @return boolean
     */
    public function getEsfijo()
    {
        return $this->esfijo;
    }

    /**
     * Set gravado
     *
     * @param boolean $gravado
     *
     * @return CjConcepto
     */
    public function setGravado($gravado)
    {
        $this->gravado = $gravado;

        return $this;
    }

    /**
     * Get gravado
     *
     * @return boolean
     */
    public function getGravado()
    {
        return $this->gravado;
    }

    /**
     * Set tipoasignacion
     *
     * @param boolean $tipoasignacion
     *
     * @return CjConcepto
     */
    public function setTipoasignacion($tipoasignacion)
    {
        $this->tipoasignacion = $tipoasignacion;

        return $this;
    }

    /**
     * Get tipoasignacion
     *
     * @return boolean
     */
    public function getTipoasignacion()
    {
        return $this->tipoasignacion;
    }

    /**
     * Set activo
     *
     * @param boolean $activo
     *
     * @return CjConcepto
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
     * Get conceptoid
     *
     * @return integer
     */
    public function getConceptoid()
    {
        return $this->conceptoid;
    }

    /**
     * Set centrocostoid
     *
     * @param \AppBundle\Entity\CjCentrocosto $centrocostoid
     *
     * @return CjConcepto
     */
    public function setCentrocostoid(\AppBundle\Entity\CjCentrocosto $centrocostoid = null)
    {
        $this->centrocostoid = $centrocostoid;

        return $this;
    }

    /**
     * Get centrocostoid
     *
     * @return \AppBundle\Entity\CjCentrocosto
     */
    public function getCentrocostoid()
    {
        return $this->centrocostoid;
    }

    /**
     * Set empresaid
     *
     * @param \AppBundle\Entity\CjEmpresa $empresaid
     *
     * @return CjConcepto
     */
    public function setEmpresaid(\AppBundle\Entity\CjEmpresa $empresaid = null)
    {
        $this->empresaid = $empresaid;

        return $this;
    }

    /**
     * Get empresaid
     *
     * @return \AppBundle\Entity\CjEmpresa
     */
    public function getEmpresaid()
    {
        return $this->empresaid;
    }
}

