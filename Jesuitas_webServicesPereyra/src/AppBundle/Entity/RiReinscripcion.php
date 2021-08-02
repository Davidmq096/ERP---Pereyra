<?php

namespace AppBundle\Entity;

/**
 * RiReinscripcion
 */
class RiReinscripcion
{
    /**
     * @var string
     */
    private $telefono;

    /**
     * @var string
     */
    private $correo;

    /**
     * @var boolean
     */
    private $tramitobeca;

    /**
     * @var string
     */
    private $observaciones;

    /**
     * @var boolean
     */
    private $renunciafo;

    /**
     * @var boolean
     */
    private $pagocolegiaturas;

    /**
     * @var boolean
     */
    private $hijopersonal;

    /**
     * @var string
     */
    private $nonomina;

    /**
     * @var boolean
     */
    private $documentacionoriginal;

    /**
     * @var \DateTime
     */
    private $fecha;

    /**
     * @var integer
     */
    private $reinscripcionid;

    /**
     * @var \AppBundle\Entity\CeAlumno
     */
    private $alumnoid;

    /**
     * @var \AppBundle\Entity\Ciclo
     */
    private $cicloid;

    /**
     * @var \AppBundle\Entity\RiFormapagocolegiaturaanticipada
     */
    private $formapagocolegiaturaanticipadaid;

    /**
     * @var \AppBundle\Entity\RiFormapagocolegiatura
     */
    private $formapagocolegiaturaid;

    /**
     * @var \AppBundle\Entity\RiFormapagoinscripcionyfo
     */
    private $formapagoinscripcionyfoid;

    /**
     * @var \AppBundle\Entity\RiReinscripcionestatus
     */
    private $reinscripcionestatusid;

    /**
     * @var \AppBundle\Entity\RiTipopagocolegiatura
     */
    private $tipopagocolegiaturaid;


    /**
     * Set telefono
     *
     * @param string $telefono
     *
     * @return RiReinscripcion
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
     * Set correo
     *
     * @param string $correo
     *
     * @return RiReinscripcion
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
     * Set tramitobeca
     *
     * @param boolean $tramitobeca
     *
     * @return RiReinscripcion
     */
    public function setTramitobeca($tramitobeca)
    {
        $this->tramitobeca = $tramitobeca;

        return $this;
    }

    /**
     * Get tramitobeca
     *
     * @return boolean
     */
    public function getTramitobeca()
    {
        return $this->tramitobeca;
    }

    /**
     * Set observaciones
     *
     * @param string $observaciones
     *
     * @return RiReinscripcion
     */
    public function setObservaciones($observaciones)
    {
        $this->observaciones = $observaciones;

        return $this;
    }

    /**
     * Get observaciones
     *
     * @return string
     */
    public function getObservaciones()
    {
        return $this->observaciones;
    }

    /**
     * Set renunciafo
     *
     * @param boolean $renunciafo
     *
     * @return RiReinscripcion
     */
    public function setRenunciafo($renunciafo)
    {
        $this->renunciafo = $renunciafo;

        return $this;
    }

    /**
     * Get renunciafo
     *
     * @return boolean
     */
    public function getRenunciafo()
    {
        return $this->renunciafo;
    }

    /**
     * Set pagocolegiaturas
     *
     * @param boolean $pagocolegiaturas
     *
     * @return RiReinscripcion
     */
    public function setPagocolegiaturas($pagocolegiaturas)
    {
        $this->pagocolegiaturas = $pagocolegiaturas;

        return $this;
    }

    /**
     * Get pagocolegiaturas
     *
     * @return boolean
     */
    public function getPagocolegiaturas()
    {
        return $this->pagocolegiaturas;
    }

    /**
     * Set hijopersonal
     *
     * @param boolean $hijopersonal
     *
     * @return RiReinscripcion
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
     * Set nonomina
     *
     * @param string $nonomina
     *
     * @return RiReinscripcion
     */
    public function setNonomina($nonomina)
    {
        $this->nonomina = $nonomina;

        return $this;
    }

    /**
     * Get nonomina
     *
     * @return string
     */
    public function getNonomina()
    {
        return $this->nonomina;
    }

    /**
     * Set documentacionoriginal
     *
     * @param boolean $documentacionoriginal
     *
     * @return RiReinscripcion
     */
    public function setDocumentacionoriginal($documentacionoriginal)
    {
        $this->documentacionoriginal = $documentacionoriginal;

        return $this;
    }

    /**
     * Get documentacionoriginal
     *
     * @return boolean
     */
    public function getDocumentacionoriginal()
    {
        return $this->documentacionoriginal;
    }

    /**
     * Set fecha
     *
     * @param \DateTime $fecha
     *
     * @return RiReinscripcion
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
     * Get reinscripcionid
     *
     * @return integer
     */
    public function getReinscripcionid()
    {
        return $this->reinscripcionid;
    }

    /**
     * Set alumnoid
     *
     * @param \AppBundle\Entity\CeAlumno $alumnoid
     *
     * @return RiReinscripcion
     */
    public function setAlumnoid(\AppBundle\Entity\CeAlumno $alumnoid = null)
    {
        $this->alumnoid = $alumnoid;

        return $this;
    }

    /**
     * Get alumnoid
     *
     * @return \AppBundle\Entity\CeAlumno
     */
    public function getAlumnoid()
    {
        return $this->alumnoid;
    }

    /**
     * Set cicloid
     *
     * @param \AppBundle\Entity\Ciclo $cicloid
     *
     * @return RiReinscripcion
     */
    public function setCicloid(\AppBundle\Entity\Ciclo $cicloid = null)
    {
        $this->cicloid = $cicloid;

        return $this;
    }

    /**
     * Get cicloid
     *
     * @return \AppBundle\Entity\Ciclo
     */
    public function getCicloid()
    {
        return $this->cicloid;
    }

    /**
     * Set formapagocolegiaturaanticipadaid
     *
     * @param \AppBundle\Entity\RiFormapagocolegiaturaanticipada $formapagocolegiaturaanticipadaid
     *
     * @return RiReinscripcion
     */
    public function setFormapagocolegiaturaanticipadaid(\AppBundle\Entity\RiFormapagocolegiaturaanticipada $formapagocolegiaturaanticipadaid = null)
    {
        $this->formapagocolegiaturaanticipadaid = $formapagocolegiaturaanticipadaid;

        return $this;
    }

    /**
     * Get formapagocolegiaturaanticipadaid
     *
     * @return \AppBundle\Entity\RiFormapagocolegiaturaanticipada
     */
    public function getFormapagocolegiaturaanticipadaid()
    {
        return $this->formapagocolegiaturaanticipadaid;
    }

    /**
     * Set formapagocolegiaturaid
     *
     * @param \AppBundle\Entity\RiFormapagocolegiatura $formapagocolegiaturaid
     *
     * @return RiReinscripcion
     */
    public function setFormapagocolegiaturaid(\AppBundle\Entity\RiFormapagocolegiatura $formapagocolegiaturaid = null)
    {
        $this->formapagocolegiaturaid = $formapagocolegiaturaid;

        return $this;
    }

    /**
     * Get formapagocolegiaturaid
     *
     * @return \AppBundle\Entity\RiFormapagocolegiatura
     */
    public function getFormapagocolegiaturaid()
    {
        return $this->formapagocolegiaturaid;
    }

    /**
     * Set formapagoinscripcionyfoid
     *
     * @param \AppBundle\Entity\RiFormapagoinscripcionyfo $formapagoinscripcionyfoid
     *
     * @return RiReinscripcion
     */
    public function setFormapagoinscripcionyfoid(\AppBundle\Entity\RiFormapagoinscripcionyfo $formapagoinscripcionyfoid = null)
    {
        $this->formapagoinscripcionyfoid = $formapagoinscripcionyfoid;

        return $this;
    }

    /**
     * Get formapagoinscripcionyfoid
     *
     * @return \AppBundle\Entity\RiFormapagoinscripcionyfo
     */
    public function getFormapagoinscripcionyfoid()
    {
        return $this->formapagoinscripcionyfoid;
    }

    /**
     * Set reinscripcionestatusid
     *
     * @param \AppBundle\Entity\RiReinscripcionestatus $reinscripcionestatusid
     *
     * @return RiReinscripcion
     */
    public function setReinscripcionestatusid(\AppBundle\Entity\RiReinscripcionestatus $reinscripcionestatusid = null)
    {
        $this->reinscripcionestatusid = $reinscripcionestatusid;

        return $this;
    }

    /**
     * Get reinscripcionestatusid
     *
     * @return \AppBundle\Entity\RiReinscripcionestatus
     */
    public function getReinscripcionestatusid()
    {
        return $this->reinscripcionestatusid;
    }

    /**
     * Set tipopagocolegiaturaid
     *
     * @param \AppBundle\Entity\RiTipopagocolegiatura $tipopagocolegiaturaid
     *
     * @return RiReinscripcion
     */
    public function setTipopagocolegiaturaid(\AppBundle\Entity\RiTipopagocolegiatura $tipopagocolegiaturaid = null)
    {
        $this->tipopagocolegiaturaid = $tipopagocolegiaturaid;

        return $this;
    }

    /**
     * Get tipopagocolegiaturaid
     *
     * @return \AppBundle\Entity\RiTipopagocolegiatura
     */
    public function getTipopagocolegiaturaid()
    {
        return $this->tipopagocolegiaturaid;
    }
}

