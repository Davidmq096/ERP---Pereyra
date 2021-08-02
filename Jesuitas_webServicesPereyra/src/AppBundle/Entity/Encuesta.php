<?php

namespace AppBundle\Entity;

/**
 * Encuesta
 */
class Encuesta
{
    /**
     * @var string
     */
    private $nombre;

    /**
     * @var string
     */
    private $parentesco;

    /**
     * @var string
     */
    private $eleccion;

    /**
     * @var string
     */
    private $correo;

    /**
     * @var string
     */
    private $sexo;

    /**
     * @var integer
     */
    private $edad;

    /**
     * @var string
     */
    private $colonia;

    /**
     * @var string
     */
    private $otromedio;

    /**
     * @var integer
     */
    private $encuestaid;


    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return Encuesta
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
     * Set parentesco
     *
     * @param string $parentesco
     *
     * @return Encuesta
     */
    public function setParentesco($parentesco)
    {
        $this->parentesco = $parentesco;

        return $this;
    }

    /**
     * Get parentesco
     *
     * @return string
     */
    public function getParentesco()
    {
        return $this->parentesco;
    }

    /**
     * Set eleccion
     *
     * @param string $eleccion
     *
     * @return Encuesta
     */
    public function setEleccion($eleccion)
    {
        $this->eleccion = $eleccion;

        return $this;
    }

    /**
     * Get eleccion
     *
     * @return string
     */
    public function getEleccion()
    {
        return $this->eleccion;
    }

    /**
     * Set correo
     *
     * @param string $correo
     *
     * @return Encuesta
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
     * Set sexo
     *
     * @param string $sexo
     *
     * @return Encuesta
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
     * Set edad
     *
     * @param integer $edad
     *
     * @return Encuesta
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
     * Set colonia
     *
     * @param string $colonia
     *
     * @return Encuesta
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
     * Set otromedio
     *
     * @param string $otromedio
     *
     * @return Encuesta
     */
    public function setOtromedio($otromedio)
    {
        $this->otromedio = $otromedio;

        return $this;
    }

    /**
     * Get otromedio
     *
     * @return string
     */
    public function getOtromedio()
    {
        return $this->otromedio;
    }

    /**
     * Get encuestaid
     *
     * @return integer
     */
    public function getEncuestaid()
    {
        return $this->encuestaid;
    }
}

