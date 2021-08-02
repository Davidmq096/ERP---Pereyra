<?php

namespace AppBundle\Entity;

/**
 * TpBoleto
 */
class TpBoleto
{
    /**
     * @var \DateTime
     */
    private $fecha;

    /**
     * @var \DateTime
     */
    private $fechabitacora;

    /**
     * @var float
     */
    private $precio;

    /**
     * @var boolean
     */
    private $escaneado = '0';

    /**
     * @var integer
     */
    private $boletoid;

    /**
     * @var \AppBundle\Entity\Usuario
     */
    private $usuariocompraid;

    /**
     * @var \AppBundle\Entity\CeAlumno
     */
    private $alumnoid;

    /**
     * @var \AppBundle\Entity\CjDocumentoporpagar
     */
    private $documentoporpagarid;

    /**
     * @var \AppBundle\Entity\TpRuta
     */
    private $rutaid;

    /**
     * @var \AppBundle\Entity\TpRutaprecioparada
     */
    private $paradaid;


    /**
     * Set fecha
     *
     * @param \DateTime $fecha
     *
     * @return TpBoleto
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
     * Set fechabitacora
     *
     * @param \DateTime $fechabitacora
     *
     * @return TpBoleto
     */
    public function setFechabitacora($fechabitacora)
    {
        $this->fechabitacora = $fechabitacora;

        return $this;
    }

    /**
     * Get fechabitacora
     *
     * @return \DateTime
     */
    public function getFechabitacora()
    {
        return $this->fechabitacora;
    }

    /**
     * Set precio
     *
     * @param float $precio
     *
     * @return TpBoleto
     */
    public function setPrecio($precio)
    {
        $this->precio = $precio;

        return $this;
    }

    /**
     * Get precio
     *
     * @return float
     */
    public function getPrecio()
    {
        return $this->precio;
    }

    /**
     * Set escaneado
     *
     * @param boolean $escaneado
     *
     * @return TpBoleto
     */
    public function setEscaneado($escaneado)
    {
        $this->escaneado = $escaneado;

        return $this;
    }

    /**
     * Get escaneado
     *
     * @return boolean
     */
    public function getEscaneado()
    {
        return $this->escaneado;
    }

    /**
     * Get boletoid
     *
     * @return integer
     */
    public function getBoletoid()
    {
        return $this->boletoid;
    }

    /**
     * Set usuariocompraid
     *
     * @param \AppBundle\Entity\Usuario $usuariocompraid
     *
     * @return TpBoleto
     */
    public function setUsuariocompraid(\AppBundle\Entity\Usuario $usuariocompraid = null)
    {
        $this->usuariocompraid = $usuariocompraid;

        return $this;
    }

    /**
     * Get usuariocompraid
     *
     * @return \AppBundle\Entity\Usuario
     */
    public function getUsuariocompraid()
    {
        return $this->usuariocompraid;
    }

    /**
     * Set alumnoid
     *
     * @param \AppBundle\Entity\CeAlumno $alumnoid
     *
     * @return TpBoleto
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
     * Set documentoporpagarid
     *
     * @param \AppBundle\Entity\CjDocumentoporpagar $documentoporpagarid
     *
     * @return TpBoleto
     */
    public function setDocumentoporpagarid(\AppBundle\Entity\CjDocumentoporpagar $documentoporpagarid = null)
    {
        $this->documentoporpagarid = $documentoporpagarid;

        return $this;
    }

    /**
     * Get documentoporpagarid
     *
     * @return \AppBundle\Entity\CjDocumentoporpagar
     */
    public function getDocumentoporpagarid()
    {
        return $this->documentoporpagarid;
    }

    /**
     * Set rutaid
     *
     * @param \AppBundle\Entity\TpRuta $rutaid
     *
     * @return TpBoleto
     */
    public function setRutaid(\AppBundle\Entity\TpRuta $rutaid = null)
    {
        $this->rutaid = $rutaid;

        return $this;
    }

    /**
     * Get rutaid
     *
     * @return \AppBundle\Entity\TpRuta
     */
    public function getRutaid()
    {
        return $this->rutaid;
    }

    /**
     * Set paradaid
     *
     * @param \AppBundle\Entity\TpRutaprecioparada $paradaid
     *
     * @return TpBoleto
     */
    public function setParadaid(\AppBundle\Entity\TpRutaprecioparada $paradaid = null)
    {
        $this->paradaid = $paradaid;

        return $this;
    }

    /**
     * Get paradaid
     *
     * @return \AppBundle\Entity\TpRutaprecioparada
     */
    public function getParadaid()
    {
        return $this->paradaid;
    }
}

