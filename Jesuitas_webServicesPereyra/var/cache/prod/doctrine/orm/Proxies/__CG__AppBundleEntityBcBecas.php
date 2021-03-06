<?php

namespace Proxies\__CG__\AppBundle\Entity;

/**
 * DO NOT EDIT THIS FILE - IT WAS CREATED BY DOCTRINE'S PROXY GENERATOR
 */
class BcBecas extends \AppBundle\Entity\BcBecas implements \Doctrine\ORM\Proxy\Proxy
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
            return ['__isInitialized__', '' . "\0" . 'AppBundle\\Entity\\BcBecas' . "\0" . 'becaid', '' . "\0" . 'AppBundle\\Entity\\BcBecas' . "\0" . 'alumnoid', '' . "\0" . 'AppBundle\\Entity\\BcBecas' . "\0" . 'gradoidorigen', '' . "\0" . 'AppBundle\\Entity\\BcBecas' . "\0" . 'porcentajebecaid', '' . "\0" . 'AppBundle\\Entity\\BcBecas' . "\0" . 'tipobecaid', '' . "\0" . 'AppBundle\\Entity\\BcBecas' . "\0" . 'gradoid', '' . "\0" . 'AppBundle\\Entity\\BcBecas' . "\0" . 'cicloid', '' . "\0" . 'AppBundle\\Entity\\BcBecas' . "\0" . 'estatusid'];
        }

        return ['__isInitialized__', '' . "\0" . 'AppBundle\\Entity\\BcBecas' . "\0" . 'becaid', '' . "\0" . 'AppBundle\\Entity\\BcBecas' . "\0" . 'alumnoid', '' . "\0" . 'AppBundle\\Entity\\BcBecas' . "\0" . 'gradoidorigen', '' . "\0" . 'AppBundle\\Entity\\BcBecas' . "\0" . 'porcentajebecaid', '' . "\0" . 'AppBundle\\Entity\\BcBecas' . "\0" . 'tipobecaid', '' . "\0" . 'AppBundle\\Entity\\BcBecas' . "\0" . 'gradoid', '' . "\0" . 'AppBundle\\Entity\\BcBecas' . "\0" . 'cicloid', '' . "\0" . 'AppBundle\\Entity\\BcBecas' . "\0" . 'estatusid'];
    }

    /**
     * 
     */
    public function __wakeup()
    {
        if ( ! $this->__isInitialized__) {
            $this->__initializer__ = function (BcBecas $proxy) {
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
    public function getBecaid()
    {
        if ($this->__isInitialized__ === false) {
            return (int)  parent::getBecaid();
        }


        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getBecaid', []);

        return parent::getBecaid();
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
    public function setGradoidorigen(\AppBundle\Entity\Grado $gradoidorigen = NULL)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setGradoidorigen', [$gradoidorigen]);

        return parent::setGradoidorigen($gradoidorigen);
    }

    /**
     * {@inheritDoc}
     */
    public function getGradoidorigen()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getGradoidorigen', []);

        return parent::getGradoidorigen();
    }

    /**
     * {@inheritDoc}
     */
    public function setPorcentajebecaid(\AppBundle\Entity\BcPorcentajebeca $porcentajebecaid = NULL)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setPorcentajebecaid', [$porcentajebecaid]);

        return parent::setPorcentajebecaid($porcentajebecaid);
    }

    /**
     * {@inheritDoc}
     */
    public function getPorcentajebecaid()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getPorcentajebecaid', []);

        return parent::getPorcentajebecaid();
    }

    /**
     * {@inheritDoc}
     */
    public function setTipobecaid(\AppBundle\Entity\BcTipobeca $tipobecaid = NULL)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setTipobecaid', [$tipobecaid]);

        return parent::setTipobecaid($tipobecaid);
    }

    /**
     * {@inheritDoc}
     */
    public function getTipobecaid()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getTipobecaid', []);

        return parent::getTipobecaid();
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

    /**
     * {@inheritDoc}
     */
    public function setEstatusid(\AppBundle\Entity\BcEstatus $estatusid = NULL)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setEstatusid', [$estatusid]);

        return parent::setEstatusid($estatusid);
    }

    /**
     * {@inheritDoc}
     */
    public function getEstatusid()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getEstatusid', []);

        return parent::getEstatusid();
    }

}
