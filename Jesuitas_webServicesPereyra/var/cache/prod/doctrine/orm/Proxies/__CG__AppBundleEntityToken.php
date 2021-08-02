<?php

namespace Proxies\__CG__\AppBundle\Entity;

/**
 * DO NOT EDIT THIS FILE - IT WAS CREATED BY DOCTRINE'S PROXY GENERATOR
 */
class Token extends \AppBundle\Entity\Token implements \Doctrine\ORM\Proxy\Proxy
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
            return ['__isInitialized__', '' . "\0" . 'AppBundle\\Entity\\Token' . "\0" . 'descripcion', '' . "\0" . 'AppBundle\\Entity\\Token' . "\0" . 'token', '' . "\0" . 'AppBundle\\Entity\\Token' . "\0" . 'preescolar', '' . "\0" . 'AppBundle\\Entity\\Token' . "\0" . 'primaria', '' . "\0" . 'AppBundle\\Entity\\Token' . "\0" . 'secundaria', '' . "\0" . 'AppBundle\\Entity\\Token' . "\0" . 'bachillerato', '' . "\0" . 'AppBundle\\Entity\\Token' . "\0" . 'tokenid'];
        }

        return ['__isInitialized__', '' . "\0" . 'AppBundle\\Entity\\Token' . "\0" . 'descripcion', '' . "\0" . 'AppBundle\\Entity\\Token' . "\0" . 'token', '' . "\0" . 'AppBundle\\Entity\\Token' . "\0" . 'preescolar', '' . "\0" . 'AppBundle\\Entity\\Token' . "\0" . 'primaria', '' . "\0" . 'AppBundle\\Entity\\Token' . "\0" . 'secundaria', '' . "\0" . 'AppBundle\\Entity\\Token' . "\0" . 'bachillerato', '' . "\0" . 'AppBundle\\Entity\\Token' . "\0" . 'tokenid'];
    }

    /**
     * 
     */
    public function __wakeup()
    {
        if ( ! $this->__isInitialized__) {
            $this->__initializer__ = function (Token $proxy) {
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
    public function setDescripcion($descripcion)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setDescripcion', [$descripcion]);

        return parent::setDescripcion($descripcion);
    }

    /**
     * {@inheritDoc}
     */
    public function getDescripcion()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getDescripcion', []);

        return parent::getDescripcion();
    }

    /**
     * {@inheritDoc}
     */
    public function setToken($token)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setToken', [$token]);

        return parent::setToken($token);
    }

    /**
     * {@inheritDoc}
     */
    public function getToken()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getToken', []);

        return parent::getToken();
    }

    /**
     * {@inheritDoc}
     */
    public function setPreescolar($preescolar)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setPreescolar', [$preescolar]);

        return parent::setPreescolar($preescolar);
    }

    /**
     * {@inheritDoc}
     */
    public function getPreescolar()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getPreescolar', []);

        return parent::getPreescolar();
    }

    /**
     * {@inheritDoc}
     */
    public function setPrimaria($primaria)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setPrimaria', [$primaria]);

        return parent::setPrimaria($primaria);
    }

    /**
     * {@inheritDoc}
     */
    public function getPrimaria()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getPrimaria', []);

        return parent::getPrimaria();
    }

    /**
     * {@inheritDoc}
     */
    public function setSecundaria($secundaria)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setSecundaria', [$secundaria]);

        return parent::setSecundaria($secundaria);
    }

    /**
     * {@inheritDoc}
     */
    public function getSecundaria()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getSecundaria', []);

        return parent::getSecundaria();
    }

    /**
     * {@inheritDoc}
     */
    public function setBachillerato($bachillerato)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setBachillerato', [$bachillerato]);

        return parent::setBachillerato($bachillerato);
    }

    /**
     * {@inheritDoc}
     */
    public function getBachillerato()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getBachillerato', []);

        return parent::getBachillerato();
    }

    /**
     * {@inheritDoc}
     */
    public function getTokenid()
    {
        if ($this->__isInitialized__ === false) {
            return (int)  parent::getTokenid();
        }


        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getTokenid', []);

        return parent::getTokenid();
    }

}