<?php

namespace AppBundle\Entity;

/**
 * Menuconfiguracionappsnivel
 */
class Menuconfiguracionappsnivel
{
    /**
     * @var boolean
     */
    private $activo;

    /**
     * @var integer
     */
    private $menuconfiguracionappnivelid;

    /**
     * @var \AppBundle\Entity\Menuconfiguracionapps
     */
    private $menuconfiguracionappid;

    /**
     * @var \AppBundle\Entity\Nivel
     */
    private $nivelid;


    /**
     * Set activo
     *
     * @param boolean $activo
     *
     * @return Menuconfiguracionappsnivel
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
     * Get menuconfiguracionappnivelid
     *
     * @return integer
     */
    public function getMenuconfiguracionappnivelid()
    {
        return $this->menuconfiguracionappnivelid;
    }

    /**
     * Set menuconfiguracionappid
     *
     * @param \AppBundle\Entity\Menuconfiguracionapps $menuconfiguracionappid
     *
     * @return Menuconfiguracionappsnivel
     */
    public function setMenuconfiguracionappid(\AppBundle\Entity\Menuconfiguracionapps $menuconfiguracionappid = null)
    {
        $this->menuconfiguracionappid = $menuconfiguracionappid;

        return $this;
    }

    /**
     * Get menuconfiguracionappid
     *
     * @return \AppBundle\Entity\Menuconfiguracionapps
     */
    public function getMenuconfiguracionappid()
    {
        return $this->menuconfiguracionappid;
    }

    /**
     * Set nivelid
     *
     * @param \AppBundle\Entity\Nivel $nivelid
     *
     * @return Menuconfiguracionappsnivel
     */
    public function setNivelid(\AppBundle\Entity\Nivel $nivelid = null)
    {
        $this->nivelid = $nivelid;

        return $this;
    }

    /**
     * Get nivelid
     *
     * @return \AppBundle\Entity\Nivel
     */
    public function getNivelid()
    {
        return $this->nivelid;
    }
}

