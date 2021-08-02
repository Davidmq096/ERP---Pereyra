<?php

namespace AppBundle\Entity;

/**
 * BrRespuestaporreactivo
 */
class BrRespuestaporreactivo
{
    /**
     * @var string
     */
    private $descripcion;

    /**
     * @var string
     */
    private $comentario;

    /**
     * @var boolean
     */
    private $correcta;

    /**
     * @var integer
     */
    private $respuestaporreactivoid;

    /**
     * @var \AppBundle\Entity\BrReactivo
     */
    private $reactivoid;


    /**
     * Set descripcion
     *
     * @param string $descripcion
     *
     * @return BrRespuestaporreactivo
     */
    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    /**
     * Get descripcion
     *
     * @return string
     */
    public function getDescripcion()
    {
        return $this->descripcion;
    }

    /**
     * Set comentario
     *
     * @param string $comentario
     *
     * @return BrRespuestaporreactivo
     */
    public function setComentario($comentario)
    {
        $this->comentario = $comentario;

        return $this;
    }

    /**
     * Get comentario
     *
     * @return string
     */
    public function getComentario()
    {
        return $this->comentario;
    }

    /**
     * Set correcta
     *
     * @param boolean $correcta
     *
     * @return BrRespuestaporreactivo
     */
    public function setCorrecta($correcta)
    {
        $this->correcta = $correcta;

        return $this;
    }

    /**
     * Get correcta
     *
     * @return boolean
     */
    public function getCorrecta()
    {
        return $this->correcta;
    }

    /**
     * Get respuestaporreactivoid
     *
     * @return integer
     */
    public function getRespuestaporreactivoid()
    {
        return $this->respuestaporreactivoid;
    }

    /**
     * Set reactivoid
     *
     * @param \AppBundle\Entity\BrReactivo $reactivoid
     *
     * @return BrRespuestaporreactivo
     */
    public function setReactivoid(\AppBundle\Entity\BrReactivo $reactivoid = null)
    {
        $this->reactivoid = $reactivoid;

        return $this;
    }

    /**
     * Get reactivoid
     *
     * @return \AppBundle\Entity\BrReactivo
     */
    public function getReactivoid()
    {
        return $this->reactivoid;
    }
}

