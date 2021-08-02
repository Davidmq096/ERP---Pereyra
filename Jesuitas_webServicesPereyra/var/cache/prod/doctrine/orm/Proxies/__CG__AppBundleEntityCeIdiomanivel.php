<?php

namespace Proxies\__CG__\AppBundle\Entity;

/**
 * DO NOT EDIT THIS FILE - IT WAS CREATED BY DOCTRINE'S PROXY GENERATOR
 */
class CeIdiomanivel extends \AppBundle\Entity\CeIdiomanivel implements \Doctrine\ORM\Proxy\Proxy
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
            return ['__isInitialized__', '' . "\0" . 'AppBundle\\Entity\\CeIdiomanivel' . "\0" . 'nombre', '' . "\0" . 'AppBundle\\Entity\\CeIdiomanivel' . "\0" . 'orden', '' . "\0" . 'AppBundle\\Entity\\CeIdiomanivel' . "\0" . 'clave', '' . "\0" . 'AppBundle\\Entity\\CeIdiomanivel' . "\0" . 'activo', '' . "\0" . 'AppBundle\\Entity\\CeIdiomanivel' . "\0" . 'idiomanivelid', '' . "\0" . 'AppBundle\\Entity\\CeIdiomanivel' . "\0" . 'idiomaid'];
        }

        return ['__isInitialized__', '' . "\0" . 'AppBundle\\Entity\\CeIdiomanivel' . "\0" . 'nombre', '' . "\0" . 'AppBundle\\Entity\\CeIdiomanivel' . "\0" . 'orden', '' . "\0" . 'AppBundle\\Entity\\CeIdiomanivel' . "\0" . 'clave', '' . "\0" . 'AppBundle\\Entity\\CeIdiomanivel' . "\0" . 'activo', '' . "\0" . 'AppBundle\\Entity\\CeIdiomanivel' . "\0" . 'idiomanivelid', '' . "\0" . 'AppBundle\\Entity\\CeIdiomanivel' . "\0" . 'idiomaid'];
    }

    /**
     * 
     */
    public function __wakeup()
    {
        if ( ! $this->__isInitialized__) {
            $this->__initializer__ = function (CeIdiomanivel $proxy) {
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
    public function setOrden($orden)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setOrden', [$orden]);

        return parent::setOrden($orden);
    }

    /**
     * {@inheritDoc}
     */
    public function getOrden()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getOrden', []);

        return parent::getOrden();
    }

    /**
     * {@inheritDoc}
     */
    public function setClave($clave)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setClave', [$clave]);

        return parent::setClave($clave);
    }

    /**
     * {@inheritDoc}
     */
    public function getClave()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getClave', []);

        return parent::getClave();
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
    public function getIdiomanivelid()
    {
        if ($this->__isInitialized__ === false) {
            return (int)  parent::getIdiomanivelid();
        }


        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getIdiomanivelid', []);

        return parent::getIdiomanivelid();
    }

    /**
     * {@inheritDoc}
     */
    public function setIdiomaid(\AppBundle\Entity\CeIdioma $idiomaid = NULL)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setIdiomaid', [$idiomaid]);

        return parent::setIdiomaid($idiomaid);
    }

    /**
     * {@inheritDoc}
     */
    public function getIdiomaid()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getIdiomaid', []);

        return parent::getIdiomaid();
    }

}