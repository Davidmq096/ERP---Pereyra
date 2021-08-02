<?php

namespace Proxies\__CG__\AppBundle\Entity;

/**
 * DO NOT EDIT THIS FILE - IT WAS CREATED BY DOCTRINE'S PROXY GENERATOR
 */
class CjCheque extends \AppBundle\Entity\CjCheque implements \Doctrine\ORM\Proxy\Proxy
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
            return ['__isInitialized__', '' . "\0" . 'AppBundle\\Entity\\CjCheque' . "\0" . 'folio', '' . "\0" . 'AppBundle\\Entity\\CjCheque' . "\0" . 'cuenta', '' . "\0" . 'AppBundle\\Entity\\CjCheque' . "\0" . 'fecha', '' . "\0" . 'AppBundle\\Entity\\CjCheque' . "\0" . 'importe', '' . "\0" . 'AppBundle\\Entity\\CjCheque' . "\0" . 'observaciones', '' . "\0" . 'AppBundle\\Entity\\CjCheque' . "\0" . 'chequeid', '' . "\0" . 'AppBundle\\Entity\\CjCheque' . "\0" . 'alumnoid', '' . "\0" . 'AppBundle\\Entity\\CjCheque' . "\0" . 'bancoid', '' . "\0" . 'AppBundle\\Entity\\CjCheque' . "\0" . 'pagoformapagoid', '' . "\0" . 'AppBundle\\Entity\\CjCheque' . "\0" . 'solicitudadmisionid'];
        }

        return ['__isInitialized__', '' . "\0" . 'AppBundle\\Entity\\CjCheque' . "\0" . 'folio', '' . "\0" . 'AppBundle\\Entity\\CjCheque' . "\0" . 'cuenta', '' . "\0" . 'AppBundle\\Entity\\CjCheque' . "\0" . 'fecha', '' . "\0" . 'AppBundle\\Entity\\CjCheque' . "\0" . 'importe', '' . "\0" . 'AppBundle\\Entity\\CjCheque' . "\0" . 'observaciones', '' . "\0" . 'AppBundle\\Entity\\CjCheque' . "\0" . 'chequeid', '' . "\0" . 'AppBundle\\Entity\\CjCheque' . "\0" . 'alumnoid', '' . "\0" . 'AppBundle\\Entity\\CjCheque' . "\0" . 'bancoid', '' . "\0" . 'AppBundle\\Entity\\CjCheque' . "\0" . 'pagoformapagoid', '' . "\0" . 'AppBundle\\Entity\\CjCheque' . "\0" . 'solicitudadmisionid'];
    }

    /**
     * 
     */
    public function __wakeup()
    {
        if ( ! $this->__isInitialized__) {
            $this->__initializer__ = function (CjCheque $proxy) {
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
    public function setFolio($folio)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setFolio', [$folio]);

        return parent::setFolio($folio);
    }

    /**
     * {@inheritDoc}
     */
    public function getFolio()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getFolio', []);

        return parent::getFolio();
    }

    /**
     * {@inheritDoc}
     */
    public function setCuenta($cuenta)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setCuenta', [$cuenta]);

        return parent::setCuenta($cuenta);
    }

    /**
     * {@inheritDoc}
     */
    public function getCuenta()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getCuenta', []);

        return parent::getCuenta();
    }

    /**
     * {@inheritDoc}
     */
    public function setFecha($fecha)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setFecha', [$fecha]);

        return parent::setFecha($fecha);
    }

    /**
     * {@inheritDoc}
     */
    public function getFecha()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getFecha', []);

        return parent::getFecha();
    }

    /**
     * {@inheritDoc}
     */
    public function setImporte($importe)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setImporte', [$importe]);

        return parent::setImporte($importe);
    }

    /**
     * {@inheritDoc}
     */
    public function getImporte()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getImporte', []);

        return parent::getImporte();
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
    public function getChequeid()
    {
        if ($this->__isInitialized__ === false) {
            return (int)  parent::getChequeid();
        }


        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getChequeid', []);

        return parent::getChequeid();
    }

    /**
     * {@inheritDoc}
     */
    public function setAlumnoid(\AppBundle\Entity\CeAlumno $alumnoid = NULL)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setAlumnoid', [$alumnoid]);

        return parent::setAlumnoid($alumnoid);
    }

    /**
     * {@inheritDoc}
     */
    public function getAlumnoid()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getAlumnoid', []);

        return parent::getAlumnoid();
    }

    /**
     * {@inheritDoc}
     */
    public function setBancoid(\AppBundle\Entity\CjBanco $bancoid = NULL)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setBancoid', [$bancoid]);

        return parent::setBancoid($bancoid);
    }

    /**
     * {@inheritDoc}
     */
    public function getBancoid()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getBancoid', []);

        return parent::getBancoid();
    }

    /**
     * {@inheritDoc}
     */
    public function setPagoformapagoid(\AppBundle\Entity\CjPagoformapago $pagoformapagoid = NULL)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setPagoformapagoid', [$pagoformapagoid]);

        return parent::setPagoformapagoid($pagoformapagoid);
    }

    /**
     * {@inheritDoc}
     */
    public function getPagoformapagoid()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getPagoformapagoid', []);

        return parent::getPagoformapagoid();
    }

    /**
     * {@inheritDoc}
     */
    public function setSolicitudadmisionid(\AppBundle\Entity\Solicitudadmision $solicitudadmisionid = NULL)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setSolicitudadmisionid', [$solicitudadmisionid]);

        return parent::setSolicitudadmisionid($solicitudadmisionid);
    }

    /**
     * {@inheritDoc}
     */
    public function getSolicitudadmisionid()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getSolicitudadmisionid', []);

        return parent::getSolicitudadmisionid();
    }

}
