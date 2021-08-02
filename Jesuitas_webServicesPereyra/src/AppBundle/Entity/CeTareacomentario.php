<?php

namespace AppBundle\Entity;

/**
 * CeTareacomentario
 */
class CeTareacomentario
{
    /**
     * @var string
     */
    private $comentario;

    /**
     * @var \DateTime
     */
    private $fecha;

    /**
     * @var integer
     */
    private $alumnoid;

    /**
     * @var boolean
     */
    private $leido;

    /**
     * @var integer
     */
    private $tareacomentarioid;

    /**
     * @var \AppBundle\Entity\CeTarea
     */
    private $tareaid;

    /**
     * @var \AppBundle\Entity\Usuario
     */
    private $usuarioid;


    /**
     * Set comentario
     *
     * @param string $comentario
     *
     * @return CeTareacomentario
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
     * Set fecha
     *
     * @param \DateTime $fecha
     *
     * @return CeTareacomentario
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
     * Set alumnoid
     *
     * @param integer $alumnoid
     *
     * @return CeTareacomentario
     */
    public function setAlumnoid($alumnoid)
    {
        $this->alumnoid = $alumnoid;

        return $this;
    }

    /**
     * Get alumnoid
     *
     * @return integer
     */
    public function getAlumnoid()
    {
        return $this->alumnoid;
    }

    /**
     * Set leido
     *
     * @param boolean $leido
     *
     * @return CeTareacomentario
     */
    public function setLeido($leido)
    {
        $this->leido = $leido;

        return $this;
    }

    /**
     * Get leido
     *
     * @return boolean
     */
    public function getLeido()
    {
        return $this->leido;
    }

    /**
     * Get tareacomentarioid
     *
     * @return integer
     */
    public function getTareacomentarioid()
    {
        return $this->tareacomentarioid;
    }

    /**
     * Set tareaid
     *
     * @param \AppBundle\Entity\CeTarea $tareaid
     *
     * @return CeTareacomentario
     */
    public function setTareaid(\AppBundle\Entity\CeTarea $tareaid = null)
    {
        $this->tareaid = $tareaid;

        return $this;
    }

    /**
     * Get tareaid
     *
     * @return \AppBundle\Entity\CeTarea
     */
    public function getTareaid()
    {
        return $this->tareaid;
    }

    /**
     * Set usuarioid
     *
     * @param \AppBundle\Entity\Usuario $usuarioid
     *
     * @return CeTareacomentario
     */
    public function setUsuarioid(\AppBundle\Entity\Usuario $usuarioid = null)
    {
        $this->usuarioid = $usuarioid;

        return $this;
    }

    /**
     * Get usuarioid
     *
     * @return \AppBundle\Entity\Usuario
     */
    public function getUsuarioid()
    {
        return $this->usuarioid;
    }
}

