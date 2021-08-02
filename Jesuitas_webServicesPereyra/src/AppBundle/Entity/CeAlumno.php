<?php

namespace AppBundle\Entity;

/**
 * CeAlumno
 */
class CeAlumno
{
    /**
     * @var string
     */
    private $matricula;

    /**
     * @var string
     */
    private $primernombre;

    /**
     * @var string
     */
    private $segundonombre;

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
     * @var string
     */
    private $sexo;

    /**
     * @var boolean
     */
    private $extranjero;

    /**
     * @var \DateTime
     */
    private $fechaactualizacion;

    /**
     * @var integer
     */
    private $intercambio = '0';

    /**
     * @var string
     */
    private $correoinstitucional;

    /**
     * @var string
     */
    private $matriculadgb;

    /**
     * @var string
     */
    private $custodiapersona;

    /**
     * @var string
     */
    private $custodiaoficio;

    /**
     * @var boolean
     */
    private $oyente;

    /**
     * @var boolean
     */
    private $reingresofuturo;

    /**
     * @var boolean
     */
    private $hijopersonal;

    /**
     * @var boolean
     */
    private $alumnoperseverancia;

    /**
     * @var integer
     */
    private $alumnoid;

    /**
     * @var \AppBundle\Entity\CeAlumnoestatus
     */
    private $alumnoestatusid;

    /**
     * @var \AppBundle\Entity\FoTipocobertura
     */
    private $tipocoberturaid;

    /**
     * @var \AppBundle\Entity\Vivecon
     */
    private $viveconid;

    /**
     * @var \AppBundle\Entity\Usuario
     */
    private $usuarioid;


    /**
     * Set matricula
     *
     * @param string $matricula
     *
     * @return CeAlumno
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
     * Set primernombre
     *
     * @param string $primernombre
     *
     * @return CeAlumno
     */
    public function setPrimernombre($primernombre)
    {
        $this->primernombre = $primernombre;

        return $this;
    }

    /**
     * Get primernombre
     *
     * @return string
     */
    public function getPrimernombre()
    {
        return $this->primernombre;
    }

    /**
     * Set segundonombre
     *
     * @param string $segundonombre
     *
     * @return CeAlumno
     */
    public function setSegundonombre($segundonombre)
    {
        $this->segundonombre = $segundonombre;

        return $this;
    }

    /**
     * Get segundonombre
     *
     * @return string
     */
    public function getSegundonombre()
    {
        return $this->segundonombre;
    }

    /**
     * Set apellidopaterno
     *
     * @param string $apellidopaterno
     *
     * @return CeAlumno
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
     * @return CeAlumno
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
     * @return CeAlumno
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
     * @return CeAlumno
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
     * Set sexo
     *
     * @param string $sexo
     *
     * @return CeAlumno
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
     * Set extranjero
     *
     * @param boolean $extranjero
     *
     * @return CeAlumno
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
     * Set fechaactualizacion
     *
     * @param \DateTime $fechaactualizacion
     *
     * @return CeAlumno
     */
    public function setFechaactualizacion($fechaactualizacion)
    {
        $this->fechaactualizacion = $fechaactualizacion;

        return $this;
    }

    /**
     * Get fechaactualizacion
     *
     * @return \DateTime
     */
    public function getFechaactualizacion()
    {
        return $this->fechaactualizacion;
    }

    /**
     * Set intercambio
     *
     * @param integer $intercambio
     *
     * @return CeAlumno
     */
    public function setIntercambio($intercambio)
    {
        $this->intercambio = $intercambio;

        return $this;
    }

    /**
     * Get intercambio
     *
     * @return integer
     */
    public function getIntercambio()
    {
        return $this->intercambio;
    }

    /**
     * Set correoinstitucional
     *
     * @param string $correoinstitucional
     *
     * @return CeAlumno
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
     * Set matriculadgb
     *
     * @param string $matriculadgb
     *
     * @return CeAlumno
     */
    public function setMatriculadgb($matriculadgb)
    {
        $this->matriculadgb = $matriculadgb;

        return $this;
    }

    /**
     * Get matriculadgb
     *
     * @return string
     */
    public function getMatriculadgb()
    {
        return $this->matriculadgb;
    }

    /**
     * Set custodiapersona
     *
     * @param string $custodiapersona
     *
     * @return CeAlumno
     */
    public function setCustodiapersona($custodiapersona)
    {
        $this->custodiapersona = $custodiapersona;

        return $this;
    }

    /**
     * Get custodiapersona
     *
     * @return string
     */
    public function getCustodiapersona()
    {
        return $this->custodiapersona;
    }

    /**
     * Set custodiaoficio
     *
     * @param string $custodiaoficio
     *
     * @return CeAlumno
     */
    public function setCustodiaoficio($custodiaoficio)
    {
        $this->custodiaoficio = $custodiaoficio;

        return $this;
    }

    /**
     * Get custodiaoficio
     *
     * @return string
     */
    public function getCustodiaoficio()
    {
        return $this->custodiaoficio;
    }

    /**
     * Set oyente
     *
     * @param boolean $oyente
     *
     * @return CeAlumno
     */
    public function setOyente($oyente)
    {
        $this->oyente = $oyente;

        return $this;
    }

    /**
     * Get oyente
     *
     * @return boolean
     */
    public function getOyente()
    {
        return $this->oyente;
    }

    /**
     * Set reingresofuturo
     *
     * @param boolean $reingresofuturo
     *
     * @return CeAlumno
     */
    public function setReingresofuturo($reingresofuturo)
    {
        $this->reingresofuturo = $reingresofuturo;

        return $this;
    }

    /**
     * Get reingresofuturo
     *
     * @return boolean
     */
    public function getReingresofuturo()
    {
        return $this->reingresofuturo;
    }

    /**
     * Set hijopersonal
     *
     * @param boolean $hijopersonal
     *
     * @return CeAlumno
     */
    public function setHijopersonal($hijopersonal)
    {
        $this->hijopersonal = $hijopersonal;

        return $this;
    }

    /**
     * Get hijopersonal
     *
     * @return boolean
     */
    public function getHijopersonal()
    {
        return $this->hijopersonal;
    }

    /**
     * Set alumnoperseverancia
     *
     * @param boolean $alumnoperseverancia
     *
     * @return CeAlumno
     */
    public function setAlumnoperseverancia($alumnoperseverancia)
    {
        $this->alumnoperseverancia = $alumnoperseverancia;

        return $this;
    }

    /**
     * Get alumnoperseverancia
     *
     * @return boolean
     */
    public function getAlumnoperseverancia()
    {
        return $this->alumnoperseverancia;
    }

    /**
     * Get alumnoid
     *
     * @return integer
     */
    public function getAlumnoid()
    {
        return $this->alumnoid;
    }

    /**
     * Set alumnoestatusid
     *
     * @param \AppBundle\Entity\CeAlumnoestatus $alumnoestatusid
     *
     * @return CeAlumno
     */
    public function setAlumnoestatusid(\AppBundle\Entity\CeAlumnoestatus $alumnoestatusid = null)
    {
        $this->alumnoestatusid = $alumnoestatusid;

        return $this;
    }

    /**
     * Get alumnoestatusid
     *
     * @return \AppBundle\Entity\CeAlumnoestatus
     */
    public function getAlumnoestatusid()
    {
        return $this->alumnoestatusid;
    }

    /**
     * Set tipocoberturaid
     *
     * @param \AppBundle\Entity\FoTipocobertura $tipocoberturaid
     *
     * @return CeAlumno
     */
    public function setTipocoberturaid(\AppBundle\Entity\FoTipocobertura $tipocoberturaid = null)
    {
        $this->tipocoberturaid = $tipocoberturaid;

        return $this;
    }

    /**
     * Get tipocoberturaid
     *
     * @return \AppBundle\Entity\FoTipocobertura
     */
    public function getTipocoberturaid()
    {
        return $this->tipocoberturaid;
    }

    /**
     * Set viveconid
     *
     * @param \AppBundle\Entity\Vivecon $viveconid
     *
     * @return CeAlumno
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

    /**
     * Set usuarioid
     *
     * @param \AppBundle\Entity\Usuario $usuarioid
     *
     * @return CeAlumno
     */
    public function setUsuarioid(\AppBundle\Entity\Usuario $usuarioid = null)
    {
        $this->usuarioid = $usuarioid;

        return $this;
    }

    /**
     * Get usuarioid
     *
     * @return \AppBundle\Entity\Usuario
     */
    public function getUsuarioid()
    {
        return $this->usuarioid;
    }
}

