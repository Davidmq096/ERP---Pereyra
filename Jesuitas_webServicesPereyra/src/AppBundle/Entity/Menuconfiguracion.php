<?php

namespace AppBundle\Entity;

/**
 * Menuconfiguracion
 */
class Menuconfiguracion
{
    /**
     * @var integer
     */
    private $sistema;

    /**
     * @var string
     */
    private $title;

    /**
     * @var string
     */
    private $key;

    /**
     * @var string
     */
    private $icon;

    /**
     * @var string
     */
    private $color;

    /**
     * @var string
     */
    private $action;

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
    private $menuconfiguracionid;

    /**
     * @var \AppBundle\Entity\Menuconfiguracion
     */
    private $menuconfiguracionparentid;


    /**
     * Set sistema
     *
     * @param integer $sistema
     *
     * @return Menuconfiguracion
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
     * @return Menuconfiguracion
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
     * Set key
     *
     * @param string $key
     *
     * @return Menuconfiguracion
     */
    public function setKey($key)
    {
        $this->key = $key;

        return $this;
    }

    /**
     * Get key
     *
     * @return string
     */
    public function getKey()
    {
        return $this->key;
    }

    /**
     * Set icon
     *
     * @param string $icon
     *
     * @return Menuconfiguracion
     */
    public function setIcon($icon)
    {
        $this->icon = $icon;

        return $this;
    }

    /**
     * Get icon
     *
     * @return string
     */
    public function getIcon()
    {
        return $this->icon;
    }

    /**
     * Set color
     *
     * @param string $color
     *
     * @return Menuconfiguracion
     */
    public function setColor($color)
    {
        $this->color = $color;

        return $this;
    }

    /**
     * Get color
     *
     * @return string
     */
    public function getColor()
    {
        return $this->color;
    }

    /**
     * Set action
     *
     * @param string $action
     *
     * @return Menuconfiguracion
     */
    public function setAction($action)
    {
        $this->action = $action;

        return $this;
    }

    /**
     * Get action
     *
     * @return string
     */
    public function getAction()
    {
        return $this->action;
    }

    /**
     * Set orden
     *
     * @param integer $orden
     *
     * @return Menuconfiguracion
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
     * @return Menuconfiguracion
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
     * Get menuconfiguracionid
     *
     * @return integer
     */
    public function getMenuconfiguracionid()
    {
        return $this->menuconfiguracionid;
    }

    /**
     * Set menuconfiguracionparentid
     *
     * @param \AppBundle\Entity\Menuconfiguracion $menuconfiguracionparentid
     *
     * @return Menuconfiguracion
     */
    public function setMenuconfiguracionparentid(\AppBundle\Entity\Menuconfiguracion $menuconfiguracionparentid = null)
    {
        $this->menuconfiguracionparentid = $menuconfiguracionparentid;

        return $this;
    }

    /**
     * Get menuconfiguracionparentid
     *
     * @return \AppBundle\Entity\Menuconfiguracion
     */
    public function getMenuconfiguracionparentid()
    {
        return $this->menuconfiguracionparentid;
    }
}

