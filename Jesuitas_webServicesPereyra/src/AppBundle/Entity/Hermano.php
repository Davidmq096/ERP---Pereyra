<?php

namespace AppBundle\Entity;

/**
 * Hermano
 */
class Hermano
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
     * @var integer
     */
    private $edad;

    /**
     * @var \DateTime
     */
    private $fechanacimiento;

    /**
     * @var string
     */
    private $curp;

    /**
     * @var string
     */
    private $nombreescuela;

    /**
     * @var string
     */
    private $generacion;

    /**
     * @var integer
     */
    private $tipohermano;

    /**
     * @var integer
     */
    private $hermanoid;

    /**
     * @var \AppBundle\Entity\Datoaspirante
     */
    private $datosaspiranteid;

    /**
     * @var \AppBundle\Entity\Grado
     */
    private $gradoid;

    /**
     * @var \AppBundle\Entity\Generacion
     */
    private $generacionid;


    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return Hermano
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
     * @return Hermano
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
     * @return Hermano
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
     * Set edad
     *
     * @param integer $edad
     *
     * @return Hermano
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
     * Set fechanacimiento
     *
     * @param \DateTime $fechanacimiento
     *
     * @return Hermano
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
     * Set curp
     *
     * @param string $curp
     *
     * @return Hermano
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
     * Set nombreescuela
     *
     * @param string $nombreescuela
     *
     * @return Hermano
     */
    public function setNombreescuela($nombreescuela)
    {
        $this->nombreescuela = $nombreescuela;

        return $this;
    }

    /**
     * Get nombreescuela
     *
     * @return string
     */
    public function getNombreescuela()
    {
        return $this->nombreescuela;
    }

    /**
     * Set generacion
     *
     * @param string $generacion
     *
     * @return Hermano
     */
    public function setGeneracion($generacion)
    {
        $this->generacion = $generacion;

        return $this;
    }

    /**
     * Get generacion
     *
     * @return string
     */
    public function getGeneracion()
    {
        return $this->generacion;
    }

    /**
     * Set tipohermano
     *
     * @param integer $tipohermano
     *
     * @return Hermano
     */
    public function setTipohermano($tipohermano)
    {
        $this->tipohermano = $tipohermano;

        return $this;
    }

    /**
     * Get tipohermano
     *
     * @return integer
     */
    public function getTipohermano()
    {
        return $this->tipohermano;
    }

    /**
     * Get hermanoid
     *
     * @return integer
     */
    public function getHermanoid()
    {
        return $this->hermanoid;
    }

    /**
     * Set datosaspiranteid
     *
     * @param \AppBundle\Entity\Datoaspirante $datosaspiranteid
     *
     * @return Hermano
     */
    public function setDatosaspiranteid(\AppBundle\Entity\Datoaspirante $datosaspiranteid = null)
    {
        $this->datosaspiranteid = $datosaspiranteid;

        return $this;
    }

    /**
     * Get datosaspiranteid
     *
     * @return \AppBundle\Entity\Datoaspirante
     */
    public function getDatosaspiranteid()
    {
        return $this->datosaspiranteid;
    }

    /**
     * Set gradoid
     *
     * @param \AppBundle\Entity\Grado $gradoid
     *
     * @return Hermano
     */
    public function setGradoid(\AppBundle\Entity\Grado $gradoid = null)
    {
        $this->gradoid = $gradoid;

        return $this;
    }

    /**
     * Get gradoid
     *
     * @return \AppBundle\Entity\Grado
     */
    public function getGradoid()
    {
        return $this->gradoid;
    }

    /**
     * Set generacionid
     *
     * @param \AppBundle\Entity\Generacion $generacionid
     *
     * @return Hermano
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
}

