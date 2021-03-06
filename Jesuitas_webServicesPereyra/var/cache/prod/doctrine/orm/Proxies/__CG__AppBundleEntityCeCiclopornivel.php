<?php

namespace Proxies\__CG__\AppBundle\Entity;

/**
 * DO NOT EDIT THIS FILE - IT WAS CREATED BY DOCTRINE'S PROXY GENERATOR
 */
class CeCiclopornivel extends \AppBundle\Entity\CeCiclopornivel implements \Doctrine\ORM\Proxy\Proxy
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
            return ['__isInitialized__', '' . "\0" . 'AppBundle\\Entity\\CeCiclopornivel' . "\0" . 'fechainicio', '' . "\0" . 'AppBundle\\Entity\\CeCiclopornivel' . "\0" . 'fechafin', '' . "\0" . 'AppBundle\\Entity\\CeCiclopornivel' . "\0" . 'fechainicios1', '' . "\0" . 'AppBundle\\Entity\\CeCiclopornivel' . "\0" . 'fechafins1', '' . "\0" . 'AppBundle\\Entity\\CeCiclopornivel' . "\0" . 'fechainicios2', '' . "\0" . 'AppBundle\\Entity\\CeCiclopornivel' . "\0" . 'fechafins2', '' . "\0" . 'AppBundle\\Entity\\CeCiclopornivel' . "\0" . 'ciclopornivelid', '' . "\0" . 'AppBundle\\Entity\\CeCiclopornivel' . "\0" . 'nivelid', '' . "\0" . 'AppBundle\\Entity\\CeCiclopornivel' . "\0" . 'cicloid'];
        }

        return ['__isInitialized__', '' . "\0" . 'AppBundle\\Entity\\CeCiclopornivel' . "\0" . 'fechainicio', '' . "\0" . 'AppBundle\\Entity\\CeCiclopornivel' . "\0" . 'fechafin', '' . "\0" . 'AppBundle\\Entity\\CeCiclopornivel' . "\0" . 'fechainicios1', '' . "\0" . 'AppBundle\\Entity\\CeCiclopornivel' . "\0" . 'fechafins1', '' . "\0" . 'AppBundle\\Entity\\CeCiclopornivel' . "\0" . 'fechainicios2', '' . "\0" . 'AppBundle\\Entity\\CeCiclopornivel' . "\0" . 'fechafins2', '' . "\0" . 'AppBundle\\Entity\\CeCiclopornivel' . "\0" . 'ciclopornivelid', '' . "\0" . 'AppBundle\\Entity\\CeCiclopornivel' . "\0" . 'nivelid', '' . "\0" . 'AppBundle\\Entity\\CeCiclopornivel' . "\0" . 'cicloid'];
    }

    /**
     * 
     */
    public function __wakeup()
    {
        if ( ! $this->__isInitialized__) {
            $this->__initializer__ = function (CeCiclopornivel $proxy) {
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
    public function setFechainicio($fechainicio)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setFechainicio', [$fechainicio]);

        return parent::setFechainicio($fechainicio);
    }

    /**
     * {@inheritDoc}
     */
    public function getFechainicio()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getFechainicio', []);

        return parent::getFechainicio();
    }

    /**
     * {@inheritDoc}
     */
    public function setFechafin($fechafin)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setFechafin', [$fechafin]);

        return parent::setFechafin($fechafin);
    }

    /**
     * {@inheritDoc}
     */
    public function getFechafin()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getFechafin', []);

        return parent::getFechafin();
    }

    /**
     * {@inheritDoc}
     */
    public function setFechainicios1($fechainicios1)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setFechainicios1', [$fechainicios1]);

        return parent::setFechainicios1($fechainicios1);
    }

    /**
     * {@inheritDoc}
     */
    public function getFechainicios1()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getFechainicios1', []);

        return parent::getFechainicios1();
    }

    /**
     * {@inheritDoc}
     */
    public function setFechafins1($fechafins1)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setFechafins1', [$fechafins1]);

        return parent::setFechafins1($fechafins1);
    }

    /**
     * {@inheritDoc}
     */
    public function getFechafins1()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getFechafins1', []);

        return parent::getFechafins1();
    }

    /**
     * {@inheritDoc}
     */
    public function setFechainicios2($fechainicios2)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setFechainicios2', [$fechainicios2]);

        return parent::setFechainicios2($fechainicios2);
    }

    /**
     * {@inheritDoc}
     */
    public function getFechainicios2()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getFechainicios2', []);

        return parent::getFechainicios2();
    }

    /**
     * {@inheritDoc}
     */
    public function setFechafins2($fechafins2)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setFechafins2', [$fechafins2]);

        return parent::setFechafins2($fechafins2);
    }

    /**
     * {@inheritDoc}
     */
    public function getFechafins2()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getFechafins2', []);

        return parent::getFechafins2();
    }

    /**
     * {@inheritDoc}
     */
    public function getCiclopornivelid()
    {
        if ($this->__isInitialized__ === false) {
            return (int)  parent::getCiclopornivelid();
        }


        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getCiclopornivelid', []);

        return parent::getCiclopornivelid();
    }

    /**
     * {@inheritDoc}
     */
    public function setNivelid(\AppBundle\Entity\Nivel $nivelid = NULL)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setNivelid', [$nivelid]);

        return parent::setNivelid($nivelid);
    }

    /**
     * {@inheritDoc}
     */
    public function getNivelid()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getNivelid', []);

        return parent::getNivelid();
    }

    /**
     * {@inheritDoc}
     */
    public function setCicloid(\AppBundle\Entity\Ciclo $cicloid = NULL)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setCicloid', [$cicloid]);

        return parent::setCicloid($cicloid);
    }

    /**
     * {@inheritDoc}
     */
    public function getCicloid()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getCicloid', []);

        return parent::getCicloid();
    }

}
