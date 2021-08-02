<?php

namespace AppBundle\Entity;

/**
 * FoFondoorfandad
 */
class FoFondoorfandad
{
    /**
     * @var \DateTime
     */
    private $fechainicio;

    /**
     * @var string
     */
    private $comentarios;

    /**
     * @var integer
     */
    private $porcentajeapoyo;

    /**
     * @var integer
     */
    private $fondoorfandadid;

    /**
     * @var \AppBundle\Entity\CeAlumno
     */
    private $alumnoid;

    /**
     * @var \AppBundle\Entity\Ciclo
     */
    private $cicloid;

    /**
     * @var \AppBundle\Entity\FoEstatus
     */
    private $estatusid;


    /**
     * Set fechainicio
     *
     * @param \DateTime $fechainicio
     *
     * @return FoFondoorfandad
     */
    public function setFechainicio($fechainicio)
    {
        $this->fechainicio = $fechainicio;

        return $this;
    }

    /**
     * Get fechainicio
     *
     * @return \DateTime
     */
    public function getFechainicio()
    {
        return $this->fechainicio;
    }

    /**
     * Set comentarios
     *
     * @param string $comentarios
     *
     * @return FoFondoorfandad
     */
    public function setComentarios($comentarios)
    {
        $this->comentarios = $comentarios;

        return $this;
    }

    /**
     * Get comentarios
     *
     * @return string
     */
    public function getComentarios()
    {
        return $this->comentarios;
    }

    /**
     * Set porcentajeapoyo
     *
     * @param integer $porcentajeapoyo
     *
     * @return FoFondoorfandad
     */
    public function setPorcentajeapoyo($porcentajeapoyo)
    {
        $this->porcentajeapoyo = $porcentajeapoyo;

        return $this;
    }

    /**
     * Get porcentajeapoyo
     *
     * @return integer
     */
    public function getPorcentajeapoyo()
    {
        return $this->porcentajeapoyo;
    }

    /**
     * Get fondoorfandadid
     *
     * @return integer
     */
    public function getFondoorfandadid()
    {
        return $this->fondoorfandadid;
    }

    /**
     * Set alumnoid
     *
     * @param \AppBundle\Entity\CeAlumno $alumnoid
     *
     * @return FoFondoorfandad
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
     * Set cicloid
     *
     * @param \AppBundle\Entity\Ciclo $cicloid
     *
     * @return FoFondoorfandad
     */
    public function setCicloid(\AppBundle\Entity\Ciclo $cicloid = null)
    {
        $this->cicloid = $cicloid;

        return $this;
    }

    /**
     * Get cicloid
     *
     * @return \AppBundle\Entity\Ciclo
     */
    public function getCicloid()
    {
        return $this->cicloid;
    }

    /**
     * Set estatusid
     *
     * @param \AppBundle\Entity\FoEstatus $estatusid
     *
     * @return FoFondoorfandad
     */
    public function setEstatusid(\AppBundle\Entity\FoEstatus $estatusid = null)
    {
        $this->estatusid = $estatusid;

        return $this;
    }

    /**
     * Get estatusid
     *
     * @return \AppBundle\Entity\FoEstatus
     */
    public function getEstatusid()
    {
        return $this->estatusid;
    }
}

