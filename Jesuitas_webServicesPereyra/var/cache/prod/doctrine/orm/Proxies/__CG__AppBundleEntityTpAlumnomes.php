<?php

namespace Proxies\__CG__\AppBundle\Entity;

/**
 * DO NOT EDIT THIS FILE - IT WAS CREATED BY DOCTRINE'S PROXY GENERATOR
 */
class TpAlumnomes extends \AppBundle\Entity\TpAlumnomes implements \Doctrine\ORM\Proxy\Proxy
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
            return ['__isInitialized__', '' . "\0" . 'AppBundle\\Entity\\TpAlumnomes' . "\0" . 'year', '' . "\0" . 'AppBundle\\Entity\\TpAlumnomes' . "\0" . 'month', '' . "\0" . 'AppBundle\\Entity\\TpAlumnomes' . "\0" . 'alumnomesid', '' . "\0" . 'AppBundle\\Entity\\TpAlumnomes' . "\0" . 'alumnoid', '' . "\0" . 'AppBundle\\Entity\\TpAlumnomes' . "\0" . 'contratoid'];
        }

        return ['__isInitialized__', '' . "\0" . 'AppBundle\\Entity\\TpAlumnomes' . "\0" . 'year', '' . "\0" . 'AppBundle\\Entity\\TpAlumnomes' . "\0" . 'month', '' . "\0" . 'AppBundle\\Entity\\TpAlumnomes' . "\0" . 'alumnomesid', '' . "\0" . 'AppBundle\\Entity\\TpAlumnomes' . "\0" . 'alumnoid', '' . "\0" . 'AppBundle\\Entity\\TpAlumnomes' . "\0" . 'contratoid'];
    }

    /**
     * 
     */
    public function __wakeup()
    {
        if ( ! $this->__isInitialized__) {
            $this->__initializer__ = function (TpAlumnomes $proxy) {
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
    public function setYear($year)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setYear', [$year]);

        return parent::setYear($year);
    }

    /**
     * {@inheritDoc}
     */
    public function getYear()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getYear', []);

        return parent::getYear();
    }

    /**
     * {@inheritDoc}
     */
    public function setMonth($month)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setMonth', [$month]);

        return parent::setMonth($month);
    }

    /**
     * {@inheritDoc}
     */
    public function getMonth()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getMonth', []);

        return parent::getMonth();
    }

    /**
     * {@inheritDoc}
     */
    public function getAlumnomesid()
    {
        if ($this->__isInitialized__ === false) {
            return (int)  parent::getAlumnomesid();
        }


        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getAlumnomesid', []);

        return parent::getAlumnomesid();
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
    public function setContratoid(\AppBundle\Entity\TpContrato $contratoid = NULL)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setContratoid', [$contratoid]);

        return parent::setContratoid($contratoid);
    }

    /**
     * {@inheritDoc}
     */
    public function getContratoid()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getContratoid', []);

        return parent::getContratoid();
    }

}
