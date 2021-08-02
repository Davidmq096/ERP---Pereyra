<?php

namespace Proxies\__CG__\AppBundle\Entity;

/**
 * DO NOT EDIT THIS FILE - IT WAS CREATED BY DOCTRINE'S PROXY GENERATOR
 */
class CjConceptoplantillacontable extends \AppBundle\Entity\CjConceptoplantillacontable implements \Doctrine\ORM\Proxy\Proxy
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
            return ['__isInitialized__', '' . "\0" . 'AppBundle\\Entity\\CjConceptoplantillacontable' . "\0" . 'tipomovimientoid', '' . "\0" . 'AppBundle\\Entity\\CjConceptoplantillacontable' . "\0" . 'porcentaje', '' . "\0" . 'AppBundle\\Entity\\CjConceptoplantillacontable' . "\0" . 'tipoplantilla', '' . "\0" . 'AppBundle\\Entity\\CjConceptoplantillacontable' . "\0" . 'conceptoplantillacontableid', '' . "\0" . 'AppBundle\\Entity\\CjConceptoplantillacontable' . "\0" . 'centrocostoid', '' . "\0" . 'AppBundle\\Entity\\CjConceptoplantillacontable' . "\0" . 'conceptoid', '' . "\0" . 'AppBundle\\Entity\\CjConceptoplantillacontable' . "\0" . 'cuentacontableid'];
        }

        return ['__isInitialized__', '' . "\0" . 'AppBundle\\Entity\\CjConceptoplantillacontable' . "\0" . 'tipomovimientoid', '' . "\0" . 'AppBundle\\Entity\\CjConceptoplantillacontable' . "\0" . 'porcentaje', '' . "\0" . 'AppBundle\\Entity\\CjConceptoplantillacontable' . "\0" . 'tipoplantilla', '' . "\0" . 'AppBundle\\Entity\\CjConceptoplantillacontable' . "\0" . 'conceptoplantillacontableid', '' . "\0" . 'AppBundle\\Entity\\CjConceptoplantillacontable' . "\0" . 'centrocostoid', '' . "\0" . 'AppBundle\\Entity\\CjConceptoplantillacontable' . "\0" . 'conceptoid', '' . "\0" . 'AppBundle\\Entity\\CjConceptoplantillacontable' . "\0" . 'cuentacontableid'];
    }

    /**
     * 
     */
    public function __wakeup()
    {
        if ( ! $this->__isInitialized__) {
            $this->__initializer__ = function (CjConceptoplantillacontable $proxy) {
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
    public function setTipomovimientoid($tipomovimientoid)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setTipomovimientoid', [$tipomovimientoid]);

        return parent::setTipomovimientoid($tipomovimientoid);
    }

    /**
     * {@inheritDoc}
     */
    public function getTipomovimientoid()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getTipomovimientoid', []);

        return parent::getTipomovimientoid();
    }

    /**
     * {@inheritDoc}
     */
    public function setPorcentaje($porcentaje)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setPorcentaje', [$porcentaje]);

        return parent::setPorcentaje($porcentaje);
    }

    /**
     * {@inheritDoc}
     */
    public function getPorcentaje()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getPorcentaje', []);

        return parent::getPorcentaje();
    }

    /**
     * {@inheritDoc}
     */
    public function setTipoplantilla($tipoplantilla)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setTipoplantilla', [$tipoplantilla]);

        return parent::setTipoplantilla($tipoplantilla);
    }

    /**
     * {@inheritDoc}
     */
    public function getTipoplantilla()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getTipoplantilla', []);

        return parent::getTipoplantilla();
    }

    /**
     * {@inheritDoc}
     */
    public function getConceptoplantillacontableid()
    {
        if ($this->__isInitialized__ === false) {
            return (int)  parent::getConceptoplantillacontableid();
        }


        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getConceptoplantillacontableid', []);

        return parent::getConceptoplantillacontableid();
    }

    /**
     * {@inheritDoc}
     */
    public function setCentrocostoid(\AppBundle\Entity\CjCentrocosto $centrocostoid = NULL)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setCentrocostoid', [$centrocostoid]);

        return parent::setCentrocostoid($centrocostoid);
    }

    /**
     * {@inheritDoc}
     */
    public function getCentrocostoid()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getCentrocostoid', []);

        return parent::getCentrocostoid();
    }

    /**
     * {@inheritDoc}
     */
    public function setConceptoid(\AppBundle\Entity\CjConcepto $conceptoid = NULL)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setConceptoid', [$conceptoid]);

        return parent::setConceptoid($conceptoid);
    }

    /**
     * {@inheritDoc}
     */
    public function getConceptoid()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getConceptoid', []);

        return parent::getConceptoid();
    }

    /**
     * {@inheritDoc}
     */
    public function setCuentacontableid(\AppBundle\Entity\CjCuentacontable $cuentacontableid = NULL)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setCuentacontableid', [$cuentacontableid]);

        return parent::setCuentacontableid($cuentacontableid);
    }

    /**
     * {@inheritDoc}
     */
    public function getCuentacontableid()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getCuentacontableid', []);

        return parent::getCuentacontableid();
    }

}