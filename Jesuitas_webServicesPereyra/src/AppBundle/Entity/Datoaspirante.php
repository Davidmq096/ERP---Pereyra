<?php

namespace AppBundle\Entity;

/**
 * Datoaspirante
 */
class Datoaspirante
{
    /**
     * @var string
     */
    private $ciudadescuelaprocedencia;

    /**
     * @var string
     */
    private $foto;

    /**
     * @var string
     */
    private $fotofamiliar;

    /**
     * @var string
     */
    private $nombre;

    /**
     * @var string
     */
    private $apellidopaterno;

    /**
     * @var string
     */
    private $apellidomaterno;

    /**
     * @var string
     */
    private $curp;

    /**
     * @var \DateTime
     */
    private $fechanacimiento;

    /**
     * @var integer
     */
    private $edadanos;

    /**
     * @var integer
     */
    private $edadmes;

    /**
     * @var string
     */
    private $sexo;

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
    private $numerointeriror;

    /**
     * @var string
     */
    private $colonia;

    /**
     * @var string
     */
    private $otracolonia;

    /**
     * @var string
     */
    private $cp;

    /**
     * @var boolean
     */
    private $extranjero;

    /**
     * @var string
     */
    private $celular;

    /**
     * @var string
     */
    private $email;

    /**
     * @var string
     */
    private $nombreescuelaprocedencia;

    /**
     * @var float
     */
    private $promedioactual;

    /**
     * @var float
     */
    private $promedioanterior;

    /**
     * @var integer
     */
    private $numerohermanos;

    /**
     * @var boolean
     */
    private $gradosextrangero;

    /**
     * @var string
     */
    private $lugargradosextranger;

    /**
     * @var string
     */
    private $gradosprescolar;

    /**
     * @var string
     */
    private $areafortalecer;

    /**
     * @var integer
     */
    private $datoaspiranteid;

    /**
     * @var \AppBundle\Entity\Colonia
     */
    private $coloniaid;

    /**
     * @var \AppBundle\Entity\Dinamicafamiliar
     */
    private $dinamicafamiliarid;

    /**
     * @var \AppBundle\Entity\Municipio
     */
    private $municipionacimientoid;

    /**
     * @var \AppBundle\Entity\Municipio
     */
    private $municipioviviendaid;

    /**
     * @var \AppBundle\Entity\Nacionalidad
     */
    private $nacionalidadid;

    /**
     * @var \AppBundle\Entity\Vivecon
     */
    private $viveconid;


    /**
     * Set ciudadescuelaprocedencia
     *
     * @param string $ciudadescuelaprocedencia
     *
     * @return Datoaspirante
     */
    public function setCiudadescuelaprocedencia($ciudadescuelaprocedencia)
    {
        $this->ciudadescuelaprocedencia = $ciudadescuelaprocedencia;

        return $this;
    }

    /**
     * Get ciudadescuelaprocedencia
     *
     * @return string
     */
    public function getCiudadescuelaprocedencia()
    {
        return $this->ciudadescuelaprocedencia;
    }

    /**
     * Set foto
     *
     * @param string $foto
     *
     * @return Datoaspirante
     */
    public function setFoto($foto)
    {
        $this->foto = $foto;

        return $this;
    }

    /**
     * Get foto
     *
     * @return string
     */
    public function getFoto()
    {
        return $this->foto;
    }

    /**
     * Set fotofamiliar
     *
     * @param string $fotofamiliar
     *
     * @return Datoaspirante
     */
    public function setFotofamiliar($fotofamiliar)
    {
        $this->fotofamiliar = $fotofamiliar;

        return $this;
    }

    /**
     * Get fotofamiliar
     *
     * @return string
     */
    public function getFotofamiliar()
    {
        return $this->fotofamiliar;
    }

    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return Datoaspirante
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
     * Set apellidopaterno
     *
     * @param string $apellidopaterno
     *
     * @return Datoaspirante
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
     * Set apellidomaterno
     *
     * @param string $apellidomaterno
     *
     * @return Datoaspirante
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
     * Set curp
     *
     * @param string $curp
     *
     * @return Datoaspirante
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
     * Set fechanacimiento
     *
     * @param \DateTime $fechanacimiento
     *
     * @return Datoaspirante
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
     * Set edadanos
     *
     * @param integer $edadanos
     *
     * @return Datoaspirante
     */
    public function setEdadanos($edadanos)
    {
        $this->edadanos = $edadanos;

        return $this;
    }

    /**
     * Get edadanos
     *
     * @return integer
     */
    public function getEdadanos()
    {
        return $this->edadanos;
    }

    /**
     * Set edadmes
     *
     * @param integer $edadmes
     *
     * @return Datoaspirante
     */
    public function setEdadmes($edadmes)
    {
        $this->edadmes = $edadmes;

        return $this;
    }

    /**
     * Get edadmes
     *
     * @return integer
     */
    public function getEdadmes()
    {
        return $this->edadmes;
    }

    /**
     * Set sexo
     *
     * @param string $sexo
     *
     * @return Datoaspirante
     */
    public function setSexo($sexo)
    {
        $this->sexo = $sexo;

        return $this;
    }

    /**
     * Get sexo
     *
     * @return string
     */
    public function getSexo()
    {
        return $this->sexo;
    }

    /**
     * Set calle
     *
     * @param string $calle
     *
     * @return Datoaspirante
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
     * @return Datoaspirante
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
     * Set numerointeriror
     *
     * @param string $numerointeriror
     *
     * @return Datoaspirante
     */
    public function setNumerointeriror($numerointeriror)
    {
        $this->numerointeriror = $numerointeriror;

        return $this;
    }

    /**
     * Get numerointeriror
     *
     * @return string
     */
    public function getNumerointeriror()
    {
        return $this->numerointeriror;
    }

    /**
     * Set colonia
     *
     * @param string $colonia
     *
     * @return Datoaspirante
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
     * Set otracolonia
     *
     * @param string $otracolonia
     *
     * @return Datoaspirante
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
     * Set cp
     *
     * @param string $cp
     *
     * @return Datoaspirante
     */
    public function setCp($cp)
    {
        $this->cp = $cp;

        return $this;
    }

    /**
     * Get cp
     *
     * @return string
     */
    public function getCp()
    {
        return $this->cp;
    }

    /**
     * Set extranjero
     *
     * @param boolean $extranjero
     *
     * @return Datoaspirante
     */
    public function setExtranjero($extranjero)
    {
        $this->extranjero = $extranjero;

        return $this;
    }

    /**
     * Get extranjero
     *
     * @return boolean
     */
    public function getExtranjero()
    {
        return $this->extranjero;
    }

    /**
     * Set celular
     *
     * @param string $celular
     *
     * @return Datoaspirante
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
     * Set email
     *
     * @param string $email
     *
     * @return Datoaspirante
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set nombreescuelaprocedencia
     *
     * @param string $nombreescuelaprocedencia
     *
     * @return Datoaspirante
     */
    public function setNombreescuelaprocedencia($nombreescuelaprocedencia)
    {
        $this->nombreescuelaprocedencia = $nombreescuelaprocedencia;

        return $this;
    }

    /**
     * Get nombreescuelaprocedencia
     *
     * @return string
     */
    public function getNombreescuelaprocedencia()
    {
        return $this->nombreescuelaprocedencia;
    }

    /**
     * Set promedioactual
     *
     * @param float $promedioactual
     *
     * @return Datoaspirante
     */
    public function setPromedioactual($promedioactual)
    {
        $this->promedioactual = $promedioactual;

        return $this;
    }

    /**
     * Get promedioactual
     *
     * @return float
     */
    public function getPromedioactual()
    {
        return $this->promedioactual;
    }

    /**
     * Set promedioanterior
     *
     * @param float $promedioanterior
     *
     * @return Datoaspirante
     */
    public function setPromedioanterior($promedioanterior)
    {
        $this->promedioanterior = $promedioanterior;

        return $this;
    }

    /**
     * Get promedioanterior
     *
     * @return float
     */
    public function getPromedioanterior()
    {
        return $this->promedioanterior;
    }

    /**
     * Set numerohermanos
     *
     * @param integer $numerohermanos
     *
     * @return Datoaspirante
     */
    public function setNumerohermanos($numerohermanos)
    {
        $this->numerohermanos = $numerohermanos;

        return $this;
    }

    /**
     * Get numerohermanos
     *
     * @return integer
     */
    public function getNumerohermanos()
    {
        return $this->numerohermanos;
    }

    /**
     * Set gradosextrangero
     *
     * @param boolean $gradosextrangero
     *
     * @return Datoaspirante
     */
    public function setGradosextrangero($gradosextrangero)
    {
        $this->gradosextrangero = $gradosextrangero;

        return $this;
    }

    /**
     * Get gradosextrangero
     *
     * @return boolean
     */
    public function getGradosextrangero()
    {
        return $this->gradosextrangero;
    }

    /**
     * Set lugargradosextranger
     *
     * @param string $lugargradosextranger
     *
     * @return Datoaspirante
     */
    public function setLugargradosextranger($lugargradosextranger)
    {
        $this->lugargradosextranger = $lugargradosextranger;

        return $this;
    }

    /**
     * Get lugargradosextranger
     *
     * @return string
     */
    public function getLugargradosextranger()
    {
        return $this->lugargradosextranger;
    }

    /**
     * Set gradosprescolar
     *
     * @param string $gradosprescolar
     *
     * @return Datoaspirante
     */
    public function setGradosprescolar($gradosprescolar)
    {
        $this->gradosprescolar = $gradosprescolar;

        return $this;
    }

    /**
     * Get gradosprescolar
     *
     * @return string
     */
    public function getGradosprescolar()
    {
        return $this->gradosprescolar;
    }

    /**
     * Set areafortalecer
     *
     * @param string $areafortalecer
     *
     * @return Datoaspirante
     */
    public function setAreafortalecer($areafortalecer)
    {
        $this->areafortalecer = $areafortalecer;

        return $this;
    }

    /**
     * Get areafortalecer
     *
     * @return string
     */
    public function getAreafortalecer()
    {
        return $this->areafortalecer;
    }

    /**
     * Get datoaspiranteid
     *
     * @return integer
     */
    public function getDatoaspiranteid()
    {
        return $this->datoaspiranteid;
    }

    /**
     * Set coloniaid
     *
     * @param \AppBundle\Entity\Colonia $coloniaid
     *
     * @return Datoaspirante
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

    /**
     * Set dinamicafamiliarid
     *
     * @param \AppBundle\Entity\Dinamicafamiliar $dinamicafamiliarid
     *
     * @return Datoaspirante
     */
    public function setDinamicafamiliarid(\AppBundle\Entity\Dinamicafamiliar $dinamicafamiliarid = null)
    {
        $this->dinamicafamiliarid = $dinamicafamiliarid;

        return $this;
    }

    /**
     * Get dinamicafamiliarid
     *
     * @return \AppBundle\Entity\Dinamicafamiliar
     */
    public function getDinamicafamiliarid()
    {
        return $this->dinamicafamiliarid;
    }

    /**
     * Set municipionacimientoid
     *
     * @param \AppBundle\Entity\Municipio $municipionacimientoid
     *
     * @return Datoaspirante
     */
    public function setMunicipionacimientoid(\AppBundle\Entity\Municipio $municipionacimientoid = null)
    {
        $this->municipionacimientoid = $municipionacimientoid;

        return $this;
    }

    /**
     * Get municipionacimientoid
     *
     * @return \AppBundle\Entity\Municipio
     */
    public function getMunicipionacimientoid()
    {
        return $this->municipionacimientoid;
    }

    /**
     * Set municipioviviendaid
     *
     * @param \AppBundle\Entity\Municipio $municipioviviendaid
     *
     * @return Datoaspirante
     */
    public function setMunicipioviviendaid(\AppBundle\Entity\Municipio $municipioviviendaid = null)
    {
        $this->municipioviviendaid = $municipioviviendaid;

        return $this;
    }

    /**
     * Get municipioviviendaid
     *
     * @return \AppBundle\Entity\Municipio
     */
    public function getMunicipioviviendaid()
    {
        return $this->municipioviviendaid;
    }

    /**
     * Set nacionalidadid
     *
     * @param \AppBundle\Entity\Nacionalidad $nacionalidadid
     *
     * @return Datoaspirante
     */
    public function setNacionalidadid(\AppBundle\Entity\Nacionalidad $nacionalidadid = null)
    {
        $this->nacionalidadid = $nacionalidadid;

        return $this;
    }

    /**
     * Get nacionalidadid
     *
     * @return \AppBundle\Entity\Nacionalidad
     */
    public function getNacionalidadid()
    {
        return $this->nacionalidadid;
    }

    /**
     * Set viveconid
     *
     * @param \AppBundle\Entity\Vivecon $viveconid
     *
     * @return Datoaspirante
     */
    public function setViveconid(\AppBundle\Entity\Vivecon $viveconid = null)
    {
        $this->viveconid = $viveconid;

        return $this;
    }

    /**
     * Get viveconid
     *
     * @return \AppBundle\Entity\Vivecon
     */
    public function getViveconid()
    {
        return $this->viveconid;
    }
}

