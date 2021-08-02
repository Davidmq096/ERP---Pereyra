<?php

namespace AppBundle\Entity;

/**
 * CeTallerbitacora
 */
class CeTallerbitacora
{
    /**
     * @var \DateTime
     */
    private $fecha;

    /**
     * @var integer
     */
    private $tallerid;

    /**
     * @var string
     */
    private $motivo;

    /**
     * @var integer
     */
    private $tallerbitacoraid;

    /**
     * @var \AppBundle\Entity\CeAlumnoporciclo
     */
    private $alumnoporcicloid;

    /**
     * @var \AppBundle\Entity\CeTalleraccion
     */
    private $talleraccionid;

    /**
     * @var \AppBundle\Entity\CeTipotaller
     */
    private $tipotallerid;

    /**
     * @var \AppBundle\Entity\Usuario
     */
    private $usuarioid;


    /**
     * Set fecha
     *
     * @param \DateTime $fecha
     *
     * @return CeTallerbitacora
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
     * Set tallerid
     *
     * @param integer $tallerid
     *
     * @return CeTallerbitacora
     */
    public function setTallerid($tallerid)
    {
        $this->tallerid = $tallerid;

        return $this;
    }

    /**
     * Get tallerid
     *
     * @return integer
     */
    public function getTallerid()
    {
        return $this->tallerid;
    }

    /**
     * Set motivo
     *
     * @param string $motivo
     *
     * @return CeTallerbitacora
     */
    public function setMotivo($motivo)
    {
        $this->motivo = $motivo;

        return $this;
    }

    /**
     * Get motivo
     *
     * @return string
     */
    public function getMotivo()
    {
        return $this->motivo;
    }

    /**
     * Get tallerbitacoraid
     *
     * @return integer
     */
    public function getTallerbitacoraid()
    {
        return $this->tallerbitacoraid;
    }

    /**
     * Set alumnoporcicloid
     *
     * @param \AppBundle\Entity\CeAlumnoporciclo $alumnoporcicloid
     *
     * @return CeTallerbitacora
     */
    public function setAlumnoporcicloid(\AppBundle\Entity\CeAlumnoporciclo $alumnoporcicloid = null)
    {
        $this->alumnoporcicloid = $alumnoporcicloid;

        return $this;
    }

    /**
     * Get alumnoporcicloid
     *
     * @return \AppBundle\Entity\CeAlumnoporciclo
     */
    public function getAlumnoporcicloid()
    {
        return $this->alumnoporcicloid;
    }

    /**
     * Set talleraccionid
     *
     * @param \AppBundle\Entity\CeTalleraccion $talleraccionid
     *
     * @return CeTallerbitacora
     */
    public function setTalleraccionid(\AppBundle\Entity\CeTalleraccion $talleraccionid = null)
    {
        $this->talleraccionid = $talleraccionid;

        return $this;
    }

    /**
     * Get talleraccionid
     *
     * @return \AppBundle\Entity\CeTalleraccion
     */
    public function getTalleraccionid()
    {
        return $this->talleraccionid;
    }

    /**
     * Set tipotallerid
     *
     * @param \AppBundle\Entity\CeTipotaller $tipotallerid
     *
     * @return CeTallerbitacora
     */
    public function setTipotallerid(\AppBundle\Entity\CeTipotaller $tipotallerid = null)
    {
        $this->tipotallerid = $tipotallerid;

        return $this;
    }

    /**
     * Get tipotallerid
     *
     * @return \AppBundle\Entity\CeTipotaller
     */
    public function getTipotallerid()
    {
        return $this->tipotallerid;
    }

    /**
     * Set usuarioid
     *
     * @param \AppBundle\Entity\Usuario $usuarioid
     *
     * @return CeTallerbitacora
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

