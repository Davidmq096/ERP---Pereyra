<?php

namespace Proxies\__CG__\AppBundle\Entity;

/**
 * DO NOT EDIT THIS FILE - IT WAS CREATED BY DOCTRINE'S PROXY GENERATOR
 */
class CeMateriaporhorario extends \AppBundle\Entity\CeMateriaporhorario implements \Doctrine\ORM\Proxy\Proxy
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
            return ['__isInitialized__', '' . "\0" . 'AppBundle\\Entity\\CeMateriaporhorario' . "\0" . 'dia', '' . "\0" . 'AppBundle\\Entity\\CeMateriaporhorario' . "\0" . 'salon', '' . "\0" . 'AppBundle\\Entity\\CeMateriaporhorario' . "\0" . 'materiaporhorarioid', '' . "\0" . 'AppBundle\\Entity\\CeMateriaporhorario' . "\0" . 'configuracionhorarioid', '' . "\0" . 'AppBundle\\Entity\\CeMateriaporhorario' . "\0" . 'grupoid', '' . "\0" . 'AppBundle\\Entity\\CeMateriaporhorario' . "\0" . 'profesorpormateriaplanestudiosid'];
        }

        return ['__isInitialized__', '' . "\0" . 'AppBundle\\Entity\\CeMateriaporhorario' . "\0" . 'dia', '' . "\0" . 'AppBundle\\Entity\\CeMateriaporhorario' . "\0" . 'salon', '' . "\0" . 'AppBundle\\Entity\\CeMateriaporhorario' . "\0" . 'materiaporhorarioid', '' . "\0" . 'AppBundle\\Entity\\CeMateriaporhorario' . "\0" . 'configuracionhorarioid', '' . "\0" . 'AppBundle\\Entity\\CeMateriaporhorario' . "\0" . 'grupoid', '' . "\0" . 'AppBundle\\Entity\\CeMateriaporhorario' . "\0" . 'profesorpormateriaplanestudiosid'];
    }

    /**
     * 
     */
    public function __wakeup()
    {
        if ( ! $this->__isInitialized__) {
            $this->__initializer__ = function (CeMateriaporhorario $proxy) {
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
    public function setDia($dia)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setDia', [$dia]);

        return parent::setDia($dia);
    }

    /**
     * {@inheritDoc}
     */
    public function getDia()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getDia', []);

        return parent::getDia();
    }

    /**
     * {@inheritDoc}
     */
    public function setSalon($salon)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setSalon', [$salon]);

        return parent::setSalon($salon);
    }

    /**
     * {@inheritDoc}
     */
    public function getSalon()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getSalon', []);

        return parent::getSalon();
    }

    /**
     * {@inheritDoc}
     */
    public function getMateriaporhorarioid()
    {
        if ($this->__isInitialized__ === false) {
            return (int)  parent::getMateriaporhorarioid();
        }


        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getMateriaporhorarioid', []);

        return parent::getMateriaporhorarioid();
    }

    /**
     * {@inheritDoc}
     */
    public function setConfiguracionhorarioid(\AppBundle\Entity\CeConfiguracionhorario $configuracionhorarioid = NULL)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setConfiguracionhorarioid', [$configuracionhorarioid]);

        return parent::setConfiguracionhorarioid($configuracionhorarioid);
    }

    /**
     * {@inheritDoc}
     */
    public function getConfiguracionhorarioid()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getConfiguracionhorarioid', []);

        return parent::getConfiguracionhorarioid();
    }

    /**
     * {@inheritDoc}
     */
    public function setGrupoid(\AppBundle\Entity\CeGrupo $grupoid = NULL)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setGrupoid', [$grupoid]);

        return parent::setGrupoid($grupoid);
    }

    /**
     * {@inheritDoc}
     */
    public function getGrupoid()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getGrupoid', []);

        return parent::getGrupoid();
    }

    /**
     * {@inheritDoc}
     */
    public function setProfesorpormateriaplanestudiosid(\AppBundle\Entity\CeProfesorpormateriaplanestudios $profesorpormateriaplanestudiosid = NULL)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setProfesorpormateriaplanestudiosid', [$profesorpormateriaplanestudiosid]);

        return parent::setProfesorpormateriaplanestudiosid($profesorpormateriaplanestudiosid);
    }

    /**
     * {@inheritDoc}
     */
    public function getProfesorpormateriaplanestudiosid()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getProfesorpormateriaplanestudiosid', []);

        return parent::getProfesorpormateriaplanestudiosid();
    }

}