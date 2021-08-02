<?php

namespace AppBundle\Entity;

/**
 * CeHermano
 */
class CeHermano
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
     * @var integer
     */
    private $tipohermano;

    /**
     * @var integer
     */
    private $hermanoid;

    /**
     * @var \AppBundle\Entity\CeAlumno
     */
    private $alumnoid;

    /**
     * @var \AppBundle\Entity\Generacion
     */
    private $generacionid;

    /**
     * @var \AppBundle\Entity\Grado
     */
    private $gradoid;


    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return CeHermano
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
     * @return CeHermano
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
     * @return CeHermano
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
     * @return CeHermano
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
     * @return CeHermano
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
     * @return CeHermano
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
     * @return CeHermano
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
     * Set tipohermano
     *
     * @param integer $tipohermano
     *
     * @return CeHermano
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
     * Set alumnoid
     *
     * @param \AppBundle\Entity\CeAlumno $alumnoid
     *
     * @return CeHermano
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
     * Set generacionid
     *
     * @param \AppBundle\Entity\Generacion $generacionid
     *
     * @return CeHermano
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
     * Set gradoid
     *
     * @param \AppBundle\Entity\Grado $gradoid
     *
     * @return CeHermano
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
}

