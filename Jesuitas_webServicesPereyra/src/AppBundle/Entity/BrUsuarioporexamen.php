<?php

namespace AppBundle\Entity;

/**
 * BrUsuarioporexamen
 */
class BrUsuarioporexamen
{
    /**
     * @var integer
     */
    private $intentosrestantes;

    /**
     * @var boolean
     */
    private $aplicado;

    /**
     * @var \DateTime
     */
    private $fecha;

    /**
     * @var string
     */
    private $tiempo;

    /**
     * @var integer
     */
    private $puntaje;

    /**
     * @var float
     */
    private $calificacion;

    /**
     * @var integer
     */
    private $usuarioporexamenid;

    /**
     * @var \AppBundle\Entity\BrUsuarioexterno
     */
    private $usuarioexternoid;

    /**
     * @var \AppBundle\Entity\CeAlumno
     */
    private $alumnoid;

    /**
     * @var \AppBundle\Entity\BrExamenporcalendario
     */
    private $examenporcalendarioid;


    /**
     * Set intentosrestantes
     *
     * @param integer $intentosrestantes
     *
     * @return BrUsuarioporexamen
     */
    public function setIntentosrestantes($intentosrestantes)
    {
        $this->intentosrestantes = $intentosrestantes;

        return $this;
    }

    /**
     * Get intentosrestantes
     *
     * @return integer
     */
    public function getIntentosrestantes()
    {
        return $this->intentosrestantes;
    }

    /**
     * Set aplicado
     *
     * @param boolean $aplicado
     *
     * @return BrUsuarioporexamen
     */
    public function setAplicado($aplicado)
    {
        $this->aplicado = $aplicado;

        return $this;
    }

    /**
     * Get aplicado
     *
     * @return boolean
     */
    public function getAplicado()
    {
        return $this->aplicado;
    }

    /**
     * Set fecha
     *
     * @param \DateTime $fecha
     *
     * @return BrUsuarioporexamen
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
     * Set tiempo
     *
     * @param string $tiempo
     *
     * @return BrUsuarioporexamen
     */
    public function setTiempo($tiempo)
    {
        $this->tiempo = $tiempo;

        return $this;
    }

    /**
     * Get tiempo
     *
     * @return string
     */
    public function getTiempo()
    {
        return $this->tiempo;
    }

    /**
     * Set puntaje
     *
     * @param integer $puntaje
     *
     * @return BrUsuarioporexamen
     */
    public function setPuntaje($puntaje)
    {
        $this->puntaje = $puntaje;

        return $this;
    }

    /**
     * Get puntaje
     *
     * @return integer
     */
    public function getPuntaje()
    {
        return $this->puntaje;
    }

    /**
     * Set calificacion
     *
     * @param float $calificacion
     *
     * @return BrUsuarioporexamen
     */
    public function setCalificacion($calificacion)
    {
        $this->calificacion = $calificacion;

        return $this;
    }

    /**
     * Get calificacion
     *
     * @return float
     */
    public function getCalificacion()
    {
        return $this->calificacion;
    }

    /**
     * Get usuarioporexamenid
     *
     * @return integer
     */
    public function getUsuarioporexamenid()
    {
        return $this->usuarioporexamenid;
    }

    /**
     * Set usuarioexternoid
     *
     * @param \AppBundle\Entity\BrUsuarioexterno $usuarioexternoid
     *
     * @return BrUsuarioporexamen
     */
    public function setUsuarioexternoid(\AppBundle\Entity\BrUsuarioexterno $usuarioexternoid = null)
    {
        $this->usuarioexternoid = $usuarioexternoid;

        return $this;
    }

    /**
     * Get usuarioexternoid
     *
     * @return \AppBundle\Entity\BrUsuarioexterno
     */
    public function getUsuarioexternoid()
    {
        return $this->usuarioexternoid;
    }

    /**
     * Set alumnoid
     *
     * @param \AppBundle\Entity\CeAlumno $alumnoid
     *
     * @return BrUsuarioporexamen
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
     * Set examenporcalendarioid
     *
     * @param \AppBundle\Entity\BrExamenporcalendario $examenporcalendarioid
     *
     * @return BrUsuarioporexamen
     */
    public function setExamenporcalendarioid(\AppBundle\Entity\BrExamenporcalendario $examenporcalendarioid = null)
    {
        $this->examenporcalendarioid = $examenporcalendarioid;

        return $this;
    }

    /**
     * Get examenporcalendarioid
     *
     * @return \AppBundle\Entity\BrExamenporcalendario
     */
    public function getExamenporcalendarioid()
    {
        return $this->examenporcalendarioid;
    }
}

