<?php

namespace AppBundle\Entity;

/**
 * CePlantillaprofesor
 */
class CePlantillaprofesor
{
    /**
     * @var string
     */
    private $comentarios;

    /**
     * @var integer
     */
    private $plantillaprofesorid;

    /**
     * @var \AppBundle\Entity\CeEstatusplantillaprofesor
     */
    private $estatusplantillaprofesorid;

    /**
     * @var \AppBundle\Entity\CePlanestudios
     */
    private $planestudioid;

    /**
     * @var \AppBundle\Entity\Usuario
     */
    private $usuariocapturaid;

    /**
     * @var \AppBundle\Entity\Usuario
     */
    private $usuariovalidaid;

    /**
     * @var \AppBundle\Entity\CeTipomateriaplantillaprofesor
     */
    private $tipomateriaplantillaprofesorid;

    /**
     * @var \AppBundle\Entity\Ciclo
     */
    private $cicloid;


    /**
     * Set comentarios
     *
     * @param string $comentarios
     *
     * @return CePlantillaprofesor
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
     * Get plantillaprofesorid
     *
     * @return integer
     */
    public function getPlantillaprofesorid()
    {
        return $this->plantillaprofesorid;
    }

    /**
     * Set estatusplantillaprofesorid
     *
     * @param \AppBundle\Entity\CeEstatusplantillaprofesor $estatusplantillaprofesorid
     *
     * @return CePlantillaprofesor
     */
    public function setEstatusplantillaprofesorid(\AppBundle\Entity\CeEstatusplantillaprofesor $estatusplantillaprofesorid = null)
    {
        $this->estatusplantillaprofesorid = $estatusplantillaprofesorid;

        return $this;
    }

    /**
     * Get estatusplantillaprofesorid
     *
     * @return \AppBundle\Entity\CeEstatusplantillaprofesor
     */
    public function getEstatusplantillaprofesorid()
    {
        return $this->estatusplantillaprofesorid;
    }

    /**
     * Set planestudioid
     *
     * @param \AppBundle\Entity\CePlanestudios $planestudioid
     *
     * @return CePlantillaprofesor
     */
    public function setPlanestudioid(\AppBundle\Entity\CePlanestudios $planestudioid = null)
    {
        $this->planestudioid = $planestudioid;

        return $this;
    }

    /**
     * Get planestudioid
     *
     * @return \AppBundle\Entity\CePlanestudios
     */
    public function getPlanestudioid()
    {
        return $this->planestudioid;
    }

    /**
     * Set usuariocapturaid
     *
     * @param \AppBundle\Entity\Usuario $usuariocapturaid
     *
     * @return CePlantillaprofesor
     */
    public function setUsuariocapturaid(\AppBundle\Entity\Usuario $usuariocapturaid = null)
    {
        $this->usuariocapturaid = $usuariocapturaid;

        return $this;
    }

    /**
     * Get usuariocapturaid
     *
     * @return \AppBundle\Entity\Usuario
     */
    public function getUsuariocapturaid()
    {
        return $this->usuariocapturaid;
    }

    /**
     * Set usuariovalidaid
     *
     * @param \AppBundle\Entity\Usuario $usuariovalidaid
     *
     * @return CePlantillaprofesor
     */
    public function setUsuariovalidaid(\AppBundle\Entity\Usuario $usuariovalidaid = null)
    {
        $this->usuariovalidaid = $usuariovalidaid;

        return $this;
    }

    /**
     * Get usuariovalidaid
     *
     * @return \AppBundle\Entity\Usuario
     */
    public function getUsuariovalidaid()
    {
        return $this->usuariovalidaid;
    }

    /**
     * Set tipomateriaplantillaprofesorid
     *
     * @param \AppBundle\Entity\CeTipomateriaplantillaprofesor $tipomateriaplantillaprofesorid
     *
     * @return CePlantillaprofesor
     */
    public function setTipomateriaplantillaprofesorid(\AppBundle\Entity\CeTipomateriaplantillaprofesor $tipomateriaplantillaprofesorid = null)
    {
        $this->tipomateriaplantillaprofesorid = $tipomateriaplantillaprofesorid;

        return $this;
    }

    /**
     * Get tipomateriaplantillaprofesorid
     *
     * @return \AppBundle\Entity\CeTipomateriaplantillaprofesor
     */
    public function getTipomateriaplantillaprofesorid()
    {
        return $this->tipomateriaplantillaprofesorid;
    }

    /**
     * Set cicloid
     *
     * @param \AppBundle\Entity\Ciclo $cicloid
     *
     * @return CePlantillaprofesor
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
}

