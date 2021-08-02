<?php

namespace AppBundle\Entity;

/**
 * MaAsignacionmenu
 */
class MaAsignacionmenu
{
    /**
     * @var \DateTime
     */
    private $fecha;

    /**
     * @var boolean
     */
    private $visto;

    /**
     * @var \DateTime
     */
    private $fechavisto;

    /**
     * @var integer
     */
    private $asignacionmenuid;

    /**
     * @var \AppBundle\Entity\CeAlumno
     */
    private $alumnoid;

    /**
     * @var \AppBundle\Entity\MaMenu
     */
    private $menuanteriorid;

    /**
     * @var \AppBundle\Entity\MaMenu
     */
    private $menuid;


    /**
     * Set fecha
     *
     * @param \DateTime $fecha
     *
     * @return MaAsignacionmenu
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
     * Set visto
     *
     * @param boolean $visto
     *
     * @return MaAsignacionmenu
     */
    public function setVisto($visto)
    {
        $this->visto = $visto;

        return $this;
    }

    /**
     * Get visto
     *
     * @return boolean
     */
    public function getVisto()
    {
        return $this->visto;
    }

    /**
     * Set fechavisto
     *
     * @param \DateTime $fechavisto
     *
     * @return MaAsignacionmenu
     */
    public function setFechavisto($fechavisto)
    {
        $this->fechavisto = $fechavisto;

        return $this;
    }

    /**
     * Get fechavisto
     *
     * @return \DateTime
     */
    public function getFechavisto()
    {
        return $this->fechavisto;
    }

    /**
     * Get asignacionmenuid
     *
     * @return integer
     */
    public function getAsignacionmenuid()
    {
        return $this->asignacionmenuid;
    }

    /**
     * Set alumnoid
     *
     * @param \AppBundle\Entity\CeAlumno $alumnoid
     *
     * @return MaAsignacionmenu
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
     * Set menuanteriorid
     *
     * @param \AppBundle\Entity\MaMenu $menuanteriorid
     *
     * @return MaAsignacionmenu
     */
    public function setMenuanteriorid(\AppBundle\Entity\MaMenu $menuanteriorid = null)
    {
        $this->menuanteriorid = $menuanteriorid;

        return $this;
    }

    /**
     * Get menuanteriorid
     *
     * @return \AppBundle\Entity\MaMenu
     */
    public function getMenuanteriorid()
    {
        return $this->menuanteriorid;
    }

    /**
     * Set menuid
     *
     * @param \AppBundle\Entity\MaMenu $menuid
     *
     * @return MaAsignacionmenu
     */
    public function setMenuid(\AppBundle\Entity\MaMenu $menuid = null)
    {
        $this->menuid = $menuid;

        return $this;
    }

    /**
     * Get menuid
     *
     * @return \AppBundle\Entity\MaMenu
     */
    public function getMenuid()
    {
        return $this->menuid;
    }
}

