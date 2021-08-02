<?php

namespace Proxies\__CG__\AppBundle\Entity;

/**
 * DO NOT EDIT THIS FILE - IT WAS CREATED BY DOCTRINE'S PROXY GENERATOR
 */
class CeConductacalificacionescala extends \AppBundle\Entity\CeConductacalificacionescala implements \Doctrine\ORM\Proxy\Proxy
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
            return ['__isInitialized__', '' . "\0" . 'AppBundle\\Entity\\CeConductacalificacionescala' . "\0" . 'minimo', '' . "\0" . 'AppBundle\\Entity\\CeConductacalificacionescala' . "\0" . 'maximo', '' . "\0" . 'AppBundle\\Entity\\CeConductacalificacionescala' . "\0" . 'resultado', '' . "\0" . 'AppBundle\\Entity\\CeConductacalificacionescala' . "\0" . 'conductacalificacionescalaid'];
        }

        return ['__isInitialized__', '' . "\0" . 'AppBundle\\Entity\\CeConductacalificacionescala' . "\0" . 'minimo', '' . "\0" . 'AppBundle\\Entity\\CeConductacalificacionescala' . "\0" . 'maximo', '' . "\0" . 'AppBundle\\Entity\\CeConductacalificacionescala' . "\0" . 'resultado', '' . "\0" . 'AppBundle\\Entity\\CeConductacalificacionescala' . "\0" . 'conductacalificacionescalaid'];
    }

    /**
     * 
     */
    public function __wakeup()
    {
        if ( ! $this->__isInitialized__) {
            $this->__initializer__ = function (CeConductacalificacionescala $proxy) {
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
    public function setMinimo($minimo)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setMinimo', [$minimo]);

        return parent::setMinimo($minimo);
    }

    /**
     * {@inheritDoc}
     */
    public function getMinimo()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getMinimo', []);

        return parent::getMinimo();
    }

    /**
     * {@inheritDoc}
     */
    public function setMaximo($maximo)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setMaximo', [$maximo]);

        return parent::setMaximo($maximo);
    }

    /**
     * {@inheritDoc}
     */
    public function getMaximo()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getMaximo', []);

        return parent::getMaximo();
    }

    /**
     * {@inheritDoc}
     */
    public function setResultado($resultado)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setResultado', [$resultado]);

        return parent::setResultado($resultado);
    }

    /**
     * {@inheritDoc}
     */
    public function getResultado()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getResultado', []);

        return parent::getResultado();
    }

    /**
     * {@inheritDoc}
     */
    public function getConductacalificacionescalaid()
    {
        if ($this->__isInitialized__ === false) {
            return (int)  parent::getConductacalificacionescalaid();
        }


        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getConductacalificacionescalaid', []);

        return parent::getConductacalificacionescalaid();
    }

}