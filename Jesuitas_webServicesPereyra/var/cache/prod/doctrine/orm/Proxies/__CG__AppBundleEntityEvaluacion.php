<?php

namespace Proxies\__CG__\AppBundle\Entity;

/**
 * DO NOT EDIT THIS FILE - IT WAS CREATED BY DOCTRINE'S PROXY GENERATOR
 */
class Evaluacion extends \AppBundle\Entity\Evaluacion implements \Doctrine\ORM\Proxy\Proxy
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
            return ['__isInitialized__', '' . "\0" . 'AppBundle\\Entity\\Evaluacion' . "\0" . 'usuarioid', '' . "\0" . 'AppBundle\\Entity\\Evaluacion' . "\0" . 'nombre', '' . "\0" . 'AppBundle\\Entity\\Evaluacion' . "\0" . 'activo', '' . "\0" . 'AppBundle\\Entity\\Evaluacion' . "\0" . 'evaluacionid', '' . "\0" . 'AppBundle\\Entity\\Evaluacion' . "\0" . 'cicloid', '' . "\0" . 'AppBundle\\Entity\\Evaluacion' . "\0" . 'tipoevaluacionid'];
        }

        return ['__isInitialized__', '' . "\0" . 'AppBundle\\Entity\\Evaluacion' . "\0" . 'usuarioid', '' . "\0" . 'AppBundle\\Entity\\Evaluacion' . "\0" . 'nombre', '' . "\0" . 'AppBundle\\Entity\\Evaluacion' . "\0" . 'activo', '' . "\0" . 'AppBundle\\Entity\\Evaluacion' . "\0" . 'evaluacionid', '' . "\0" . 'AppBundle\\Entity\\Evaluacion' . "\0" . 'cicloid', '' . "\0" . 'AppBundle\\Entity\\Evaluacion' . "\0" . 'tipoevaluacionid'];
    }

    /**
     * 
     */
    public function __wakeup()
    {
        if ( ! $this->__isInitialized__) {
            $this->__initializer__ = function (Evaluacion $proxy) {
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
    public function setUsuarioid($usuarioid)
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

    /**
     * {@inheritDoc}
     */
    public function setNombre($nombre)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setNombre', [$nombre]);

        return parent::setNombre($nombre);
    }

    /**
     * {@inheritDoc}
     */
    public function getNombre()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getNombre', []);

        return parent::getNombre();
    }

    /**
     * {@inheritDoc}
     */
    public function setActivo($activo)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setActivo', [$activo]);

        return parent::setActivo($activo);
    }

    /**
     * {@inheritDoc}
     */
    public function getActivo()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getActivo', []);

        return parent::getActivo();
    }

    /**
     * {@inheritDoc}
     */
    public function getEvaluacionid()
    {
        if ($this->__isInitialized__ === false) {
            return (int)  parent::getEvaluacionid();
        }


        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getEvaluacionid', []);

        return parent::getEvaluacionid();
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
    public function setTipoevaluacionid(\AppBundle\Entity\Tipoevaluacion $tipoevaluacionid = NULL)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setTipoevaluacionid', [$tipoevaluacionid]);

        return parent::setTipoevaluacionid($tipoevaluacionid);
    }

    /**
     * {@inheritDoc}
     */
    public function getTipoevaluacionid()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getTipoevaluacionid', []);

        return parent::getTipoevaluacionid();
    }

}
