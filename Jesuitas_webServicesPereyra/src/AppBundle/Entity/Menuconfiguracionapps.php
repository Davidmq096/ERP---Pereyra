<?php

namespace AppBundle\Entity;

/**
 * Menuconfiguracionapps
 */
class Menuconfiguracionapps
{
    /**
     * @var integer
     */
    private $menuconfiguracionparentid;

    /**
     * @var integer
     */
    private $sistema;

    /**
     * @var string
     */
    private $title;

    /**
     * @var integer
     */
    private $orden;

    /**
     * @var boolean
     */
    private $activo;

    /**
     * @var integer
     */
    private $menuconfiguracionappid;


    /**
     * Set menuconfiguracionparentid
     *
     * @param integer $menuconfiguracionparentid
     *
     * @return Menuconfiguracionapps
     */
    public function setMenuconfiguracionparentid($menuconfiguracionparentid)
    {
        $this->menuconfiguracionparentid = $menuconfiguracionparentid;

        return $this;
    }

    /**
     * Get menuconfiguracionparentid
     *
     * @return integer
     */
    public function getMenuconfiguracionparentid()
    {
        return $this->menuconfiguracionparentid;
    }

    /**
     * Set sistema
     *
     * @param integer $sistema
     *
     * @return Menuconfiguracionapps
     */
    public function setSistema($sistema)
    {
        $this->sistema = $sistema;

        return $this;
    }

    /**
     * Get sistema
     *
     * @return integer
     */
    public function getSistema()
    {
        return $this->sistema;
    }

    /**
     * Set title
     *
     * @param string $title
     *
     * @return Menuconfiguracionapps
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set orden
     *
     * @param integer $orden
     *
     * @return Menuconfiguracionapps
     */
    public function setOrden($orden)
    {
        $this->orden = $orden;

        return $this;
    }

    /**
     * Get orden
     *
     * @return integer
     */
    public function getOrden()
    {
        return $this->orden;
    }

    /**
     * Set activo
     *
     * @param boolean $activo
     *
     * @return Menuconfiguracionapps
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
     * Get menuconfiguracionappid
     *
     * @return integer
     */
    public function getMenuconfiguracionappid()
    {
        return $this->menuconfiguracionappid;
    }
}

