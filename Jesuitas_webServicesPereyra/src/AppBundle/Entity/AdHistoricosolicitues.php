<?php

namespace AppBundle\Entity;

/**
 * AdHistoricosolicitues
 */
class AdHistoricosolicitues
{
    /**
     * @var string
     */
    private $ciclo;

    /**
     * @var string
     */
    private $seccion;

    /**
     * @var string
     */
    private $grado;

    /**
     * @var integer
     */
    private $solicitudadmisionid;

    /**
     * @var string
     */
    private $capturainternet;

    /**
     * @var string
     */
    private $estatus;

    /**
     * @var string
     */
    private $pagado;

    /**
     * @var \DateTime
     */
    private $fecha;

    /**
     * @var string
     */
    private $dictamenid;

    /**
     * @var string
     */
    private $dictaminada;

    /**
     * @var string
     */
    private $aspirante;

    /**
     * @var integer
     */
    private $pagadabin;

    /**
     * @var string
     */
    private $correo;

    /**
     * @var string
     */
    private $telefono;

    /**
     * @var integer
     */
    private $validadabin;

    /**
     * @var boolean
     */
    private $cicloactual;

    /**
     * @var integer
     */
    private $cicloanterior;

    /**
     * @var integer
     */
    private $pagadabinanterior;

    /**
     * @var \DateTime
     */
    private $fechacaptura;

    /**
     * @var integer
     */
    private $inscriotobin;

    /**
     * @var integer
     */
    private $dictamenbin;

    /**
     * @var integer
     */
    private $dia = '0';

    /**
     * @var integer
     */
    private $diavalidacion = '0';

    /**
     * @var integer
     */
    private $historicosolicitudesid;


    /**
     * Set ciclo
     *
     * @param string $ciclo
     *
     * @return AdHistoricosolicitues
     */
    public function setCiclo($ciclo)
    {
        $this->ciclo = $ciclo;

        return $this;
    }

    /**
     * Get ciclo
     *
     * @return string
     */
    public function getCiclo()
    {
        return $this->ciclo;
    }

    /**
     * Set seccion
     *
     * @param string $seccion
     *
     * @return AdHistoricosolicitues
     */
    public function setSeccion($seccion)
    {
        $this->seccion = $seccion;

        return $this;
    }

    /**
     * Get seccion
     *
     * @return string
     */
    public function getSeccion()
    {
        return $this->seccion;
    }

    /**
     * Set grado
     *
     * @param string $grado
     *
     * @return AdHistoricosolicitues
     */
    public function setGrado($grado)
    {
        $this->grado = $grado;

        return $this;
    }

    /**
     * Get grado
     *
     * @return string
     */
    public function getGrado()
    {
        return $this->grado;
    }

    /**
     * Set solicitudadmisionid
     *
     * @param integer $solicitudadmisionid
     *
     * @return AdHistoricosolicitues
     */
    public function setSolicitudadmisionid($solicitudadmisionid)
    {
        $this->solicitudadmisionid = $solicitudadmisionid;

        return $this;
    }

    /**
     * Get solicitudadmisionid
     *
     * @return integer
     */
    public function getSolicitudadmisionid()
    {
        return $this->solicitudadmisionid;
    }

    /**
     * Set capturainternet
     *
     * @param string $capturainternet
     *
     * @return AdHistoricosolicitues
     */
    public function setCapturainternet($capturainternet)
    {
        $this->capturainternet = $capturainternet;

        return $this;
    }

    /**
     * Get capturainternet
     *
     * @return string
     */
    public function getCapturainternet()
    {
        return $this->capturainternet;
    }

    /**
     * Set estatus
     *
     * @param string $estatus
     *
     * @return AdHistoricosolicitues
     */
    public function setEstatus($estatus)
    {
        $this->estatus = $estatus;

        return $this;
    }

    /**
     * Get estatus
     *
     * @return string
     */
    public function getEstatus()
    {
        return $this->estatus;
    }

    /**
     * Set pagado
     *
     * @param string $pagado
     *
     * @return AdHistoricosolicitues
     */
    public function setPagado($pagado)
    {
        $this->pagado = $pagado;

        return $this;
    }

    /**
     * Get pagado
     *
     * @return string
     */
    public function getPagado()
    {
        return $this->pagado;
    }

    /**
     * Set fecha
     *
     * @param \DateTime $fecha
     *
     * @return AdHistoricosolicitues
     */
    public function setFecha($fecha)
    {
        $this->fecha = $fecha;

        return $this;
    }

    /**
     * Get fecha
     *
     * @return \DateTime
     */
    public function getFecha()
    {
        return $this->fecha;
    }

    /**
     * Set dictamenid
     *
     * @param string $dictamenid
     *
     * @return AdHistoricosolicitues
     */
    public function setDictamenid($dictamenid)
    {
        $this->dictamenid = $dictamenid;

        return $this;
    }

    /**
     * Get dictamenid
     *
     * @return string
     */
    public function getDictamenid()
    {
        return $this->dictamenid;
    }

    /**
     * Set dictaminada
     *
     * @param string $dictaminada
     *
     * @return AdHistoricosolicitues
     */
    public function setDictaminada($dictaminada)
    {
        $this->dictaminada = $dictaminada;

        return $this;
    }

    /**
     * Get dictaminada
     *
     * @return string
     */
    public function getDictaminada()
    {
        return $this->dictaminada;
    }

    /**
     * Set aspirante
     *
     * @param string $aspirante
     *
     * @return AdHistoricosolicitues
     */
    public function setAspirante($aspirante)
    {
        $this->aspirante = $aspirante;

        return $this;
    }

    /**
     * Get aspirante
     *
     * @return string
     */
    public function getAspirante()
    {
        return $this->aspirante;
    }

    /**
     * Set pagadabin
     *
     * @param integer $pagadabin
     *
     * @return AdHistoricosolicitues
     */
    public function setPagadabin($pagadabin)
    {
        $this->pagadabin = $pagadabin;

        return $this;
    }

    /**
     * Get pagadabin
     *
     * @return integer
     */
    public function getPagadabin()
    {
        return $this->pagadabin;
    }

    /**
     * Set correo
     *
     * @param string $correo
     *
     * @return AdHistoricosolicitues
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
     * Set telefono
     *
     * @param string $telefono
     *
     * @return AdHistoricosolicitues
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
     * Set validadabin
     *
     * @param integer $validadabin
     *
     * @return AdHistoricosolicitues
     */
    public function setValidadabin($validadabin)
    {
        $this->validadabin = $validadabin;

        return $this;
    }

    /**
     * Get validadabin
     *
     * @return integer
     */
    public function getValidadabin()
    {
        return $this->validadabin;
    }

    /**
     * Set cicloactual
     *
     * @param boolean $cicloactual
     *
     * @return AdHistoricosolicitues
     */
    public function setCicloactual($cicloactual)
    {
        $this->cicloactual = $cicloactual;

        return $this;
    }

    /**
     * Get cicloactual
     *
     * @return boolean
     */
    public function getCicloactual()
    {
        return $this->cicloactual;
    }

    /**
     * Set cicloanterior
     *
     * @param integer $cicloanterior
     *
     * @return AdHistoricosolicitues
     */
    public function setCicloanterior($cicloanterior)
    {
        $this->cicloanterior = $cicloanterior;

        return $this;
    }

    /**
     * Get cicloanterior
     *
     * @return integer
     */
    public function getCicloanterior()
    {
        return $this->cicloanterior;
    }

    /**
     * Set pagadabinanterior
     *
     * @param integer $pagadabinanterior
     *
     * @return AdHistoricosolicitues
     */
    public function setPagadabinanterior($pagadabinanterior)
    {
        $this->pagadabinanterior = $pagadabinanterior;

        return $this;
    }

    /**
     * Get pagadabinanterior
     *
     * @return integer
     */
    public function getPagadabinanterior()
    {
        return $this->pagadabinanterior;
    }

    /**
     * Set fechacaptura
     *
     * @param \DateTime $fechacaptura
     *
     * @return AdHistoricosolicitues
     */
    public function setFechacaptura($fechacaptura)
    {
        $this->fechacaptura = $fechacaptura;

        return $this;
    }

    /**
     * Get fechacaptura
     *
     * @return \DateTime
     */
    public function getFechacaptura()
    {
        return $this->fechacaptura;
    }

    /**
     * Set inscriotobin
     *
     * @param integer $inscriotobin
     *
     * @return AdHistoricosolicitues
     */
    public function setInscriotobin($inscriotobin)
    {
        $this->inscriotobin = $inscriotobin;

        return $this;
    }

    /**
     * Get inscriotobin
     *
     * @return integer
     */
    public function getInscriotobin()
    {
        return $this->inscriotobin;
    }

    /**
     * Set dictamenbin
     *
     * @param integer $dictamenbin
     *
     * @return AdHistoricosolicitues
     */
    public function setDictamenbin($dictamenbin)
    {
        $this->dictamenbin = $dictamenbin;

        return $this;
    }

    /**
     * Get dictamenbin
     *
     * @return integer
     */
    public function getDictamenbin()
    {
        return $this->dictamenbin;
    }

    /**
     * Set dia
     *
     * @param integer $dia
     *
     * @return AdHistoricosolicitues
     */
    public function setDia($dia)
    {
        $this->dia = $dia;

        return $this;
    }

    /**
     * Get dia
     *
     * @return integer
     */
    public function getDia()
    {
        return $this->dia;
    }

    /**
     * Set diavalidacion
     *
     * @param integer $diavalidacion
     *
     * @return AdHistoricosolicitues
     */
    public function setDiavalidacion($diavalidacion)
    {
        $this->diavalidacion = $diavalidacion;

        return $this;
    }

    /**
     * Get diavalidacion
     *
     * @return integer
     */
    public function getDiavalidacion()
    {
        return $this->diavalidacion;
    }

    /**
     * Get historicosolicitudesid
     *
     * @return integer
     */
    public function getHistoricosolicitudesid()
    {
        return $this->historicosolicitudesid;
    }
}

