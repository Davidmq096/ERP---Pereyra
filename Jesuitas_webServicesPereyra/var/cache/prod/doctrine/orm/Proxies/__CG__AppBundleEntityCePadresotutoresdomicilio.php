<?php

namespace Proxies\__CG__\AppBundle\Entity;

/**
 * DO NOT EDIT THIS FILE - IT WAS CREATED BY DOCTRINE'S PROXY GENERATOR
 */
class CePadresotutoresdomicilio extends \AppBundle\Entity\CePadresotutoresdomicilio implements \Doctrine\ORM\Proxy\Proxy
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
            return ['__isInitialized__', '' . "\0" . 'AppBundle\\Entity\\CePadresotutoresdomicilio' . "\0" . 'calle', '' . "\0" . 'AppBundle\\Entity\\CePadresotutoresdomicilio' . "\0" . 'numeroexterior', '' . "\0" . 'AppBundle\\Entity\\CePadresotutoresdomicilio' . "\0" . 'numerointerior', '' . "\0" . 'AppBundle\\Entity\\CePadresotutoresdomicilio' . "\0" . 'colonia', '' . "\0" . 'AppBundle\\Entity\\CePadresotutoresdomicilio' . "\0" . 'ciudad', '' . "\0" . 'AppBundle\\Entity\\CePadresotutoresdomicilio' . "\0" . 'codigopostal', '' . "\0" . 'AppBundle\\Entity\\CePadresotutoresdomicilio' . "\0" . 'observaciones', '' . "\0" . 'AppBundle\\Entity\\CePadresotutoresdomicilio' . "\0" . 'padresotutoresdomicilioid', '' . "\0" . 'AppBundle\\Entity\\CePadresotutoresdomicilio' . "\0" . 'padresotutoresid'];
        }

        return ['__isInitialized__', '' . "\0" . 'AppBundle\\Entity\\CePadresotutoresdomicilio' . "\0" . 'calle', '' . "\0" . 'AppBundle\\Entity\\CePadresotutoresdomicilio' . "\0" . 'numeroexterior', '' . "\0" . 'AppBundle\\Entity\\CePadresotutoresdomicilio' . "\0" . 'numerointerior', '' . "\0" . 'AppBundle\\Entity\\CePadresotutoresdomicilio' . "\0" . 'colonia', '' . "\0" . 'AppBundle\\Entity\\CePadresotutoresdomicilio' . "\0" . 'ciudad', '' . "\0" . 'AppBundle\\Entity\\CePadresotutoresdomicilio' . "\0" . 'codigopostal', '' . "\0" . 'AppBundle\\Entity\\CePadresotutoresdomicilio' . "\0" . 'observaciones', '' . "\0" . 'AppBundle\\Entity\\CePadresotutoresdomicilio' . "\0" . 'padresotutoresdomicilioid', '' . "\0" . 'AppBundle\\Entity\\CePadresotutoresdomicilio' . "\0" . 'padresotutoresid'];
    }

    /**
     * 
     */
    public function __wakeup()
    {
        if ( ! $this->__isInitialized__) {
            $this->__initializer__ = function (CePadresotutoresdomicilio $proxy) {
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
    public function setCalle($calle)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setCalle', [$calle]);

        return parent::setCalle($calle);
    }

    /**
     * {@inheritDoc}
     */
    public function getCalle()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getCalle', []);

        return parent::getCalle();
    }

    /**
     * {@inheritDoc}
     */
    public function setNumeroexterior($numeroexterior)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setNumeroexterior', [$numeroexterior]);

        return parent::setNumeroexterior($numeroexterior);
    }

    /**
     * {@inheritDoc}
     */
    public function getNumeroexterior()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getNumeroexterior', []);

        return parent::getNumeroexterior();
    }

    /**
     * {@inheritDoc}
     */
    public function setNumerointerior($numerointerior)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setNumerointerior', [$numerointerior]);

        return parent::setNumerointerior($numerointerior);
    }

    /**
     * {@inheritDoc}
     */
    public function getNumerointerior()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getNumerointerior', []);

        return parent::getNumerointerior();
    }

    /**
     * {@inheritDoc}
     */
    public function setColonia($colonia)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setColonia', [$colonia]);

        return parent::setColonia($colonia);
    }

    /**
     * {@inheritDoc}
     */
    public function getColonia()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getColonia', []);

        return parent::getColonia();
    }

    /**
     * {@inheritDoc}
     */
    public function setCiudad($ciudad)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setCiudad', [$ciudad]);

        return parent::setCiudad($ciudad);
    }

    /**
     * {@inheritDoc}
     */
    public function getCiudad()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getCiudad', []);

        return parent::getCiudad();
    }

    /**
     * {@inheritDoc}
     */
    public function setCodigopostal($codigopostal)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setCodigopostal', [$codigopostal]);

        return parent::setCodigopostal($codigopostal);
    }

    /**
     * {@inheritDoc}
     */
    public function getCodigopostal()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getCodigopostal', []);

        return parent::getCodigopostal();
    }

    /**
     * {@inheritDoc}
     */
    public function setObservaciones($observaciones)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setObservaciones', [$observaciones]);

        return parent::setObservaciones($observaciones);
    }

    /**
     * {@inheritDoc}
     */
    public function getObservaciones()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getObservaciones', []);

        return parent::getObservaciones();
    }

    /**
     * {@inheritDoc}
     */
    public function getPadresotutoresdomicilioid()
    {
        if ($this->__isInitialized__ === false) {
            return (int)  parent::getPadresotutoresdomicilioid();
        }


        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getPadresotutoresdomicilioid', []);

        return parent::getPadresotutoresdomicilioid();
    }

    /**
     * {@inheritDoc}
     */
    public function setPadresotutoresid(\AppBundle\Entity\CePadresotutores $padresotutoresid = NULL)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setPadresotutoresid', [$padresotutoresid]);

        return parent::setPadresotutoresid($padresotutoresid);
    }

    /**
     * {@inheritDoc}
     */
    public function getPadresotutoresid()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getPadresotutoresid', []);

        return parent::getPadresotutoresid();
    }

}
