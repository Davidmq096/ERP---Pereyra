<?php

namespace AppBundle\Entity;

/**
 * CeProfesor
 */
class CeProfesor
{
    /**
     * @var string
     */
    private $nombre;

    /**
     * @var string
     */
    private $apellidomaterno;

    /**
     * @var string
     */
    private $apellidopaterno;

    /**
     * @var string
     */
    private $correopersonal;

    /**
     * @var string
     */
    private $correoinstitucional;

    /**
     * @var string
     */
    private $telefonofijo;

    /**
     * @var string
     */
    private $celular;

    /**
     * @var string
     */
    private $nombrecompletoemergencia;

    /**
     * @var string
     */
    private $celular2;

    /**
     * @var string
     */
    private $numeronomina;

    /**
     * @var \DateTime
     */
    private $fechanacimiento;

    /**
     * @var string
     */
    private $genero;

    /**
     * @var string
     */
    private $curp;

    /**
     * @var string
     */
    private $estadocivil;

    /**
     * @var string
     */
    private $rfc;

    /**
     * @var string
     */
    private $nacionalidad;

    /**
     * @var string
     */
    private $nss;

    /**
     * @var string
     */
    private $codigopostal;

    /**
     * @var integer
     */
    private $ciudadid;

    /**
     * @var string
     */
    private $calle;

    /**
     * @var string
     */
    private $numeroexterior;

    /**
     * @var string
     */
    private $numerointerior;

    /**
     * @var string
     */
    private $fotografia;

    /**
     * @var string
     */
    private $otracolonia;

    /**
     * @var \DateTime
     */
    private $experienciasep;

    /**
     * @var float
     */
    private $experienciainstituto;

    /**
     * @var string
     */
    private $autorizaciondgb;

    /**
     * @var string
     */
    private $autorizacionsep;

    /**
     * @var integer
     */
    private $profesorid;

    /**
     * @var \AppBundle\Entity\CeEstatusempleado
     */
    private $estatusempleadoid;

    /**
     * @var \AppBundle\Entity\Estado
     */
    private $estadoid;

    /**
     * @var \AppBundle\Entity\Parentesco
     */
    private $parentescoid;

    /**
     * @var \AppBundle\Entity\Colonia
     */
    private $coloniaid;


    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return CeProfesor
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
     * Set apellidomaterno
     *
     * @param string $apellidomaterno
     *
     * @return CeProfesor
     */
    public function setApellidomaterno($apellidomaterno)
    {
        $this->apellidomaterno = $apellidomaterno;

        return $this;
    }

    /**
     * Get apellidomaterno
     *
     * @return string
     */
    public function getApellidomaterno()
    {
        return $this->apellidomaterno;
    }

    /**
     * Set apellidopaterno
     *
     * @param string $apellidopaterno
     *
     * @return CeProfesor
     */
    public function setApellidopaterno($apellidopaterno)
    {
        $this->apellidopaterno = $apellidopaterno;

        return $this;
    }

    /**
     * Get apellidopaterno
     *
     * @return string
     */
    public function getApellidopaterno()
    {
        return $this->apellidopaterno;
    }

    /**
     * Set correopersonal
     *
     * @param string $correopersonal
     *
     * @return CeProfesor
     */
    public function setCorreopersonal($correopersonal)
    {
        $this->correopersonal = $correopersonal;

        return $this;
    }

    /**
     * Get correopersonal
     *
     * @return string
     */
    public function getCorreopersonal()
    {
        return $this->correopersonal;
    }

    /**
     * Set correoinstitucional
     *
     * @param string $correoinstitucional
     *
     * @return CeProfesor
     */
    public function setCorreoinstitucional($correoinstitucional)
    {
        $this->correoinstitucional = $correoinstitucional;

        return $this;
    }

    /**
     * Get correoinstitucional
     *
     * @return string
     */
    public function getCorreoinstitucional()
    {
        return $this->correoinstitucional;
    }

    /**
     * Set telefonofijo
     *
     * @param string $telefonofijo
     *
     * @return CeProfesor
     */
    public function setTelefonofijo($telefonofijo)
    {
        $this->telefonofijo = $telefonofijo;

        return $this;
    }

    /**
     * Get telefonofijo
     *
     * @return string
     */
    public function getTelefonofijo()
    {
        return $this->telefonofijo;
    }

    /**
     * Set celular
     *
     * @param string $celular
     *
     * @return CeProfesor
     */
    public function setCelular($celular)
    {
        $this->celular = $celular;

        return $this;
    }

    /**
     * Get celular
     *
     * @return string
     */
    public function getCelular()
    {
        return $this->celular;
    }

    /**
     * Set nombrecompletoemergencia
     *
     * @param string $nombrecompletoemergencia
     *
     * @return CeProfesor
     */
    public function setNombrecompletoemergencia($nombrecompletoemergencia)
    {
        $this->nombrecompletoemergencia = $nombrecompletoemergencia;

        return $this;
    }

    /**
     * Get nombrecompletoemergencia
     *
     * @return string
     */
    public function getNombrecompletoemergencia()
    {
        return $this->nombrecompletoemergencia;
    }

    /**
     * Set celular2
     *
     * @param string $celular2
     *
     * @return CeProfesor
     */
    public function setCelular2($celular2)
    {
        $this->celular2 = $celular2;

        return $this;
    }

    /**
     * Get celular2
     *
     * @return string
     */
    public function getCelular2()
    {
        return $this->celular2;
    }

    /**
     * Set numeronomina
     *
     * @param string $numeronomina
     *
     * @return CeProfesor
     */
    public function setNumeronomina($numeronomina)
    {
        $this->numeronomina = $numeronomina;

        return $this;
    }

    /**
     * Get numeronomina
     *
     * @return string
     */
    public function getNumeronomina()
    {
        return $this->numeronomina;
    }

    /**
     * Set fechanacimiento
     *
     * @param \DateTime $fechanacimiento
     *
     * @return CeProfesor
     */
    public function setFechanacimiento($fechanacimiento)
    {
        $this->fechanacimiento = $fechanacimiento;

        return $this;
    }

    /**
     * Get fechanacimiento
     *
     * @return \DateTime
     */
    public function getFechanacimiento()
    {
        return $this->fechanacimiento;
    }

    /**
     * Set genero
     *
     * @param string $genero
     *
     * @return CeProfesor
     */
    public function setGenero($genero)
    {
        $this->genero = $genero;

        return $this;
    }

    /**
     * Get genero
     *
     * @return string
     */
    public function getGenero()
    {
        return $this->genero;
    }

    /**
     * Set curp
     *
     * @param string $curp
     *
     * @return CeProfesor
     */
    public function setCurp($curp)
    {
        $this->curp = $curp;

        return $this;
    }

    /**
     * Get curp
     *
     * @return string
     */
    public function getCurp()
    {
        return $this->curp;
    }

    /**
     * Set estadocivil
     *
     * @param string $estadocivil
     *
     * @return CeProfesor
     */
    public function setEstadocivil($estadocivil)
    {
        $this->estadocivil = $estadocivil;

        return $this;
    }

    /**
     * Get estadocivil
     *
     * @return string
     */
    public function getEstadocivil()
    {
        return $this->estadocivil;
    }

    /**
     * Set rfc
     *
     * @param string $rfc
     *
     * @return CeProfesor
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
     * Set nacionalidad
     *
     * @param string $nacionalidad
     *
     * @return CeProfesor
     */
    public function setNacionalidad($nacionalidad)
    {
        $this->nacionalidad = $nacionalidad;

        return $this;
    }

    /**
     * Get nacionalidad
     *
     * @return string
     */
    public function getNacionalidad()
    {
        return $this->nacionalidad;
    }

    /**
     * Set nss
     *
     * @param string $nss
     *
     * @return CeProfesor
     */
    public function setNss($nss)
    {
        $this->nss = $nss;

        return $this;
    }

    /**
     * Get nss
     *
     * @return string
     */
    public function getNss()
    {
        return $this->nss;
    }

    /**
     * Set codigopostal
     *
     * @param string $codigopostal
     *
     * @return CeProfesor
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
     * Set ciudadid
     *
     * @param integer $ciudadid
     *
     * @return CeProfesor
     */
    public function setCiudadid($ciudadid)
    {
        $this->ciudadid = $ciudadid;

        return $this;
    }

    /**
     * Get ciudadid
     *
     * @return integer
     */
    public function getCiudadid()
    {
        return $this->ciudadid;
    }

    /**
     * Set calle
     *
     * @param string $calle
     *
     * @return CeProfesor
     */
    public function setCalle($calle)
    {
        $this->calle = $calle;

        return $this;
    }

    /**
     * Get calle
     *
     * @return string
     */
    public function getCalle()
    {
        return $this->calle;
    }

    /**
     * Set numeroexterior
     *
     * @param string $numeroexterior
     *
     * @return CeProfesor
     */
    public function setNumeroexterior($numeroexterior)
    {
        $this->numeroexterior = $numeroexterior;

        return $this;
    }

    /**
     * Get numeroexterior
     *
     * @return string
     */
    public function getNumeroexterior()
    {
        return $this->numeroexterior;
    }

    /**
     * Set numerointerior
     *
     * @param string $numerointerior
     *
     * @return CeProfesor
     */
    public function setNumerointerior($numerointerior)
    {
        $this->numerointerior = $numerointerior;

        return $this;
    }

    /**
     * Get numerointerior
     *
     * @return string
     */
    public function getNumerointerior()
    {
        return $this->numerointerior;
    }

    /**
     * Set fotografia
     *
     * @param string $fotografia
     *
     * @return CeProfesor
     */
    public function setFotografia($fotografia)
    {
        $this->fotografia = $fotografia;

        return $this;
    }

    /**
     * Get fotografia
     *
     * @return string
     */
    public function getFotografia()
    {
        return $this->fotografia;
    }

    /**
     * Set otracolonia
     *
     * @param string $otracolonia
     *
     * @return CeProfesor
     */
    public function setOtracolonia($otracolonia)
    {
        $this->otracolonia = $otracolonia;

        return $this;
    }

    /**
     * Get otracolonia
     *
     * @return string
     */
    public function getOtracolonia()
    {
        return $this->otracolonia;
    }

    /**
     * Set experienciasep
     *
     * @param \DateTime $experienciasep
     *
     * @return CeProfesor
     */
    public function setExperienciasep($experienciasep)
    {
        $this->experienciasep = $experienciasep;

        return $this;
    }

    /**
     * Get experienciasep
     *
     * @return \DateTime
     */
    public function getExperienciasep()
    {
        return $this->experienciasep;
    }

    /**
     * Set experienciainstituto
     *
     * @param float $experienciainstituto
     *
     * @return CeProfesor
     */
    public function setExperienciainstituto($experienciainstituto)
    {
        $this->experienciainstituto = $experienciainstituto;

        return $this;
    }

    /**
     * Get experienciainstituto
     *
     * @return float
     */
    public function getExperienciainstituto()
    {
        return $this->experienciainstituto;
    }

    /**
     * Set autorizaciondgb
     *
     * @param string $autorizaciondgb
     *
     * @return CeProfesor
     */
    public function setAutorizaciondgb($autorizaciondgb)
    {
        $this->autorizaciondgb = $autorizaciondgb;

        return $this;
    }

    /**
     * Get autorizaciondgb
     *
     * @return string
     */
    public function getAutorizaciondgb()
    {
        return $this->autorizaciondgb;
    }

    /**
     * Set autorizacionsep
     *
     * @param string $autorizacionsep
     *
     * @return CeProfesor
     */
    public function setAutorizacionsep($autorizacionsep)
    {
        $this->autorizacionsep = $autorizacionsep;

        return $this;
    }

    /**
     * Get autorizacionsep
     *
     * @return string
     */
    public function getAutorizacionsep()
    {
        return $this->autorizacionsep;
    }

    /**
     * Get profesorid
     *
     * @return integer
     */
    public function getProfesorid()
    {
        return $this->profesorid;
    }

    /**
     * Set estatusempleadoid
     *
     * @param \AppBundle\Entity\CeEstatusempleado $estatusempleadoid
     *
     * @return CeProfesor
     */
    public function setEstatusempleadoid(\AppBundle\Entity\CeEstatusempleado $estatusempleadoid = null)
    {
        $this->estatusempleadoid = $estatusempleadoid;

        return $this;
    }

    /**
     * Get estatusempleadoid
     *
     * @return \AppBundle\Entity\CeEstatusempleado
     */
    public function getEstatusempleadoid()
    {
        return $this->estatusempleadoid;
    }

    /**
     * Set estadoid
     *
     * @param \AppBundle\Entity\Estado $estadoid
     *
     * @return CeProfesor
     */
    public function setEstadoid(\AppBundle\Entity\Estado $estadoid = null)
    {
        $this->estadoid = $estadoid;

        return $this;
    }

    /**
     * Get estadoid
     *
     * @return \AppBundle\Entity\Estado
     */
    public function getEstadoid()
    {
        return $this->estadoid;
    }

    /**
     * Set parentescoid
     *
     * @param \AppBundle\Entity\Parentesco $parentescoid
     *
     * @return CeProfesor
     */
    public function setParentescoid(\AppBundle\Entity\Parentesco $parentescoid = null)
    {
        $this->parentescoid = $parentescoid;

        return $this;
    }

    /**
     * Get parentescoid
     *
     * @return \AppBundle\Entity\Parentesco
     */
    public function getParentescoid()
    {
        return $this->parentescoid;
    }

    /**
     * Set coloniaid
     *
     * @param \AppBundle\Entity\Colonia $coloniaid
     *
     * @return CeProfesor
     */
    public function setColoniaid(\AppBundle\Entity\Colonia $coloniaid = null)
    {
        $this->coloniaid = $coloniaid;

        return $this;
    }

    /**
     * Get coloniaid
     *
     * @return \AppBundle\Entity\Colonia
     */
    public function getColoniaid()
    {
        return $this->coloniaid;
    }
}

