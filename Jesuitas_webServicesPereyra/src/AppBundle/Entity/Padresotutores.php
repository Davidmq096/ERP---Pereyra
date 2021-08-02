<?php

namespace AppBundle\Entity;

/**
 * Padresotutores
 */
class Padresotutores
{
    /**
     * @var string
     */
    private $ocupacion;

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
    private $finado;

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
    private $extencionempresa;

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
     * @var integer
     */
    private $tipoocupacion;

    /**
     * @var integer
     */
    private $padresotutoresid;

    /**
     * @var \AppBundle\Entity\Escolaridad
     */
    private $nivelestudioid;

    /**
     * @var \AppBundle\Entity\Generacion
     */
    private $generacionid;

    /**
     * @var \AppBundle\Entity\Situacionconyugal
     */
    private $situacionconyugal;

    /**
     * @var \AppBundle\Entity\Solicitudadmision
     */
    private $solicitudadmisionid;

    /**
     * @var \AppBundle\Entity\Tutor
     */
    private $tutorid;

    /**
     * @var \AppBundle\Entity\Tiposanguineo
     */
    private $tiposanguineoid;


    /**
     * Set ocupacion
     *
     * @param string $ocupacion
     *
     * @return Padresotutores
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
     * Set nombre
     *
     * @param string $nombre
     *
     * @return Padresotutores
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
     * @return Padresotutores
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
     * @return Padresotutores
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
     * @return Padresotutores
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
     * @return Padresotutores
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
     * @return Padresotutores
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
     * @return Padresotutores
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
     * @return Padresotutores
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
     * @return Padresotutores
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
     * @return Padresotutores
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
     * @return Padresotutores
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
     * Set finado
     *
     * @param boolean $finado
     *
     * @return Padresotutores
     */
    public function setFinado($finado)
    {
        $this->finado = $finado;

        return $this;
    }

    /**
     * Get finado
     *
     * @return boolean
     */
    public function getFinado()
    {
        return $this->finado;
    }

    /**
     * Set fechanacimiento
     *
     * @param \DateTime $fechanacimiento
     *
     * @return Padresotutores
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
     * @return Padresotutores
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
     * @return Padresotutores
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
     * @return Padresotutores
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
     * @return Padresotutores
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
     * Set extencionempresa
     *
     * @param string $extencionempresa
     *
     * @return Padresotutores
     */
    public function setExtencionempresa($extencionempresa)
    {
        $this->extencionempresa = $extencionempresa;

        return $this;
    }

    /**
     * Get extencionempresa
     *
     * @return string
     */
    public function getExtencionempresa()
    {
        return $this->extencionempresa;
    }

    /**
     * Set horariotrabajo
     *
     * @param string $horariotrabajo
     *
     * @return Padresotutores
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
     * @return Padresotutores
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
     * @return Padresotutores
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
     * @return Padresotutores
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
     * @return Padresotutores
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
     * Set tipoocupacion
     *
     * @param integer $tipoocupacion
     *
     * @return Padresotutores
     */
    public function setTipoocupacion($tipoocupacion)
    {
        $this->tipoocupacion = $tipoocupacion;

        return $this;
    }

    /**
     * Get tipoocupacion
     *
     * @return integer
     */
    public function getTipoocupacion()
    {
        return $this->tipoocupacion;
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
     * Set nivelestudioid
     *
     * @param \AppBundle\Entity\Escolaridad $nivelestudioid
     *
     * @return Padresotutores
     */
    public function setNivelestudioid(\AppBundle\Entity\Escolaridad $nivelestudioid = null)
    {
        $this->nivelestudioid = $nivelestudioid;

        return $this;
    }

    /**
     * Get nivelestudioid
     *
     * @return \AppBundle\Entity\Escolaridad
     */
    public function getNivelestudioid()
    {
        return $this->nivelestudioid;
    }

    /**
     * Set generacionid
     *
     * @param \AppBundle\Entity\Generacion $generacionid
     *
     * @return Padresotutores
     */
    public function setGeneracionid(\AppBundle\Entity\Generacion $generacionid = null)
    {
        $this->generacionid = $generacionid;

        return $this;
    }

    /**
     * Get generacionid
     *
     * @return \AppBundle\Entity\Generacion
     */
    public function getGeneracionid()
    {
        return $this->generacionid;
    }

    /**
     * Set situacionconyugal
     *
     * @param \AppBundle\Entity\Situacionconyugal $situacionconyugal
     *
     * @return Padresotutores
     */
    public function setSituacionconyugal(\AppBundle\Entity\Situacionconyugal $situacionconyugal = null)
    {
        $this->situacionconyugal = $situacionconyugal;

        return $this;
    }

    /**
     * Get situacionconyugal
     *
     * @return \AppBundle\Entity\Situacionconyugal
     */
    public function getSituacionconyugal()
    {
        return $this->situacionconyugal;
    }

    /**
     * Set solicitudadmisionid
     *
     * @param \AppBundle\Entity\Solicitudadmision $solicitudadmisionid
     *
     * @return Padresotutores
     */
    public function setSolicitudadmisionid(\AppBundle\Entity\Solicitudadmision $solicitudadmisionid = null)
    {
        $this->solicitudadmisionid = $solicitudadmisionid;

        return $this;
    }

    /**
     * Get solicitudadmisionid
     *
     * @return \AppBundle\Entity\Solicitudadmision
     */
    public function getSolicitudadmisionid()
    {
        return $this->solicitudadmisionid;
    }

    /**
     * Set tutorid
     *
     * @param \AppBundle\Entity\Tutor $tutorid
     *
     * @return Padresotutores
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

    /**
     * Set tiposanguineoid
     *
     * @param \AppBundle\Entity\Tiposanguineo $tiposanguineoid
     *
     * @return Padresotutores
     */
    public function setTiposanguineoid(\AppBundle\Entity\Tiposanguineo $tiposanguineoid = null)
    {
        $this->tiposanguineoid = $tiposanguineoid;

        return $this;
    }

    /**
     * Get tiposanguineoid
     *
     * @return \AppBundle\Entity\Tiposanguineo
     */
    public function getTiposanguineoid()
    {
        return $this->tiposanguineoid;
    }
}

