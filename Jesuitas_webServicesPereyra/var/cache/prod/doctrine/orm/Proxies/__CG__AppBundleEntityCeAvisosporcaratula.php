<?php

namespace Proxies\__CG__\AppBundle\Entity;

/**
 * DO NOT EDIT THIS FILE - IT WAS CREATED BY DOCTRINE'S PROXY GENERATOR
 */
class CeAvisosporcaratula extends \AppBundle\Entity\CeAvisosporcaratula implements \Doctrine\ORM\Proxy\Proxy
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
            return ['__isInitialized__', '' . "\0" . 'AppBundle\\Entity\\CeAvisosporcaratula' . "\0" . 'descripcion', '' . "\0" . 'AppBundle\\Entity\\CeAvisosporcaratula' . "\0" . 'fecha', '' . "\0" . 'AppBundle\\Entity\\CeAvisosporcaratula' . "\0" . 'hora', '' . "\0" . 'AppBundle\\Entity\\CeAvisosporcaratula' . "\0" . 'avisocaratulaid', '' . "\0" . 'AppBundle\\Entity\\CeAvisosporcaratula' . "\0" . 'avisocaratulaestatusid', '' . "\0" . 'AppBundle\\Entity\\CeAvisosporcaratula' . "\0" . 'caratulaid'];
        }

        return ['__isInitialized__', '' . "\0" . 'AppBundle\\Entity\\CeAvisosporcaratula' . "\0" . 'descripcion', '' . "\0" . 'AppBundle\\Entity\\CeAvisosporcaratula' . "\0" . 'fecha', '' . "\0" . 'AppBundle\\Entity\\CeAvisosporcaratula' . "\0" . 'hora', '' . "\0" . 'AppBundle\\Entity\\CeAvisosporcaratula' . "\0" . 'avisocaratulaid', '' . "\0" . 'AppBundle\\Entity\\CeAvisosporcaratula' . "\0" . 'avisocaratulaestatusid', '' . "\0" . 'AppBundle\\Entity\\CeAvisosporcaratula' . "\0" . 'caratulaid'];
    }

    /**
     * 
     */
    public function __wakeup()
    {
        if ( ! $this->__isInitialized__) {
            $this->__initializer__ = function (CeAvisosporcaratula $proxy) {
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
    public function setHora($hora)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setHora', [$hora]);

        return parent::setHora($hora);
    }

    /**
     * {@inheritDoc}
     */
    public function getHora()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getHora', []);

        return parent::getHora();
    }

    /**
     * {@inheritDoc}
     */
    public function getAvisocaratulaid()
    {
        if ($this->__isInitialized__ === false) {
            return (int)  parent::getAvisocaratulaid();
        }


        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getAvisocaratulaid', []);

        return parent::getAvisocaratulaid();
    }

    /**
     * {@inheritDoc}
     */
    public function setAvisocaratulaestatusid(\AppBundle\Entity\CeAvisosporcaratulaestatus $avisocaratulaestatusid = NULL)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setAvisocaratulaestatusid', [$avisocaratulaestatusid]);

        return parent::setAvisocaratulaestatusid($avisocaratulaestatusid);
    }

    /**
     * {@inheritDoc}
     */
    public function getAvisocaratulaestatusid()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getAvisocaratulaestatusid', []);

        return parent::getAvisocaratulaestatusid();
    }

    /**
     * {@inheritDoc}
     */
    public function setCaratulaid(\AppBundle\Entity\CeCaratula $caratulaid = NULL)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setCaratulaid', [$caratulaid]);

        return parent::setCaratulaid($caratulaid);
    }

    /**
     * {@inheritDoc}
     */
    public function getCaratulaid()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getCaratulaid', []);

        return parent::getCaratulaid();
    }

}
