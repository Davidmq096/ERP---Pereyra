<?php

namespace AppBundle\Entity;

/**
 * CePadresotutoresfacturacion
 */
class CePadresotutoresfacturacion
{
    /**
     * @var integer
     */
    private $tipopersonaid;

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
    private $esautomaticacolegiatura;

    /**
     * @var integer
     */
    private $esautomaticaotros;

    /**
     * @var boolean
     */
    private $activo = '1';

    /**
     * @var integer
     */
    private $padresotutoresfacturacionid;

    /**
     * @var \AppBundle\Entity\CePadresotutoresdomicilio
     */
    private $padresotutoresdomicilioid;

    /**
     * @var \AppBundle\Entity\CePadresotutores
     */
    private $padresotutoresid;


    /**
     * Set tipopersonaid
     *
     * @param integer $tipopersonaid
     *
     * @return CePadresotutoresfacturacion
     */
    public function setTipopersonaid($tipopersonaid)
    {
        $this->tipopersonaid = $tipopersonaid;

        return $this;
    }

    /**
     * Get tipopersonaid
     *
     * @return integer
     */
    public function getTipopersonaid()
    {
        return $this->tipopersonaid;
    }

    /**
     * Set rfc
     *
     * @param string $rfc
     *
     * @return CePadresotutoresfacturacion
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
     * @return CePadresotutoresfacturacion
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
     * @return CePadresotutoresfacturacion
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
     * Set esautomaticacolegiatura
     *
     * @param integer $esautomaticacolegiatura
     *
     * @return CePadresotutoresfacturacion
     */
    public function setEsautomaticacolegiatura($esautomaticacolegiatura)
    {
        $this->esautomaticacolegiatura = $esautomaticacolegiatura;

        return $this;
    }

    /**
     * Get esautomaticacolegiatura
     *
     * @return integer
     */
    public function getEsautomaticacolegiatura()
    {
        return $this->esautomaticacolegiatura;
    }

    /**
     * Set esautomaticaotros
     *
     * @param integer $esautomaticaotros
     *
     * @return CePadresotutoresfacturacion
     */
    public function setEsautomaticaotros($esautomaticaotros)
    {
        $this->esautomaticaotros = $esautomaticaotros;

        return $this;
    }

    /**
     * Get esautomaticaotros
     *
     * @return integer
     */
    public function getEsautomaticaotros()
    {
        return $this->esautomaticaotros;
    }

    /**
     * Set activo
     *
     * @param boolean $activo
     *
     * @return CePadresotutoresfacturacion
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
     * Get padresotutoresfacturacionid
     *
     * @return integer
     */
    public function getPadresotutoresfacturacionid()
    {
        return $this->padresotutoresfacturacionid;
    }

    /**
     * Set padresotutoresdomicilioid
     *
     * @param \AppBundle\Entity\CePadresotutoresdomicilio $padresotutoresdomicilioid
     *
     * @return CePadresotutoresfacturacion
     */
    public function setPadresotutoresdomicilioid(\AppBundle\Entity\CePadresotutoresdomicilio $padresotutoresdomicilioid = null)
    {
        $this->padresotutoresdomicilioid = $padresotutoresdomicilioid;

        return $this;
    }

    /**
     * Get padresotutoresdomicilioid
     *
     * @return \AppBundle\Entity\CePadresotutoresdomicilio
     */
    public function getPadresotutoresdomicilioid()
    {
        return $this->padresotutoresdomicilioid;
    }

    /**
     * Set padresotutoresid
     *
     * @param \AppBundle\Entity\CePadresotutores $padresotutoresid
     *
     * @return CePadresotutoresfacturacion
     */
    public function setPadresotutoresid(\AppBundle\Entity\CePadresotutores $padresotutoresid = null)
    {
        $this->padresotutoresid = $padresotutoresid;

        return $this;
    }

    /**
     * Get padresotutoresid
     *
     * @return \AppBundle\Entity\CePadresotutores
     */
    public function getPadresotutoresid()
    {
        return $this->padresotutoresid;
    }
}

