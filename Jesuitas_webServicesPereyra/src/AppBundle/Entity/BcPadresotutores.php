<?php

namespace AppBundle\Entity;

/**
 * BcPadresotutores
 */
class BcPadresotutores
{
    /**
     * @var integer
     */
    private $nivelestudioid;

    /**
     * @var string
     */
    private $ocupacion;

    /**
     * @var integer
     */
    private $tiposanguineoid;

    /**
     * @var integer
     */
    private $generacionid;

    /**
     * @var integer
     */
    private $nacionalidadid;

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
    private $telefono;

    /**
     * @var string
     */
    private $celular;

    /**
     * @var string
     */
    private $lugartrabajo;

    /**
     * @var boolean
     */
    private $capturadordatos;

    /**
     * @var boolean
     */
    private $autoriza;

    /**
     * @var boolean
     */
    private $tutor;

    /**
     * @var string
     */
    private $foto;

    /**
     * @var string
     */
    private $curp;

    /**
     * @var boolean
     */
    private $vive;

    /**
     * @var \DateTime
     */
    private $fechanacimiento;

    /**
     * @var string
     */
    private $especificacionocupacion;

    /**
     * @var string
     */
    private $empresa;

    /**
     * @var string
     */
    private $correo;

    /**
     * @var string
     */
    private $telempresa;

    /**
     * @var string
     */
    private $extensionempresa;

    /**
     * @var string
     */
    private $horariotrabajo;

    /**
     * @var boolean
     */
    private $exlux;

    /**
     * @var string
     */
    private $ramo;

    /**
     * @var boolean
     */
    private $alumnoinstituto;

    /**
     * @var string
     */
    private $especificaralumno;

    /**
     * @var boolean
     */
    private $custodia;

    /**
     * @var string
     */
    private $antiguedad;

    /**
     * @var string
     */
    private $nombrejefeinmediato;

    /**
     * @var string
     */
    private $domicilioempresa;

    /**
     * @var integer
     */
    private $clavefamiliarid;

    /**
     * @var integer
     */
    private $padresotutoresid;

    /**
     * @var \AppBundle\Entity\BcIngresoslux
     */
    private $ingresosluxid;

    /**
     * @var \AppBundle\Entity\BcSolicitudbeca
     */
    private $solicitudid;

    /**
     * @var \AppBundle\Entity\Escolaridad
     */
    private $escolaridadid;

    /**
     * @var \AppBundle\Entity\Parentesco
     */
    private $parentescoid;

    /**
     * @var \AppBundle\Entity\Situacionconyugal
     */
    private $situacionconyugalid;

    /**
     * @var \AppBundle\Entity\Tutor
     */
    private $tutorid;


    /**
     * Set nivelestudioid
     *
     * @param integer $nivelestudioid
     *
     * @return BcPadresotutores
     */
    public function setNivelestudioid($nivelestudioid)
    {
        $this->nivelestudioid = $nivelestudioid;

        return $this;
    }

    /**
     * Get nivelestudioid
     *
     * @return integer
     */
    public function getNivelestudioid()
    {
        return $this->nivelestudioid;
    }

    /**
     * Set ocupacion
     *
     * @param string $ocupacion
     *
     * @return BcPadresotutores
     */
    public function setOcupacion($ocupacion)
    {
        $this->ocupacion = $ocupacion;

        return $this;
    }

    /**
     * Get ocupacion
     *
     * @return string
     */
    public function getOcupacion()
    {
        return $this->ocupacion;
    }

    /**
     * Set tiposanguineoid
     *
     * @param integer $tiposanguineoid
     *
     * @return BcPadresotutores
     */
    public function setTiposanguineoid($tiposanguineoid)
    {
        $this->tiposanguineoid = $tiposanguineoid;

        return $this;
    }

    /**
     * Get tiposanguineoid
     *
     * @return integer
     */
    public function getTiposanguineoid()
    {
        return $this->tiposanguineoid;
    }

    /**
     * Set generacionid
     *
     * @param integer $generacionid
     *
     * @return BcPadresotutores
     */
    public function setGeneracionid($generacionid)
    {
        $this->generacionid = $generacionid;

        return $this;
    }

    /**
     * Get generacionid
     *
     * @return integer
     */
    public function getGeneracionid()
    {
        return $this->generacionid;
    }

    /**
     * Set nacionalidadid
     *
     * @param integer $nacionalidadid
     *
     * @return BcPadresotutores
     */
    public function setNacionalidadid($nacionalidadid)
    {
        $this->nacionalidadid = $nacionalidadid;

        return $this;
    }

    /**
     * Get nacionalidadid
     *
     * @return integer
     */
    public function getNacionalidadid()
    {
        return $this->nacionalidadid;
    }

    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return BcPadresotutores
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
     * @return BcPadresotutores
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
     * @return BcPadresotutores
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
     * Set telefono
     *
     * @param string $telefono
     *
     * @return BcPadresotutores
     */
    public function setTelefono($telefono)
    {
        $this->telefono = $telefono;

        return $this;
    }

    /**
     * Get telefono
     *
     * @return string
     */
    public function getTelefono()
    {
        return $this->telefono;
    }

    /**
     * Set celular
     *
     * @param string $celular
     *
     * @return BcPadresotutores
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
     * Set lugartrabajo
     *
     * @param string $lugartrabajo
     *
     * @return BcPadresotutores
     */
    public function setLugartrabajo($lugartrabajo)
    {
        $this->lugartrabajo = $lugartrabajo;

        return $this;
    }

    /**
     * Get lugartrabajo
     *
     * @return string
     */
    public function getLugartrabajo()
    {
        return $this->lugartrabajo;
    }

    /**
     * Set capturadordatos
     *
     * @param boolean $capturadordatos
     *
     * @return BcPadresotutores
     */
    public function setCapturadordatos($capturadordatos)
    {
        $this->capturadordatos = $capturadordatos;

        return $this;
    }

    /**
     * Get capturadordatos
     *
     * @return boolean
     */
    public function getCapturadordatos()
    {
        return $this->capturadordatos;
    }

    /**
     * Set autoriza
     *
     * @param boolean $autoriza
     *
     * @return BcPadresotutores
     */
    public function setAutoriza($autoriza)
    {
        $this->autoriza = $autoriza;

        return $this;
    }

    /**
     * Get autoriza
     *
     * @return boolean
     */
    public function getAutoriza()
    {
        return $this->autoriza;
    }

    /**
     * Set tutor
     *
     * @param boolean $tutor
     *
     * @return BcPadresotutores
     */
    public function setTutor($tutor)
    {
        $this->tutor = $tutor;

        return $this;
    }

    /**
     * Get tutor
     *
     * @return boolean
     */
    public function getTutor()
    {
        return $this->tutor;
    }

    /**
     * Set foto
     *
     * @param string $foto
     *
     * @return BcPadresotutores
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
     * Set curp
     *
     * @param string $curp
     *
     * @return BcPadresotutores
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
     * Set vive
     *
     * @param boolean $vive
     *
     * @return BcPadresotutores
     */
    public function setVive($vive)
    {
        $this->vive = $vive;

        return $this;
    }

    /**
     * Get vive
     *
     * @return boolean
     */
    public function getVive()
    {
        return $this->vive;
    }

    /**
     * Set fechanacimiento
     *
     * @param \DateTime $fechanacimiento
     *
     * @return BcPadresotutores
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
     * Set especificacionocupacion
     *
     * @param string $especificacionocupacion
     *
     * @return BcPadresotutores
     */
    public function setEspecificacionocupacion($especificacionocupacion)
    {
        $this->especificacionocupacion = $especificacionocupacion;

        return $this;
    }

    /**
     * Get especificacionocupacion
     *
     * @return string
     */
    public function getEspecificacionocupacion()
    {
        return $this->especificacionocupacion;
    }

    /**
     * Set empresa
     *
     * @param string $empresa
     *
     * @return BcPadresotutores
     */
    public function setEmpresa($empresa)
    {
        $this->empresa = $empresa;

        return $this;
    }

    /**
     * Get empresa
     *
     * @return string
     */
    public function getEmpresa()
    {
        return $this->empresa;
    }

    /**
     * Set correo
     *
     * @param string $correo
     *
     * @return BcPadresotutores
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
     * Set telempresa
     *
     * @param string $telempresa
     *
     * @return BcPadresotutores
     */
    public function setTelempresa($telempresa)
    {
        $this->telempresa = $telempresa;

        return $this;
    }

    /**
     * Get telempresa
     *
     * @return string
     */
    public function getTelempresa()
    {
        return $this->telempresa;
    }

    /**
     * Set extensionempresa
     *
     * @param string $extensionempresa
     *
     * @return BcPadresotutores
     */
    public function setExtensionempresa($extensionempresa)
    {
        $this->extensionempresa = $extensionempresa;

        return $this;
    }

    /**
     * Get extensionempresa
     *
     * @return string
     */
    public function getExtensionempresa()
    {
        return $this->extensionempresa;
    }

    /**
     * Set horariotrabajo
     *
     * @param string $horariotrabajo
     *
     * @return BcPadresotutores
     */
    public function setHorariotrabajo($horariotrabajo)
    {
        $this->horariotrabajo = $horariotrabajo;

        return $this;
    }

    /**
     * Get horariotrabajo
     *
     * @return string
     */
    public function getHorariotrabajo()
    {
        return $this->horariotrabajo;
    }

    /**
     * Set exlux
     *
     * @param boolean $exlux
     *
     * @return BcPadresotutores
     */
    public function setExlux($exlux)
    {
        $this->exlux = $exlux;

        return $this;
    }

    /**
     * Get exlux
     *
     * @return boolean
     */
    public function getExlux()
    {
        return $this->exlux;
    }

    /**
     * Set ramo
     *
     * @param string $ramo
     *
     * @return BcPadresotutores
     */
    public function setRamo($ramo)
    {
        $this->ramo = $ramo;

        return $this;
    }

    /**
     * Get ramo
     *
     * @return string
     */
    public function getRamo()
    {
        return $this->ramo;
    }

    /**
     * Set alumnoinstituto
     *
     * @param boolean $alumnoinstituto
     *
     * @return BcPadresotutores
     */
    public function setAlumnoinstituto($alumnoinstituto)
    {
        $this->alumnoinstituto = $alumnoinstituto;

        return $this;
    }

    /**
     * Get alumnoinstituto
     *
     * @return boolean
     */
    public function getAlumnoinstituto()
    {
        return $this->alumnoinstituto;
    }

    /**
     * Set especificaralumno
     *
     * @param string $especificaralumno
     *
     * @return BcPadresotutores
     */
    public function setEspecificaralumno($especificaralumno)
    {
        $this->especificaralumno = $especificaralumno;

        return $this;
    }

    /**
     * Get especificaralumno
     *
     * @return string
     */
    public function getEspecificaralumno()
    {
        return $this->especificaralumno;
    }

    /**
     * Set custodia
     *
     * @param boolean $custodia
     *
     * @return BcPadresotutores
     */
    public function setCustodia($custodia)
    {
        $this->custodia = $custodia;

        return $this;
    }

    /**
     * Get custodia
     *
     * @return boolean
     */
    public function getCustodia()
    {
        return $this->custodia;
    }

    /**
     * Set antiguedad
     *
     * @param string $antiguedad
     *
     * @return BcPadresotutores
     */
    public function setAntiguedad($antiguedad)
    {
        $this->antiguedad = $antiguedad;

        return $this;
    }

    /**
     * Get antiguedad
     *
     * @return string
     */
    public function getAntiguedad()
    {
        return $this->antiguedad;
    }

    /**
     * Set nombrejefeinmediato
     *
     * @param string $nombrejefeinmediato
     *
     * @return BcPadresotutores
     */
    public function setNombrejefeinmediato($nombrejefeinmediato)
    {
        $this->nombrejefeinmediato = $nombrejefeinmediato;

        return $this;
    }

    /**
     * Get nombrejefeinmediato
     *
     * @return string
     */
    public function getNombrejefeinmediato()
    {
        return $this->nombrejefeinmediato;
    }

    /**
     * Set domicilioempresa
     *
     * @param string $domicilioempresa
     *
     * @return BcPadresotutores
     */
    public function setDomicilioempresa($domicilioempresa)
    {
        $this->domicilioempresa = $domicilioempresa;

        return $this;
    }

    /**
     * Get domicilioempresa
     *
     * @return string
     */
    public function getDomicilioempresa()
    {
        return $this->domicilioempresa;
    }

    /**
     * Set clavefamiliarid
     *
     * @param integer $clavefamiliarid
     *
     * @return BcPadresotutores
     */
    public function setClavefamiliarid($clavefamiliarid)
    {
        $this->clavefamiliarid = $clavefamiliarid;

        return $this;
    }

    /**
     * Get clavefamiliarid
     *
     * @return integer
     */
    public function getClavefamiliarid()
    {
        return $this->clavefamiliarid;
    }

    /**
     * Get padresotutoresid
     *
     * @return integer
     */
    public function getPadresotutoresid()
    {
        return $this->padresotutoresid;
    }

    /**
     * Set ingresosluxid
     *
     * @param \AppBundle\Entity\BcIngresoslux $ingresosluxid
     *
     * @return BcPadresotutores
     */
    public function setIngresosluxid(\AppBundle\Entity\BcIngresoslux $ingresosluxid = null)
    {
        $this->ingresosluxid = $ingresosluxid;

        return $this;
    }

    /**
     * Get ingresosluxid
     *
     * @return \AppBundle\Entity\BcIngresoslux
     */
    public function getIngresosluxid()
    {
        return $this->ingresosluxid;
    }

    /**
     * Set solicitudid
     *
     * @param \AppBundle\Entity\BcSolicitudbeca $solicitudid
     *
     * @return BcPadresotutores
     */
    public function setSolicitudid(\AppBundle\Entity\BcSolicitudbeca $solicitudid = null)
    {
        $this->solicitudid = $solicitudid;

        return $this;
    }

    /**
     * Get solicitudid
     *
     * @return \AppBundle\Entity\BcSolicitudbeca
     */
    public function getSolicitudid()
    {
        return $this->solicitudid;
    }

    /**
     * Set escolaridadid
     *
     * @param \AppBundle\Entity\Escolaridad $escolaridadid
     *
     * @return BcPadresotutores
     */
    public function setEscolaridadid(\AppBundle\Entity\Escolaridad $escolaridadid = null)
    {
        $this->escolaridadid = $escolaridadid;

        return $this;
    }

    /**
     * Get escolaridadid
     *
     * @return \AppBundle\Entity\Escolaridad
     */
    public function getEscolaridadid()
    {
        return $this->escolaridadid;
    }

    /**
     * Set parentescoid
     *
     * @param \AppBundle\Entity\Parentesco $parentescoid
     *
     * @return BcPadresotutores
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
     * Set situacionconyugalid
     *
     * @param \AppBundle\Entity\Situacionconyugal $situacionconyugalid
     *
     * @return BcPadresotutores
     */
    public function setSituacionconyugalid(\AppBundle\Entity\Situacionconyugal $situacionconyugalid = null)
    {
        $this->situacionconyugalid = $situacionconyugalid;

        return $this;
    }

    /**
     * Get situacionconyugalid
     *
     * @return \AppBundle\Entity\Situacionconyugal
     */
    public function getSituacionconyugalid()
    {
        return $this->situacionconyugalid;
    }

    /**
     * Set tutorid
     *
     * @param \AppBundle\Entity\Tutor $tutorid
     *
     * @return BcPadresotutores
     */
    public function setTutorid(\AppBundle\Entity\Tutor $tutorid = null)
    {
        $this->tutorid = $tutorid;

        return $this;
    }

    /**
     * Get tutorid
     *
     * @return \AppBundle\Entity\Tutor
     */
    public function getTutorid()
    {
        return $this->tutorid;
    }
}

