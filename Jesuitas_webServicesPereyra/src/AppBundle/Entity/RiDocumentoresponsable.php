<?php

namespace AppBundle\Entity;

/**
 * RiDocumentoresponsable
 */
class RiDocumentoresponsable
{
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
    private $cp;

    /**
     * @var string
     */
    private $colonia;

    /**
     * @var string
     */
    private $calle;

    /**
     * @var string
     */
    private $numeroext;

    /**
     * @var string
     */
    private $numeroint;

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
    private $ocupacion;

    /**
     * @var integer
     */
    private $edad;

    /**
     * @var integer
     */
    private $responsablecontratoid;

    /**
     * @var \AppBundle\Entity\RiReinscripcion
     */
    private $reinscripcionid;

    /**
     * @var \AppBundle\Entity\RiDocumento
     */
    private $documentoid;

    /**
     * @var \AppBundle\Entity\Estado
     */
    private $estadoid;

    /**
     * @var \AppBundle\Entity\Municipio
     */
    private $municipioid;

    /**
     * @var \AppBundle\Entity\Tutor
     */
    private $tutorid;


    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return RiDocumentoresponsable
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
     * @return RiDocumentoresponsable
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
     * @return RiDocumentoresponsable
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
     * Set cp
     *
     * @param string $cp
     *
     * @return RiDocumentoresponsable
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
     * Set colonia
     *
     * @param string $colonia
     *
     * @return RiDocumentoresponsable
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
     * Set calle
     *
     * @param string $calle
     *
     * @return RiDocumentoresponsable
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
     * Set numeroext
     *
     * @param string $numeroext
     *
     * @return RiDocumentoresponsable
     */
    public function setNumeroext($numeroext)
    {
        $this->numeroext = $numeroext;

        return $this;
    }

    /**
     * Get numeroext
     *
     * @return string
     */
    public function getNumeroext()
    {
        return $this->numeroext;
    }

    /**
     * Set numeroint
     *
     * @param string $numeroint
     *
     * @return RiDocumentoresponsable
     */
    public function setNumeroint($numeroint)
    {
        $this->numeroint = $numeroint;

        return $this;
    }

    /**
     * Get numeroint
     *
     * @return string
     */
    public function getNumeroint()
    {
        return $this->numeroint;
    }

    /**
     * Set telefono
     *
     * @param string $telefono
     *
     * @return RiDocumentoresponsable
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
     * @return RiDocumentoresponsable
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
     * Set ocupacion
     *
     * @param string $ocupacion
     *
     * @return RiDocumentoresponsable
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
     * Set edad
     *
     * @param integer $edad
     *
     * @return RiDocumentoresponsable
     */
    public function setEdad($edad)
    {
        $this->edad = $edad;

        return $this;
    }

    /**
     * Get edad
     *
     * @return integer
     */
    public function getEdad()
    {
        return $this->edad;
    }

    /**
     * Get responsablecontratoid
     *
     * @return integer
     */
    public function getResponsablecontratoid()
    {
        return $this->responsablecontratoid;
    }

    /**
     * Set reinscripcionid
     *
     * @param \AppBundle\Entity\RiReinscripcion $reinscripcionid
     *
     * @return RiDocumentoresponsable
     */
    public function setReinscripcionid(\AppBundle\Entity\RiReinscripcion $reinscripcionid = null)
    {
        $this->reinscripcionid = $reinscripcionid;

        return $this;
    }

    /**
     * Get reinscripcionid
     *
     * @return \AppBundle\Entity\RiReinscripcion
     */
    public function getReinscripcionid()
    {
        return $this->reinscripcionid;
    }

    /**
     * Set documentoid
     *
     * @param \AppBundle\Entity\RiDocumento $documentoid
     *
     * @return RiDocumentoresponsable
     */
    public function setDocumentoid(\AppBundle\Entity\RiDocumento $documentoid = null)
    {
        $this->documentoid = $documentoid;

        return $this;
    }

    /**
     * Get documentoid
     *
     * @return \AppBundle\Entity\RiDocumento
     */
    public function getDocumentoid()
    {
        return $this->documentoid;
    }

    /**
     * Set estadoid
     *
     * @param \AppBundle\Entity\Estado $estadoid
     *
     * @return RiDocumentoresponsable
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
     * Set municipioid
     *
     * @param \AppBundle\Entity\Municipio $municipioid
     *
     * @return RiDocumentoresponsable
     */
    public function setMunicipioid(\AppBundle\Entity\Municipio $municipioid = null)
    {
        $this->municipioid = $municipioid;

        return $this;
    }

    /**
     * Get municipioid
     *
     * @return \AppBundle\Entity\Municipio
     */
    public function getMunicipioid()
    {
        return $this->municipioid;
    }

    /**
     * Set tutorid
     *
     * @param \AppBundle\Entity\Tutor $tutorid
     *
     * @return RiDocumentoresponsable
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

