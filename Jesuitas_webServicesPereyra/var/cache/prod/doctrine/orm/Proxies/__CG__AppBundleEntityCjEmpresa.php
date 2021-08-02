<?php

namespace Proxies\__CG__\AppBundle\Entity;

/**
 * DO NOT EDIT THIS FILE - IT WAS CREATED BY DOCTRINE'S PROXY GENERATOR
 */
class CjEmpresa extends \AppBundle\Entity\CjEmpresa implements \Doctrine\ORM\Proxy\Proxy
{
    /**
     * @var \Closure the callback responsible for loading properties in the proxy object. This callback is called with
     *      three parameters, being respectively the proxy object to be initialized, the method that triggered the
     *      initialization process and an array of ordered parameters that were passed to that method.
     *
     * @see \Doctrine\Common\Persistence\Proxy::__setInitializer
     */
    public $__initializer__;

    /**
     * @var \Closure the callback responsible of loading properties that need to be copied in the cloned object
     *
     * @see \Doctrine\Common\Persistence\Proxy::__setCloner
     */
    public $__cloner__;

    /**
     * @var boolean flag indicating if this object was already initialized
     *
     * @see \Doctrine\Common\Persistence\Proxy::__isInitialized
     */
    public $__isInitialized__ = false;

    /**
     * @var array properties to be lazy loaded, with keys being the property
     *            names and values being their default values
     *
     * @see \Doctrine\Common\Persistence\Proxy::__getLazyProperties
     */
    public static $lazyPropertiesDefaults = [];



    /**
     * @param \Closure $initializer
     * @param \Closure $cloner
     */
    public function __construct($initializer = null, $cloner = null)
    {

        $this->__initializer__ = $initializer;
        $this->__cloner__      = $cloner;
    }







    /**
     * 
     * @return array
     */
    public function __sleep()
    {
        if ($this->__isInitialized__) {
            return ['__isInitialized__', '' . "\0" . 'AppBundle\\Entity\\CjEmpresa' . "\0" . 'nombre', '' . "\0" . 'AppBundle\\Entity\\CjEmpresa' . "\0" . 'alias', '' . "\0" . 'AppBundle\\Entity\\CjEmpresa' . "\0" . 'color', '' . "\0" . 'AppBundle\\Entity\\CjEmpresa' . "\0" . 'activo', '' . "\0" . 'AppBundle\\Entity\\CjEmpresa' . "\0" . 'logo', '' . "\0" . 'AppBundle\\Entity\\CjEmpresa' . "\0" . 'tiposistemafacturacion', '' . "\0" . 'AppBundle\\Entity\\CjEmpresa' . "\0" . 'nombresistema', '' . "\0" . 'AppBundle\\Entity\\CjEmpresa' . "\0" . 'usuariocontpaq', '' . "\0" . 'AppBundle\\Entity\\CjEmpresa' . "\0" . 'passworcontpaq', '' . "\0" . 'AppBundle\\Entity\\CjEmpresa' . "\0" . 'passwordtimbrado', '' . "\0" . 'AppBundle\\Entity\\CjEmpresa' . "\0" . 'rutareportepdfxml', '' . "\0" . 'AppBundle\\Entity\\CjEmpresa' . "\0" . 'rutaempresa', '' . "\0" . 'AppBundle\\Entity\\CjEmpresa' . "\0" . 'rutaservidorxmlpdf', '' . "\0" . 'AppBundle\\Entity\\CjEmpresa' . "\0" . 'rutalocalxmlpdf', '' . "\0" . 'AppBundle\\Entity\\CjEmpresa' . "\0" . 'registrowindows', '' . "\0" . 'AppBundle\\Entity\\CjEmpresa' . "\0" . 'empresaid'];
        }

        return ['__isInitialized__', '' . "\0" . 'AppBundle\\Entity\\CjEmpresa' . "\0" . 'nombre', '' . "\0" . 'AppBundle\\Entity\\CjEmpresa' . "\0" . 'alias', '' . "\0" . 'AppBundle\\Entity\\CjEmpresa' . "\0" . 'color', '' . "\0" . 'AppBundle\\Entity\\CjEmpresa' . "\0" . 'activo', '' . "\0" . 'AppBundle\\Entity\\CjEmpresa' . "\0" . 'logo', '' . "\0" . 'AppBundle\\Entity\\CjEmpresa' . "\0" . 'tiposistemafacturacion', '' . "\0" . 'AppBundle\\Entity\\CjEmpresa' . "\0" . 'nombresistema', '' . "\0" . 'AppBundle\\Entity\\CjEmpresa' . "\0" . 'usuariocontpaq', '' . "\0" . 'AppBundle\\Entity\\CjEmpresa' . "\0" . 'passworcontpaq', '' . "\0" . 'AppBundle\\Entity\\CjEmpresa' . "\0" . 'passwordtimbrado', '' . "\0" . 'AppBundle\\Entity\\CjEmpresa' . "\0" . 'rutareportepdfxml', '' . "\0" . 'AppBundle\\Entity\\CjEmpresa' . "\0" . 'rutaempresa', '' . "\0" . 'AppBundle\\Entity\\CjEmpresa' . "\0" . 'rutaservidorxmlpdf', '' . "\0" . 'AppBundle\\Entity\\CjEmpresa' . "\0" . 'rutalocalxmlpdf', '' . "\0" . 'AppBundle\\Entity\\CjEmpresa' . "\0" . 'registrowindows', '' . "\0" . 'AppBundle\\Entity\\CjEmpresa' . "\0" . 'empresaid'];
    }

    /**
     * 
     */
    public function __wakeup()
    {
        if ( ! $this->__isInitialized__) {
            $this->__initializer__ = function (CjEmpresa $proxy) {
                $proxy->__setInitializer(null);
                $proxy->__setCloner(null);

                $existingProperties = get_object_vars($proxy);

                foreach ($proxy->__getLazyProperties() as $property => $defaultValue) {
                    if ( ! array_key_exists($property, $existingProperties)) {
                        $proxy->$property = $defaultValue;
                    }
                }
            };

        }
    }

    /**
     * 
     */
    public function __clone()
    {
        $this->__cloner__ && $this->__cloner__->__invoke($this, '__clone', []);
    }

    /**
     * Forces initialization of the proxy
     */
    public function __load()
    {
        $this->__initializer__ && $this->__initializer__->__invoke($this, '__load', []);
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     */
    public function __isInitialized()
    {
        return $this->__isInitialized__;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     */
    public function __setInitialized($initialized)
    {
        $this->__isInitialized__ = $initialized;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     */
    public function __setInitializer(\Closure $initializer = null)
    {
        $this->__initializer__ = $initializer;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     */
    public function __getInitializer()
    {
        return $this->__initializer__;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     */
    public function __setCloner(\Closure $cloner = null)
    {
        $this->__cloner__ = $cloner;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific cloning logic
     */
    public function __getCloner()
    {
        return $this->__cloner__;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     * @static
     */
    public function __getLazyProperties()
    {
        return self::$lazyPropertiesDefaults;
    }

    
    /**
     * {@inheritDoc}
     */
    public function setNombre($nombre)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setNombre', [$nombre]);

        return parent::setNombre($nombre);
    }

    /**
     * {@inheritDoc}
     */
    public function getNombre()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getNombre', []);

        return parent::getNombre();
    }

    /**
     * {@inheritDoc}
     */
    public function setAlias($alias)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setAlias', [$alias]);

        return parent::setAlias($alias);
    }

    /**
     * {@inheritDoc}
     */
    public function getAlias()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getAlias', []);

        return parent::getAlias();
    }

    /**
     * {@inheritDoc}
     */
    public function setColor($color)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setColor', [$color]);

        return parent::setColor($color);
    }

    /**
     * {@inheritDoc}
     */
    public function getColor()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getColor', []);

        return parent::getColor();
    }

    /**
     * {@inheritDoc}
     */
    public function setActivo($activo)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setActivo', [$activo]);

        return parent::setActivo($activo);
    }

    /**
     * {@inheritDoc}
     */
    public function getActivo()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getActivo', []);

        return parent::getActivo();
    }

    /**
     * {@inheritDoc}
     */
    public function setLogo($logo)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setLogo', [$logo]);

        return parent::setLogo($logo);
    }

    /**
     * {@inheritDoc}
     */
    public function getLogo()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getLogo', []);

        return parent::getLogo();
    }

    /**
     * {@inheritDoc}
     */
    public function setTiposistemafacturacion($tiposistemafacturacion)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setTiposistemafacturacion', [$tiposistemafacturacion]);

        return parent::setTiposistemafacturacion($tiposistemafacturacion);
    }

    /**
     * {@inheritDoc}
     */
    public function getTiposistemafacturacion()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getTiposistemafacturacion', []);

        return parent::getTiposistemafacturacion();
    }

    /**
     * {@inheritDoc}
     */
    public function setNombresistema($nombresistema)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setNombresistema', [$nombresistema]);

        return parent::setNombresistema($nombresistema);
    }

    /**
     * {@inheritDoc}
     */
    public function getNombresistema()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getNombresistema', []);

        return parent::getNombresistema();
    }

    /**
     * {@inheritDoc}
     */
    public function setUsuariocontpaq($usuariocontpaq)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setUsuariocontpaq', [$usuariocontpaq]);

        return parent::setUsuariocontpaq($usuariocontpaq);
    }

    /**
     * {@inheritDoc}
     */
    public function getUsuariocontpaq()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getUsuariocontpaq', []);

        return parent::getUsuariocontpaq();
    }

    /**
     * {@inheritDoc}
     */
    public function setPassworcontpaq($passworcontpaq)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setPassworcontpaq', [$passworcontpaq]);

        return parent::setPassworcontpaq($passworcontpaq);
    }

    /**
     * {@inheritDoc}
     */
    public function getPassworcontpaq()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getPassworcontpaq', []);

        return parent::getPassworcontpaq();
    }

    /**
     * {@inheritDoc}
     */
    public function setPasswordtimbrado($passwordtimbrado)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setPasswordtimbrado', [$passwordtimbrado]);

        return parent::setPasswordtimbrado($passwordtimbrado);
    }

    /**
     * {@inheritDoc}
     */
    public function getPasswordtimbrado()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getPasswordtimbrado', []);

        return parent::getPasswordtimbrado();
    }

    /**
     * {@inheritDoc}
     */
    public function setRutareportepdfxml($rutareportepdfxml)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setRutareportepdfxml', [$rutareportepdfxml]);

        return parent::setRutareportepdfxml($rutareportepdfxml);
    }

    /**
     * {@inheritDoc}
     */
    public function getRutareportepdfxml()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getRutareportepdfxml', []);

        return parent::getRutareportepdfxml();
    }

    /**
     * {@inheritDoc}
     */
    public function setRutaempresa($rutaempresa)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setRutaempresa', [$rutaempresa]);

        return parent::setRutaempresa($rutaempresa);
    }

    /**
     * {@inheritDoc}
     */
    public function getRutaempresa()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getRutaempresa', []);

        return parent::getRutaempresa();
    }

    /**
     * {@inheritDoc}
     */
    public function setRutaservidorxmlpdf($rutaservidorxmlpdf)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setRutaservidorxmlpdf', [$rutaservidorxmlpdf]);

        return parent::setRutaservidorxmlpdf($rutaservidorxmlpdf);
    }

    /**
     * {@inheritDoc}
     */
    public function getRutaservidorxmlpdf()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getRutaservidorxmlpdf', []);

        return parent::getRutaservidorxmlpdf();
    }

    /**
     * {@inheritDoc}
     */
    public function setRutalocalxmlpdf($rutalocalxmlpdf)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setRutalocalxmlpdf', [$rutalocalxmlpdf]);

        return parent::setRutalocalxmlpdf($rutalocalxmlpdf);
    }

    /**
     * {@inheritDoc}
     */
    public function getRutalocalxmlpdf()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getRutalocalxmlpdf', []);

        return parent::getRutalocalxmlpdf();
    }

    /**
     * {@inheritDoc}
     */
    public function setRegistrowindows($registrowindows)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setRegistrowindows', [$registrowindows]);

        return parent::setRegistrowindows($registrowindows);
    }

    /**
     * {@inheritDoc}
     */
    public function getRegistrowindows()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getRegistrowindows', []);

        return parent::getRegistrowindows();
    }

    /**
     * {@inheritDoc}
     */
    public function getEmpresaid()
    {
        if ($this->__isInitialized__ === false) {
            return (int)  parent::getEmpresaid();
        }


        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getEmpresaid', []);

        return parent::getEmpresaid();
    }

}