<?php

namespace Proxies\__CG__\AppBundle\Entity;

/**
 * DO NOT EDIT THIS FILE - IT WAS CREATED BY DOCTRINE'S PROXY GENERATOR
 */
class CeTallerextraopcionregistro extends \AppBundle\Entity\CeTallerextraopcionregistro implements \Doctrine\ORM\Proxy\Proxy
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
            return ['__isInitialized__', '' . "\0" . 'AppBundle\\Entity\\CeTallerextraopcionregistro' . "\0" . 'tipopago', '' . "\0" . 'AppBundle\\Entity\\CeTallerextraopcionregistro' . "\0" . 'notalleres', '' . "\0" . 'AppBundle\\Entity\\CeTallerextraopcionregistro' . "\0" . 'tallerextraopcionregistroid', '' . "\0" . 'AppBundle\\Entity\\CeTallerextraopcionregistro' . "\0" . 'frecuenciapagoid', '' . "\0" . 'AppBundle\\Entity\\CeTallerextraopcionregistro' . "\0" . 'gradoid'];
        }

        return ['__isInitialized__', '' . "\0" . 'AppBundle\\Entity\\CeTallerextraopcionregistro' . "\0" . 'tipopago', '' . "\0" . 'AppBundle\\Entity\\CeTallerextraopcionregistro' . "\0" . 'notalleres', '' . "\0" . 'AppBundle\\Entity\\CeTallerextraopcionregistro' . "\0" . 'tallerextraopcionregistroid', '' . "\0" . 'AppBundle\\Entity\\CeTallerextraopcionregistro' . "\0" . 'frecuenciapagoid', '' . "\0" . 'AppBundle\\Entity\\CeTallerextraopcionregistro' . "\0" . 'gradoid'];
    }

    /**
     * 
     */
    public function __wakeup()
    {
        if ( ! $this->__isInitialized__) {
            $this->__initializer__ = function (CeTallerextraopcionregistro $proxy) {
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
    public function setTipopago($tipopago)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setTipopago', [$tipopago]);

        return parent::setTipopago($tipopago);
    }

    /**
     * {@inheritDoc}
     */
    public function getTipopago()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getTipopago', []);

        return parent::getTipopago();
    }

    /**
     * {@inheritDoc}
     */
    public function setNotalleres($notalleres)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setNotalleres', [$notalleres]);

        return parent::setNotalleres($notalleres);
    }

    /**
     * {@inheritDoc}
     */
    public function getNotalleres()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getNotalleres', []);

        return parent::getNotalleres();
    }

    /**
     * {@inheritDoc}
     */
    public function getTallerextraopcionregistroid()
    {
        if ($this->__isInitialized__ === false) {
            return (int)  parent::getTallerextraopcionregistroid();
        }


        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getTallerextraopcionregistroid', []);

        return parent::getTallerextraopcionregistroid();
    }

    /**
     * {@inheritDoc}
     */
    public function setFrecuenciapagoid(\AppBundle\Entity\CeTallerfrecuenciapago $frecuenciapagoid = NULL)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setFrecuenciapagoid', [$frecuenciapagoid]);

        return parent::setFrecuenciapagoid($frecuenciapagoid);
    }

    /**
     * {@inheritDoc}
     */
    public function getFrecuenciapagoid()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getFrecuenciapagoid', []);

        return parent::getFrecuenciapagoid();
    }

    /**
     * {@inheritDoc}
     */
    public function setGradoid(\AppBundle\Entity\Grado $gradoid = NULL)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setGradoid', [$gradoid]);

        return parent::setGradoid($gradoid);
    }

    /**
     * {@inheritDoc}
     */
    public function getGradoid()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getGradoid', []);

        return parent::getGradoid();
    }

}
