<?php

namespace AppBundle\Entity;

/**
 * Usuario
 */
class Usuario
{
    /**
     * @var string
     */
    private $cuenta;

    /**
     * @var string
     */
    private $contrasena;

    /**
     * @var string
     */
    private $id;

    /**
     * @var boolean
     */
    private $reiniciarcontrasena;

    /**
     * @var boolean
     */
    private $activo = '1';

    /**
     * @var integer
     */
    private $usuarioenmascarado;

    /**
     * @var integer
     */
    private $usuarioid;

    /**
     * @var \AppBundle\Entity\Persona
     */
    private $personaid;

    /**
     * @var \AppBundle\Entity\Tipousuario
     */
    private $tipousuarioid;

    /**
     * @var \AppBundle\Entity\CePadresotutores
     */
    private $padreotutorid;

    /**
     * @var \AppBundle\Entity\CeProfesor
     */
    private $profesorid;

    /**
     * @var \AppBundle\Entity\CeAlumno
     */
    private $alumnoid;


    /**
     * Set cuenta
     *
     * @param string $cuenta
     *
     * @return Usuario
     */
    public function setCuenta($cuenta)
    {
        $this->cuenta = $cuenta;

        return $this;
    }

    /**
     * Get cuenta
     *
     * @return string
     */
    public function getCuenta()
    {
        return $this->cuenta;
    }

    /**
     * Set contrasena
     *
     * @param string $contrasena
     *
     * @return Usuario
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
     * Set id
     *
     * @param string $id
     *
     * @return Usuario
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get id
     *
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set reiniciarcontrasena
     *
     * @param boolean $reiniciarcontrasena
     *
     * @return Usuario
     */
    public function setReiniciarcontrasena($reiniciarcontrasena)
    {
        $this->reiniciarcontrasena = $reiniciarcontrasena;

        return $this;
    }

    /**
     * Get reiniciarcontrasena
     *
     * @return boolean
     */
    public function getReiniciarcontrasena()
    {
        return $this->reiniciarcontrasena;
    }

    /**
     * Set activo
     *
     * @param boolean $activo
     *
     * @return Usuario
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
     * Set usuarioenmascarado
     *
     * @param integer $usuarioenmascarado
     *
     * @return Usuario
     */
    public function setUsuarioenmascarado($usuarioenmascarado)
    {
        $this->usuarioenmascarado = $usuarioenmascarado;

        return $this;
    }

    /**
     * Get usuarioenmascarado
     *
     * @return integer
     */
    public function getUsuarioenmascarado()
    {
        return $this->usuarioenmascarado;
    }

    /**
     * Get usuarioid
     *
     * @return integer
     */
    public function getUsuarioid()
    {
        return $this->usuarioid;
    }

    /**
     * Set personaid
     *
     * @param \AppBundle\Entity\Persona $personaid
     *
     * @return Usuario
     */
    public function setPersonaid(\AppBundle\Entity\Persona $personaid = null)
    {
        $this->personaid = $personaid;

        return $this;
    }

    /**
     * Get personaid
     *
     * @return \AppBundle\Entity\Persona
     */
    public function getPersonaid()
    {
        return $this->personaid;
    }

    /**
     * Set tipousuarioid
     *
     * @param \AppBundle\Entity\Tipousuario $tipousuarioid
     *
     * @return Usuario
     */
    public function setTipousuarioid(\AppBundle\Entity\Tipousuario $tipousuarioid = null)
    {
        $this->tipousuarioid = $tipousuarioid;

        return $this;
    }

    /**
     * Get tipousuarioid
     *
     * @return \AppBundle\Entity\Tipousuario
     */
    public function getTipousuarioid()
    {
        return $this->tipousuarioid;
    }

    /**
     * Set padreotutorid
     *
     * @param \AppBundle\Entity\CePadresotutores $padreotutorid
     *
     * @return Usuario
     */
    public function setPadreotutorid(\AppBundle\Entity\CePadresotutores $padreotutorid = null)
    {
        $this->padreotutorid = $padreotutorid;

        return $this;
    }

    /**
     * Get padreotutorid
     *
     * @return \AppBundle\Entity\CePadresotutores
     */
    public function getPadreotutorid()
    {
        return $this->padreotutorid;
    }

    /**
     * Set profesorid
     *
     * @param \AppBundle\Entity\CeProfesor $profesorid
     *
     * @return Usuario
     */
    public function setProfesorid(\AppBundle\Entity\CeProfesor $profesorid = null)
    {
        $this->profesorid = $profesorid;

        return $this;
    }

    /**
     * Get profesorid
     *
     * @return \AppBundle\Entity\CeProfesor
     */
    public function getProfesorid()
    {
        return $this->profesorid;
    }

    /**
     * Set alumnoid
     *
     * @param \AppBundle\Entity\CeAlumno $alumnoid
     *
     * @return Usuario
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
}

