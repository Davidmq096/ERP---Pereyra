<?php

namespace AppBundle\Entity;

/**
 * CePonderacionopcion
 */
class CePonderacionopcion
{
    /**
     * @var string
     */
    private $opcion;

    /**
     * @var string
     */
    private $descripcioncorta;

    /**
     * @var string
     */
    private $descripcion;

    /**
     * @var integer
     */
    private $valornumericoparapromedio;

    /**
     * @var integer
     */
    private $calificacionminima;

    /**
     * @var integer
     */
    private $calificacionmaxima;

    /**
     * @var integer
     */
    private $ponderacionopcionid;

    /**
     * @var \AppBundle\Entity\CePonderacion
     */
    private $ponderacionid;


    /**
     * Set opcion
     *
     * @param string $opcion
     *
     * @return CePonderacionopcion
     */
    public function setOpcion($opcion)
    {
        $this->opcion = $opcion;

        return $this;
    }

    /**
     * Get opcion
     *
     * @return string
     */
    public function getOpcion()
    {
        return $this->opcion;
    }

    /**
     * Set descripcioncorta
     *
     * @param string $descripcioncorta
     *
     * @return CePonderacionopcion
     */
    public function setDescripcioncorta($descripcioncorta)
    {
        $this->descripcioncorta = $descripcioncorta;

        return $this;
    }

    /**
     * Get descripcioncorta
     *
     * @return string
     */
    public function getDescripcioncorta()
    {
        return $this->descripcioncorta;
    }

    /**
     * Set descripcion
     *
     * @param string $descripcion
     *
     * @return CePonderacionopcion
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
     * Set valornumericoparapromedio
     *
     * @param integer $valornumericoparapromedio
     *
     * @return CePonderacionopcion
     */
    public function setValornumericoparapromedio($valornumericoparapromedio)
    {
        $this->valornumericoparapromedio = $valornumericoparapromedio;

        return $this;
    }

    /**
     * Get valornumericoparapromedio
     *
     * @return integer
     */
    public function getValornumericoparapromedio()
    {
        return $this->valornumericoparapromedio;
    }

    /**
     * Set calificacionminima
     *
     * @param integer $calificacionminima
     *
     * @return CePonderacionopcion
     */
    public function setCalificacionminima($calificacionminima)
    {
        $this->calificacionminima = $calificacionminima;

        return $this;
    }

    /**
     * Get calificacionminima
     *
     * @return integer
     */
    public function getCalificacionminima()
    {
        return $this->calificacionminima;
    }

    /**
     * Set calificacionmaxima
     *
     * @param integer $calificacionmaxima
     *
     * @return CePonderacionopcion
     */
    public function setCalificacionmaxima($calificacionmaxima)
    {
        $this->calificacionmaxima = $calificacionmaxima;

        return $this;
    }

    /**
     * Get calificacionmaxima
     *
     * @return integer
     */
    public function getCalificacionmaxima()
    {
        return $this->calificacionmaxima;
    }

    /**
     * Get ponderacionopcionid
     *
     * @return integer
     */
    public function getPonderacionopcionid()
    {
        return $this->ponderacionopcionid;
    }

    /**
     * Set ponderacionid
     *
     * @param \AppBundle\Entity\CePonderacion $ponderacionid
     *
     * @return CePonderacionopcion
     */
    public function setPonderacionid(\AppBundle\Entity\CePonderacion $ponderacionid = null)
    {
        $this->ponderacionid = $ponderacionid;

        return $this;
    }

    /**
     * Get ponderacionid
     *
     * @return \AppBundle\Entity\CePonderacion
     */
    public function getPonderacionid()
    {
        return $this->ponderacionid;
    }
}

