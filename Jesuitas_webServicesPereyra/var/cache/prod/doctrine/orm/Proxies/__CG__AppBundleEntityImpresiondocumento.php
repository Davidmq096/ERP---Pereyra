<?php

namespace Proxies\__CG__\AppBundle\Entity;

/**
 * DO NOT EDIT THIS FILE - IT WAS CREATED BY DOCTRINE'S PROXY GENERATOR
 */
class Impresiondocumento extends \AppBundle\Entity\Impresiondocumento implements \Doctrine\ORM\Proxy\Proxy
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
            return ['__isInitialized__', '' . "\0" . 'AppBundle\\Entity\\Impresiondocumento' . "\0" . 'fecharegistro', '' . "\0" . 'AppBundle\\Entity\\Impresiondocumento' . "\0" . 'impresiondocumentoid', '' . "\0" . 'AppBundle\\Entity\\Impresiondocumento' . "\0" . 'formatoid', '' . "\0" . 'AppBundle\\Entity\\Impresiondocumento' . "\0" . 'solicitudadmisionid', '' . "\0" . 'AppBundle\\Entity\\Impresiondocumento' . "\0" . 'usuarioid'];
        }

        return ['__isInitialized__', '' . "\0" . 'AppBundle\\Entity\\Impresiondocumento' . "\0" . 'fecharegistro', '' . "\0" . 'AppBundle\\Entity\\Impresiondocumento' . "\0" . 'impresiondocumentoid', '' . "\0" . 'AppBundle\\Entity\\Impresiondocumento' . "\0" . 'formatoid', '' . "\0" . 'AppBundle\\Entity\\Impresiondocumento' . "\0" . 'solicitudadmisionid', '' . "\0" . 'AppBundle\\Entity\\Impresiondocumento' . "\0" . 'usuarioid'];
    }

    /**
     * 
     */
    public function __wakeup()
    {
        if ( ! $this->__isInitialized__) {
            $this->__initializer__ = function (Impresiondocumento $proxy) {
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
    public function setFecharegistro($fecharegistro)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setFecharegistro', [$fecharegistro]);

        return parent::setFecharegistro($fecharegistro);
    }

    /**
     * {@inheritDoc}
     */
    public function getFecharegistro()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getFecharegistro', []);

        return parent::getFecharegistro();
    }

    /**
     * {@inheritDoc}
     */
    public function getImpresiondocumentoid()
    {
        if ($this->__isInitialized__ === false) {
            return (int)  parent::getImpresiondocumentoid();
        }


        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getImpresiondocumentoid', []);

        return parent::getImpresiondocumentoid();
    }

    /**
     * {@inheritDoc}
     */
    public function setFormatoid(\AppBundle\Entity\Formato $formatoid = NULL)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setFormatoid', [$formatoid]);

        return parent::setFormatoid($formatoid);
    }

    /**
     * {@inheritDoc}
     */
    public function getFormatoid()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getFormatoid', []);

        return parent::getFormatoid();
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

    /**
     * {@inheritDoc}
     */
    public function setUsuarioid(\AppBundle\Entity\Usuario $usuarioid = NULL)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setUsuarioid', [$usuarioid]);

        return parent::setUsuarioid($usuarioid);
    }

    /**
     * {@inheritDoc}
     */
    public function getUsuarioid()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getUsuarioid', []);

        return parent::getUsuarioid();
    }

}