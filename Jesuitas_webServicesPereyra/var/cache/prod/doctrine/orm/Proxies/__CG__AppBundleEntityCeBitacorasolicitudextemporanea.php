<?php

namespace Proxies\__CG__\AppBundle\Entity;

/**
 * DO NOT EDIT THIS FILE - IT WAS CREATED BY DOCTRINE'S PROXY GENERATOR
 */
class CeBitacorasolicitudextemporanea extends \AppBundle\Entity\CeBitacorasolicitudextemporanea implements \Doctrine\ORM\Proxy\Proxy
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
            return ['__isInitialized__', '' . "\0" . 'AppBundle\\Entity\\CeBitacorasolicitudextemporanea' . "\0" . 'fecha', '' . "\0" . 'AppBundle\\Entity\\CeBitacorasolicitudextemporanea' . "\0" . 'estatus', '' . "\0" . 'AppBundle\\Entity\\CeBitacorasolicitudextemporanea' . "\0" . 'usuario', '' . "\0" . 'AppBundle\\Entity\\CeBitacorasolicitudextemporanea' . "\0" . 'observaciones', '' . "\0" . 'AppBundle\\Entity\\CeBitacorasolicitudextemporanea' . "\0" . 'bitacorasolicitudextemporaneaid', '' . "\0" . 'AppBundle\\Entity\\CeBitacorasolicitudextemporanea' . "\0" . 'solicitudedicionextemporaneaid'];
        }

        return ['__isInitialized__', '' . "\0" . 'AppBundle\\Entity\\CeBitacorasolicitudextemporanea' . "\0" . 'fecha', '' . "\0" . 'AppBundle\\Entity\\CeBitacorasolicitudextemporanea' . "\0" . 'estatus', '' . "\0" . 'AppBundle\\Entity\\CeBitacorasolicitudextemporanea' . "\0" . 'usuario', '' . "\0" . 'AppBundle\\Entity\\CeBitacorasolicitudextemporanea' . "\0" . 'observaciones', '' . "\0" . 'AppBundle\\Entity\\CeBitacorasolicitudextemporanea' . "\0" . 'bitacorasolicitudextemporaneaid', '' . "\0" . 'AppBundle\\Entity\\CeBitacorasolicitudextemporanea' . "\0" . 'solicitudedicionextemporaneaid'];
    }

    /**
     * 
     */
    public function __wakeup()
    {
        if ( ! $this->__isInitialized__) {
            $this->__initializer__ = function (CeBitacorasolicitudextemporanea $proxy) {
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
    public function setEstatus($estatus)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setEstatus', [$estatus]);

        return parent::setEstatus($estatus);
    }

    /**
     * {@inheritDoc}
     */
    public function getEstatus()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getEstatus', []);

        return parent::getEstatus();
    }

    /**
     * {@inheritDoc}
     */
    public function setUsuario($usuario)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setUsuario', [$usuario]);

        return parent::setUsuario($usuario);
    }

    /**
     * {@inheritDoc}
     */
    public function getUsuario()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getUsuario', []);

        return parent::getUsuario();
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
    public function getBitacorasolicitudextemporaneaid()
    {
        if ($this->__isInitialized__ === false) {
            return (int)  parent::getBitacorasolicitudextemporaneaid();
        }


        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getBitacorasolicitudextemporaneaid', []);

        return parent::getBitacorasolicitudextemporaneaid();
    }

    /**
     * {@inheritDoc}
     */
    public function setSolicitudedicionextemporaneaid(\AppBundle\Entity\CeSolicitudedicionextemporanea $solicitudedicionextemporaneaid = NULL)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setSolicitudedicionextemporaneaid', [$solicitudedicionextemporaneaid]);

        return parent::setSolicitudedicionextemporaneaid($solicitudedicionextemporaneaid);
    }

    /**
     * {@inheritDoc}
     */
    public function getSolicitudedicionextemporaneaid()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getSolicitudedicionextemporaneaid', []);

        return parent::getSolicitudedicionextemporaneaid();
    }

}