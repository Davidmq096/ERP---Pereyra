<?php

namespace AppBundle\Entity;

/**
 * CbSeguimiento
 */
class CbSeguimiento
{
    /**
     * @var \DateTime
     */
    private $fecha;

    /**
     * @var \DateTime
     */
    private $hora;

    /**
     * @var string
     */
    private $personaatiende;

    /**
     * @var string
     */
    private $observaciones;

    /**
     * @var string
     */
    private $observacionmanual;

    /**
     * @var boolean
     */
    private $asistio = '0';

    /**
     * @var integer
     */
    private $seguimientoid;

    /**
     * @var \AppBundle\Entity\CbAcuerdo
     */
    private $acuerdoid;

    /**
     * @var \AppBundle\Entity\CeClavefamiliar
     */
    private $clavefamiliarid;

    /**
     * @var \AppBundle\Entity\CbMediocontacto
     */
    private $mediocontactoid;

    /**
     * @var \AppBundle\Entity\Usuario
     */
    private $usuarioid;


    /**
     * Set fecha
     *
     * @param \DateTime $fecha
     *
     * @return CbSeguimiento
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
     * Set hora
     *
     * @param \DateTime $hora
     *
     * @return CbSeguimiento
     */
    public function setHora($hora)
    {
        $this->hora = $hora;

        return $this;
    }

    /**
     * Get hora
     *
     * @return \DateTime
     */
    public function getHora()
    {
        return $this->hora;
    }

    /**
     * Set personaatiende
     *
     * @param string $personaatiende
     *
     * @return CbSeguimiento
     */
    public function setPersonaatiende($personaatiende)
    {
        $this->personaatiende = $personaatiende;

        return $this;
    }

    /**
     * Get personaatiende
     *
     * @return string
     */
    public function getPersonaatiende()
    {
        return $this->personaatiende;
    }

    /**
     * Set observaciones
     *
     * @param string $observaciones
     *
     * @return CbSeguimiento
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
     * Set observacionmanual
     *
     * @param string $observacionmanual
     *
     * @return CbSeguimiento
     */
    public function setObservacionmanual($observacionmanual)
    {
        $this->observacionmanual = $observacionmanual;

        return $this;
    }

    /**
     * Get observacionmanual
     *
     * @return string
     */
    public function getObservacionmanual()
    {
        return $this->observacionmanual;
    }

    /**
     * Set asistio
     *
     * @param boolean $asistio
     *
     * @return CbSeguimiento
     */
    public function setAsistio($asistio)
    {
        $this->asistio = $asistio;

        return $this;
    }

    /**
     * Get asistio
     *
     * @return boolean
     */
    public function getAsistio()
    {
        return $this->asistio;
    }

    /**
     * Get seguimientoid
     *
     * @return integer
     */
    public function getSeguimientoid()
    {
        return $this->seguimientoid;
    }

    /**
     * Set acuerdoid
     *
     * @param \AppBundle\Entity\CbAcuerdo $acuerdoid
     *
     * @return CbSeguimiento
     */
    public function setAcuerdoid(\AppBundle\Entity\CbAcuerdo $acuerdoid = null)
    {
        $this->acuerdoid = $acuerdoid;

        return $this;
    }

    /**
     * Get acuerdoid
     *
     * @return \AppBundle\Entity\CbAcuerdo
     */
    public function getAcuerdoid()
    {
        return $this->acuerdoid;
    }

    /**
     * Set clavefamiliarid
     *
     * @param \AppBundle\Entity\CeClavefamiliar $clavefamiliarid
     *
     * @return CbSeguimiento
     */
    public function setClavefamiliarid(\AppBundle\Entity\CeClavefamiliar $clavefamiliarid = null)
    {
        $this->clavefamiliarid = $clavefamiliarid;

        return $this;
    }

    /**
     * Get clavefamiliarid
     *
     * @return \AppBundle\Entity\CeClavefamiliar
     */
    public function getClavefamiliarid()
    {
        return $this->clavefamiliarid;
    }

    /**
     * Set mediocontactoid
     *
     * @param \AppBundle\Entity\CbMediocontacto $mediocontactoid
     *
     * @return CbSeguimiento
     */
    public function setMediocontactoid(\AppBundle\Entity\CbMediocontacto $mediocontactoid = null)
    {
        $this->mediocontactoid = $mediocontactoid;

        return $this;
    }

    /**
     * Get mediocontactoid
     *
     * @return \AppBundle\Entity\CbMediocontacto
     */
    public function getMediocontactoid()
    {
        return $this->mediocontactoid;
    }

    /**
     * Set usuarioid
     *
     * @param \AppBundle\Entity\Usuario $usuarioid
     *
     * @return CbSeguimiento
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

