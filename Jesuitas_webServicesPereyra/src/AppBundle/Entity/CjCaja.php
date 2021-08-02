<?php

namespace AppBundle\Entity;

/**
 * CjCaja
 */
class CjCaja
{
    /**
     * @var string
     */
    private $nombre;

    /**
     * @var string
     */
    private $ip;

    /**
     * @var string
     */
    private $macaddress;

    /**
     * @var boolean
     */
    private $activo;

    /**
     * @var integer
     */
    private $cajaid;

    /**
     * @var \AppBundle\Entity\CjEmpresa
     */
    private $empresaid;

    /**
     * @var \AppBundle\Entity\CjMediopago
     */
    private $mediopagoid;


    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return CjCaja
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
     * Set ip
     *
     * @param string $ip
     *
     * @return CjCaja
     */
    public function setIp($ip)
    {
        $this->ip = $ip;

        return $this;
    }

    /**
     * Get ip
     *
     * @return string
     */
    public function getIp()
    {
        return $this->ip;
    }

    /**
     * Set macaddress
     *
     * @param string $macaddress
     *
     * @return CjCaja
     */
    public function setMacaddress($macaddress)
    {
        $this->macaddress = $macaddress;

        return $this;
    }

    /**
     * Get macaddress
     *
     * @return string
     */
    public function getMacaddress()
    {
        return $this->macaddress;
    }

    /**
     * Set activo
     *
     * @param boolean $activo
     *
     * @return CjCaja
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
     * Get cajaid
     *
     * @return integer
     */
    public function getCajaid()
    {
        return $this->cajaid;
    }

    /**
     * Set empresaid
     *
     * @param \AppBundle\Entity\CjEmpresa $empresaid
     *
     * @return CjCaja
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

    /**
     * Set mediopagoid
     *
     * @param \AppBundle\Entity\CjMediopago $mediopagoid
     *
     * @return CjCaja
     */
    public function setMediopagoid(\AppBundle\Entity\CjMediopago $mediopagoid = null)
    {
        $this->mediopagoid = $mediopagoid;

        return $this;
    }

    /**
     * Get mediopagoid
     *
     * @return \AppBundle\Entity\CjMediopago
     */
    public function getMediopagoid()
    {
        return $this->mediopagoid;
    }
}

