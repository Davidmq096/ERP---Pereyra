<?php

namespace AppBundle\Entity;

/**
 * TpBoletobitacora
 */
class TpBoletobitacora
{
    /**
     * @var integer
     */
    private $boletoid;

    /**
     * @var \DateTime
     */
    private $fechaviaje;

    /**
     * @var \DateTime
     */
    private $fechacompra;

    /**
     * @var \DateTime
     */
    private $fechaedicion;

    /**
     * @var string
     */
    private $medioedicion;

    /**
     * @var string
     */
    private $usuarioedicion;

    /**
     * @var \DateTime
     */
    private $fechacancelacion;

    /**
     * @var string
     */
    private $mediocancelacion;

    /**
     * @var string
     */
    private $usuariocancelacion;

    /**
     * @var float
     */
    private $precio;

    /**
     * @var string
     */
    private $usuario;

    /**
     * @var string
     */
    private $portal;

    /**
     * @var boolean
     */
    private $escaneado;

    /**
     * @var integer
     */
    private $boletobitacoraid;

    /**
     * @var \AppBundle\Entity\CeAlumno
     */
    private $alumnoid;

    /**
     * @var \AppBundle\Entity\TpBoletoestatus
     */
    private $boletoestatusid;

    /**
     * @var \AppBundle\Entity\TpRutaprecioparada
     */
    private $paradaid;

    /**
     * @var \AppBundle\Entity\TpRuta
     */
    private $rutaid;


    /**
     * Set boletoid
     *
     * @param integer $boletoid
     *
     * @return TpBoletobitacora
     */
    public function setBoletoid($boletoid)
    {
        $this->boletoid = $boletoid;

        return $this;
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
     * Set fechaviaje
     *
     * @param \DateTime $fechaviaje
     *
     * @return TpBoletobitacora
     */
    public function setFechaviaje($fechaviaje)
    {
        $this->fechaviaje = $fechaviaje;

        return $this;
    }

    /**
     * Get fechaviaje
     *
     * @return \DateTime
     */
    public function getFechaviaje()
    {
        return $this->fechaviaje;
    }

    /**
     * Set fechacompra
     *
     * @param \DateTime $fechacompra
     *
     * @return TpBoletobitacora
     */
    public function setFechacompra($fechacompra)
    {
        $this->fechacompra = $fechacompra;

        return $this;
    }

    /**
     * Get fechacompra
     *
     * @return \DateTime
     */
    public function getFechacompra()
    {
        return $this->fechacompra;
    }

    /**
     * Set fechaedicion
     *
     * @param \DateTime $fechaedicion
     *
     * @return TpBoletobitacora
     */
    public function setFechaedicion($fechaedicion)
    {
        $this->fechaedicion = $fechaedicion;

        return $this;
    }

    /**
     * Get fechaedicion
     *
     * @return \DateTime
     */
    public function getFechaedicion()
    {
        return $this->fechaedicion;
    }

    /**
     * Set medioedicion
     *
     * @param string $medioedicion
     *
     * @return TpBoletobitacora
     */
    public function setMedioedicion($medioedicion)
    {
        $this->medioedicion = $medioedicion;

        return $this;
    }

    /**
     * Get medioedicion
     *
     * @return string
     */
    public function getMedioedicion()
    {
        return $this->medioedicion;
    }

    /**
     * Set usuarioedicion
     *
     * @param string $usuarioedicion
     *
     * @return TpBoletobitacora
     */
    public function setUsuarioedicion($usuarioedicion)
    {
        $this->usuarioedicion = $usuarioedicion;

        return $this;
    }

    /**
     * Get usuarioedicion
     *
     * @return string
     */
    public function getUsuarioedicion()
    {
        return $this->usuarioedicion;
    }

    /**
     * Set fechacancelacion
     *
     * @param \DateTime $fechacancelacion
     *
     * @return TpBoletobitacora
     */
    public function setFechacancelacion($fechacancelacion)
    {
        $this->fechacancelacion = $fechacancelacion;

        return $this;
    }

    /**
     * Get fechacancelacion
     *
     * @return \DateTime
     */
    public function getFechacancelacion()
    {
        return $this->fechacancelacion;
    }

    /**
     * Set mediocancelacion
     *
     * @param string $mediocancelacion
     *
     * @return TpBoletobitacora
     */
    public function setMediocancelacion($mediocancelacion)
    {
        $this->mediocancelacion = $mediocancelacion;

        return $this;
    }

    /**
     * Get mediocancelacion
     *
     * @return string
     */
    public function getMediocancelacion()
    {
        return $this->mediocancelacion;
    }

    /**
     * Set usuariocancelacion
     *
     * @param string $usuariocancelacion
     *
     * @return TpBoletobitacora
     */
    public function setUsuariocancelacion($usuariocancelacion)
    {
        $this->usuariocancelacion = $usuariocancelacion;

        return $this;
    }

    /**
     * Get usuariocancelacion
     *
     * @return string
     */
    public function getUsuariocancelacion()
    {
        return $this->usuariocancelacion;
    }

    /**
     * Set precio
     *
     * @param float $precio
     *
     * @return TpBoletobitacora
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
     * Set usuario
     *
     * @param string $usuario
     *
     * @return TpBoletobitacora
     */
    public function setUsuario($usuario)
    {
        $this->usuario = $usuario;

        return $this;
    }

    /**
     * Get usuario
     *
     * @return string
     */
    public function getUsuario()
    {
        return $this->usuario;
    }

    /**
     * Set portal
     *
     * @param string $portal
     *
     * @return TpBoletobitacora
     */
    public function setPortal($portal)
    {
        $this->portal = $portal;

        return $this;
    }

    /**
     * Get portal
     *
     * @return string
     */
    public function getPortal()
    {
        return $this->portal;
    }

    /**
     * Set escaneado
     *
     * @param boolean $escaneado
     *
     * @return TpBoletobitacora
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
     * Get boletobitacoraid
     *
     * @return integer
     */
    public function getBoletobitacoraid()
    {
        return $this->boletobitacoraid;
    }

    /**
     * Set alumnoid
     *
     * @param \AppBundle\Entity\CeAlumno $alumnoid
     *
     * @return TpBoletobitacora
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
     * Set boletoestatusid
     *
     * @param \AppBundle\Entity\TpBoletoestatus $boletoestatusid
     *
     * @return TpBoletobitacora
     */
    public function setBoletoestatusid(\AppBundle\Entity\TpBoletoestatus $boletoestatusid = null)
    {
        $this->boletoestatusid = $boletoestatusid;

        return $this;
    }

    /**
     * Get boletoestatusid
     *
     * @return \AppBundle\Entity\TpBoletoestatus
     */
    public function getBoletoestatusid()
    {
        return $this->boletoestatusid;
    }

    /**
     * Set paradaid
     *
     * @param \AppBundle\Entity\TpRutaprecioparada $paradaid
     *
     * @return TpBoletobitacora
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

    /**
     * Set rutaid
     *
     * @param \AppBundle\Entity\TpRuta $rutaid
     *
     * @return TpBoletobitacora
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
}

