<?php

namespace AppBundle\Entity;

/**
 * CeDatosfacturacionTemp
 */
class CeDatosfacturacionTemp
{
    /**
     * @var string
     */
    private $matricula;

    /**
     * @var string
     */
    private $domicilio;

    /**
     * @var string
     */
    private $colonia;

    /**
     * @var string
     */
    private $ciudad;

    /**
     * @var string
     */
    private $codigopostal;

    /**
     * @var string
     */
    private $rfc;

    /**
     * @var string
     */
    private $razonsocial;

    /**
     * @var string
     */
    private $correo;

    /**
     * @var integer
     */
    private $pk;


    /**
     * Set matricula
     *
     * @param string $matricula
     *
     * @return CeDatosfacturacionTemp
     */
    public function setMatricula($matricula)
    {
        $this->matricula = $matricula;

        return $this;
    }

    /**
     * Get matricula
     *
     * @return string
     */
    public function getMatricula()
    {
        return $this->matricula;
    }

    /**
     * Set domicilio
     *
     * @param string $domicilio
     *
     * @return CeDatosfacturacionTemp
     */
    public function setDomicilio($domicilio)
    {
        $this->domicilio = $domicilio;

        return $this;
    }

    /**
     * Get domicilio
     *
     * @return string
     */
    public function getDomicilio()
    {
        return $this->domicilio;
    }

    /**
     * Set colonia
     *
     * @param string $colonia
     *
     * @return CeDatosfacturacionTemp
     */
    public function setColonia($colonia)
    {
        $this->colonia = $colonia;

        return $this;
    }

    /**
     * Get colonia
     *
     * @return string
     */
    public function getColonia()
    {
        return $this->colonia;
    }

    /**
     * Set ciudad
     *
     * @param string $ciudad
     *
     * @return CeDatosfacturacionTemp
     */
    public function setCiudad($ciudad)
    {
        $this->ciudad = $ciudad;

        return $this;
    }

    /**
     * Get ciudad
     *
     * @return string
     */
    public function getCiudad()
    {
        return $this->ciudad;
    }

    /**
     * Set codigopostal
     *
     * @param string $codigopostal
     *
     * @return CeDatosfacturacionTemp
     */
    public function setCodigopostal($codigopostal)
    {
        $this->codigopostal = $codigopostal;

        return $this;
    }

    /**
     * Get codigopostal
     *
     * @return string
     */
    public function getCodigopostal()
    {
        return $this->codigopostal;
    }

    /**
     * Set rfc
     *
     * @param string $rfc
     *
     * @return CeDatosfacturacionTemp
     */
    public function setRfc($rfc)
    {
        $this->rfc = $rfc;

        return $this;
    }

    /**
     * Get rfc
     *
     * @return string
     */
    public function getRfc()
    {
        return $this->rfc;
    }

    /**
     * Set razonsocial
     *
     * @param string $razonsocial
     *
     * @return CeDatosfacturacionTemp
     */
    public function setRazonsocial($razonsocial)
    {
        $this->razonsocial = $razonsocial;

        return $this;
    }

    /**
     * Get razonsocial
     *
     * @return string
     */
    public function getRazonsocial()
    {
        return $this->razonsocial;
    }

    /**
     * Set correo
     *
     * @param string $correo
     *
     * @return CeDatosfacturacionTemp
     */
    public function setCorreo($correo)
    {
        $this->correo = $correo;

        return $this;
    }

    /**
     * Get correo
     *
     * @return string
     */
    public function getCorreo()
    {
        return $this->correo;
    }

    /**
     * Get pk
     *
     * @return integer
     */
    public function getPk()
    {
        return $this->pk;
    }
}

