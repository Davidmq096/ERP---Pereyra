<?php

namespace AppBundle\Entity;

/**
 * CjEmpresa
 */
class CjEmpresa
{
    /**
     * @var string
     */
    private $nombre;

    /**
     * @var string
     */
    private $alias;

    /**
     * @var string
     */
    private $color = '';

    /**
     * @var boolean
     */
    private $activo;

    /**
     * @var string
     */
    private $logo;

    /**
     * @var integer
     */
    private $tiposistemafacturacion;

    /**
     * @var string
     */
    private $nombresistema;

    /**
     * @var string
     */
    private $usuariocontpaq;

    /**
     * @var string
     */
    private $passworcontpaq;

    /**
     * @var string
     */
    private $passwordtimbrado;

    /**
     * @var string
     */
    private $rutareportepdfxml;

    /**
     * @var string
     */
    private $rutaempresa;

    /**
     * @var string
     */
    private $rutaservidorxmlpdf;

    /**
     * @var string
     */
    private $rutalocalxmlpdf;

    /**
     * @var string
     */
    private $registrowindows;

    /**
     * @var integer
     */
    private $empresaid;


    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return CjEmpresa
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * Get nombre
     *
     * @return string
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Set alias
     *
     * @param string $alias
     *
     * @return CjEmpresa
     */
    public function setAlias($alias)
    {
        $this->alias = $alias;

        return $this;
    }

    /**
     * Get alias
     *
     * @return string
     */
    public function getAlias()
    {
        return $this->alias;
    }

    /**
     * Set color
     *
     * @param string $color
     *
     * @return CjEmpresa
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
     * Set activo
     *
     * @param boolean $activo
     *
     * @return CjEmpresa
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
     * Set logo
     *
     * @param string $logo
     *
     * @return CjEmpresa
     */
    public function setLogo($logo)
    {
        $this->logo = $logo;

        return $this;
    }

    /**
     * Get logo
     *
     * @return string
     */
    public function getLogo()
    {
        return $this->logo;
    }

    /**
     * Set tiposistemafacturacion
     *
     * @param integer $tiposistemafacturacion
     *
     * @return CjEmpresa
     */
    public function setTiposistemafacturacion($tiposistemafacturacion)
    {
        $this->tiposistemafacturacion = $tiposistemafacturacion;

        return $this;
    }

    /**
     * Get tiposistemafacturacion
     *
     * @return integer
     */
    public function getTiposistemafacturacion()
    {
        return $this->tiposistemafacturacion;
    }

    /**
     * Set nombresistema
     *
     * @param string $nombresistema
     *
     * @return CjEmpresa
     */
    public function setNombresistema($nombresistema)
    {
        $this->nombresistema = $nombresistema;

        return $this;
    }

    /**
     * Get nombresistema
     *
     * @return string
     */
    public function getNombresistema()
    {
        return $this->nombresistema;
    }

    /**
     * Set usuariocontpaq
     *
     * @param string $usuariocontpaq
     *
     * @return CjEmpresa
     */
    public function setUsuariocontpaq($usuariocontpaq)
    {
        $this->usuariocontpaq = $usuariocontpaq;

        return $this;
    }

    /**
     * Get usuariocontpaq
     *
     * @return string
     */
    public function getUsuariocontpaq()
    {
        return $this->usuariocontpaq;
    }

    /**
     * Set passworcontpaq
     *
     * @param string $passworcontpaq
     *
     * @return CjEmpresa
     */
    public function setPassworcontpaq($passworcontpaq)
    {
        $this->passworcontpaq = $passworcontpaq;

        return $this;
    }

    /**
     * Get passworcontpaq
     *
     * @return string
     */
    public function getPassworcontpaq()
    {
        return $this->passworcontpaq;
    }

    /**
     * Set passwordtimbrado
     *
     * @param string $passwordtimbrado
     *
     * @return CjEmpresa
     */
    public function setPasswordtimbrado($passwordtimbrado)
    {
        $this->passwordtimbrado = $passwordtimbrado;

        return $this;
    }

    /**
     * Get passwordtimbrado
     *
     * @return string
     */
    public function getPasswordtimbrado()
    {
        return $this->passwordtimbrado;
    }

    /**
     * Set rutareportepdfxml
     *
     * @param string $rutareportepdfxml
     *
     * @return CjEmpresa
     */
    public function setRutareportepdfxml($rutareportepdfxml)
    {
        $this->rutareportepdfxml = $rutareportepdfxml;

        return $this;
    }

    /**
     * Get rutareportepdfxml
     *
     * @return string
     */
    public function getRutareportepdfxml()
    {
        return $this->rutareportepdfxml;
    }

    /**
     * Set rutaempresa
     *
     * @param string $rutaempresa
     *
     * @return CjEmpresa
     */
    public function setRutaempresa($rutaempresa)
    {
        $this->rutaempresa = $rutaempresa;

        return $this;
    }

    /**
     * Get rutaempresa
     *
     * @return string
     */
    public function getRutaempresa()
    {
        return $this->rutaempresa;
    }

    /**
     * Set rutaservidorxmlpdf
     *
     * @param string $rutaservidorxmlpdf
     *
     * @return CjEmpresa
     */
    public function setRutaservidorxmlpdf($rutaservidorxmlpdf)
    {
        $this->rutaservidorxmlpdf = $rutaservidorxmlpdf;

        return $this;
    }

    /**
     * Get rutaservidorxmlpdf
     *
     * @return string
     */
    public function getRutaservidorxmlpdf()
    {
        return $this->rutaservidorxmlpdf;
    }

    /**
     * Set rutalocalxmlpdf
     *
     * @param string $rutalocalxmlpdf
     *
     * @return CjEmpresa
     */
    public function setRutalocalxmlpdf($rutalocalxmlpdf)
    {
        $this->rutalocalxmlpdf = $rutalocalxmlpdf;

        return $this;
    }

    /**
     * Get rutalocalxmlpdf
     *
     * @return string
     */
    public function getRutalocalxmlpdf()
    {
        return $this->rutalocalxmlpdf;
    }

    /**
     * Set registrowindows
     *
     * @param string $registrowindows
     *
     * @return CjEmpresa
     */
    public function setRegistrowindows($registrowindows)
    {
        $this->registrowindows = $registrowindows;

        return $this;
    }

    /**
     * Get registrowindows
     *
     * @return string
     */
    public function getRegistrowindows()
    {
        return $this->registrowindows;
    }

    /**
     * Get empresaid
     *
     * @return integer
     */
    public function getEmpresaid()
    {
        return $this->empresaid;
    }
}

