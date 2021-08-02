<?php

namespace AppBundle\Entity;

/**
 * BrUsuarioexterno
 */
class BrUsuarioexterno
{
    /**
     * @var string
     */
    private $usuario;

    /**
     * @var string
     */
    private $contrasena;

    /**
     * @var string
     */
    private $grupo;

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
     * @var boolean
     */
    private $activo;

    /**
     * @var integer
     */
    private $usuarioexternoid;

    /**
     * @var \AppBundle\Entity\BrColegio
     */
    private $colegioid;

    /**
     * @var \AppBundle\Entity\Solicitudadmision
     */
    private $solicitudadmisionid;

    /**
     * @var \AppBundle\Entity\BrTipousuarioexterno
     */
    private $tipousuarioexternoid;


    /**
     * Set usuario
     *
     * @param string $usuario
     *
     * @return BrUsuarioexterno
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
     * Set contrasena
     *
     * @param string $contrasena
     *
     * @return BrUsuarioexterno
     */
    public function setContrasena($contrasena)
    {
        $this->contrasena = $contrasena;

        return $this;
    }

    /**
     * Get contrasena
     *
     * @return string
     */
    public function getContrasena()
    {
        return $this->contrasena;
    }

    /**
     * Set grupo
     *
     * @param string $grupo
     *
     * @return BrUsuarioexterno
     */
    public function setGrupo($grupo)
    {
        $this->grupo = $grupo;

        return $this;
    }

    /**
     * Get grupo
     *
     * @return string
     */
    public function getGrupo()
    {
        return $this->grupo;
    }

    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return BrUsuarioexterno
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
     * @return BrUsuarioexterno
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
     * @return BrUsuarioexterno
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
     * Set activo
     *
     * @param boolean $activo
     *
     * @return BrUsuarioexterno
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
     * Get usuarioexternoid
     *
     * @return integer
     */
    public function getUsuarioexternoid()
    {
        return $this->usuarioexternoid;
    }

    /**
     * Set colegioid
     *
     * @param \AppBundle\Entity\BrColegio $colegioid
     *
     * @return BrUsuarioexterno
     */
    public function setColegioid(\AppBundle\Entity\BrColegio $colegioid = null)
    {
        $this->colegioid = $colegioid;

        return $this;
    }

    /**
     * Get colegioid
     *
     * @return \AppBundle\Entity\BrColegio
     */
    public function getColegioid()
    {
        return $this->colegioid;
    }

    /**
     * Set solicitudadmisionid
     *
     * @param \AppBundle\Entity\Solicitudadmision $solicitudadmisionid
     *
     * @return BrUsuarioexterno
     */
    public function setSolicitudadmisionid(\AppBundle\Entity\Solicitudadmision $solicitudadmisionid = null)
    {
        $this->solicitudadmisionid = $solicitudadmisionid;

        return $this;
    }

    /**
     * Get solicitudadmisionid
     *
     * @return \AppBundle\Entity\Solicitudadmision
     */
    public function getSolicitudadmisionid()
    {
        return $this->solicitudadmisionid;
    }

    /**
     * Set tipousuarioexternoid
     *
     * @param \AppBundle\Entity\BrTipousuarioexterno $tipousuarioexternoid
     *
     * @return BrUsuarioexterno
     */
    public function setTipousuarioexternoid(\AppBundle\Entity\BrTipousuarioexterno $tipousuarioexternoid = null)
    {
        $this->tipousuarioexternoid = $tipousuarioexternoid;

        return $this;
    }

    /**
     * Get tipousuarioexternoid
     *
     * @return \AppBundle\Entity\BrTipousuarioexterno
     */
    public function getTipousuarioexternoid()
    {
        return $this->tipousuarioexternoid;
    }
}

