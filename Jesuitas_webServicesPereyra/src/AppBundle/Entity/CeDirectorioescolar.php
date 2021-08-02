<?php

namespace AppBundle\Entity;

/**
 * CeDirectorioescolar
 */
class CeDirectorioescolar
{
    /**
     * @var string
     */
    private $nombredepartamento;

    /**
     * @var string
     */
    private $correoelectronico;

    /**
     * @var string
     */
    private $telefono;

    /**
     * @var string
     */
    private $extension;

    /**
     * @var string
     */
    private $nombreresponsable;

    /**
     * @var integer
     */
    private $ordendirectorio;

    /**
     * @var boolean
     */
    private $activo;

    /**
     * @var integer
     */
    private $directorioescolarid;


    /**
     * Set nombredepartamento
     *
     * @param string $nombredepartamento
     *
     * @return CeDirectorioescolar
     */
    public function setNombredepartamento($nombredepartamento)
    {
        $this->nombredepartamento = $nombredepartamento;

        return $this;
    }

    /**
     * Get nombredepartamento
     *
     * @return string
     */
    public function getNombredepartamento()
    {
        return $this->nombredepartamento;
    }

    /**
     * Set correoelectronico
     *
     * @param string $correoelectronico
     *
     * @return CeDirectorioescolar
     */
    public function setCorreoelectronico($correoelectronico)
    {
        $this->correoelectronico = $correoelectronico;

        return $this;
    }

    /**
     * Get correoelectronico
     *
     * @return string
     */
    public function getCorreoelectronico()
    {
        return $this->correoelectronico;
    }

    /**
     * Set telefono
     *
     * @param string $telefono
     *
     * @return CeDirectorioescolar
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
     * Set extension
     *
     * @param string $extension
     *
     * @return CeDirectorioescolar
     */
    public function setExtension($extension)
    {
        $this->extension = $extension;

        return $this;
    }

    /**
     * Get extension
     *
     * @return string
     */
    public function getExtension()
    {
        return $this->extension;
    }

    /**
     * Set nombreresponsable
     *
     * @param string $nombreresponsable
     *
     * @return CeDirectorioescolar
     */
    public function setNombreresponsable($nombreresponsable)
    {
        $this->nombreresponsable = $nombreresponsable;

        return $this;
    }

    /**
     * Get nombreresponsable
     *
     * @return string
     */
    public function getNombreresponsable()
    {
        return $this->nombreresponsable;
    }

    /**
     * Set ordendirectorio
     *
     * @param integer $ordendirectorio
     *
     * @return CeDirectorioescolar
     */
    public function setOrdendirectorio($ordendirectorio)
    {
        $this->ordendirectorio = $ordendirectorio;

        return $this;
    }

    /**
     * Get ordendirectorio
     *
     * @return integer
     */
    public function getOrdendirectorio()
    {
        return $this->ordendirectorio;
    }

    /**
     * Set activo
     *
     * @param boolean $activo
     *
     * @return CeDirectorioescolar
     */
    public function setActivo($activo)
    {
        $this->activo = $activo;

        return $this;
    }

    /**
     * Get activo
     *
     * @return boolean
     */
    public function getActivo()
    {
        return $this->activo;
    }

    /**
     * Get directorioescolarid
     *
     * @return integer
     */
    public function getDirectorioescolarid()
    {
        return $this->directorioescolarid;
    }
}

