<?php

namespace Proxies\__CG__\AppBundle\Entity;

/**
 * DO NOT EDIT THIS FILE - IT WAS CREATED BY DOCTRINE'S PROXY GENERATOR
 */
class CbPlanpagos extends \AppBundle\Entity\CbPlanpagos implements \Doctrine\ORM\Proxy\Proxy
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
            return ['__isInitialized__', '' . "\0" . 'AppBundle\\Entity\\CbPlanpagos' . "\0" . 'matricula', '' . "\0" . 'AppBundle\\Entity\\CbPlanpagos' . "\0" . 'nombre', '' . "\0" . 'AppBundle\\Entity\\CbPlanpagos' . "\0" . 'concepto', '' . "\0" . 'AppBundle\\Entity\\CbPlanpagos' . "\0" . 'fechacompromiso', '' . "\0" . 'AppBundle\\Entity\\CbPlanpagos' . "\0" . 'importecompromiso', '' . "\0" . 'AppBundle\\Entity\\CbPlanpagos' . "\0" . 'observaciones', '' . "\0" . 'AppBundle\\Entity\\CbPlanpagos' . "\0" . 'planpagosid', '' . "\0" . 'AppBundle\\Entity\\CbPlanpagos' . "\0" . 'acuerdoid'];
        }

        return ['__isInitialized__', '' . "\0" . 'AppBundle\\Entity\\CbPlanpagos' . "\0" . 'matricula', '' . "\0" . 'AppBundle\\Entity\\CbPlanpagos' . "\0" . 'nombre', '' . "\0" . 'AppBundle\\Entity\\CbPlanpagos' . "\0" . 'concepto', '' . "\0" . 'AppBundle\\Entity\\CbPlanpagos' . "\0" . 'fechacompromiso', '' . "\0" . 'AppBundle\\Entity\\CbPlanpagos' . "\0" . 'importecompromiso', '' . "\0" . 'AppBundle\\Entity\\CbPlanpagos' . "\0" . 'observaciones', '' . "\0" . 'AppBundle\\Entity\\CbPlanpagos' . "\0" . 'planpagosid', '' . "\0" . 'AppBundle\\Entity\\CbPlanpagos' . "\0" . 'acuerdoid'];
    }

    /**
     * 
     */
    public function __wakeup()
    {
        if ( ! $this->__isInitialized__) {
            $this->__initializer__ = function (CbPlanpagos $proxy) {
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
    public function setMatricula($matricula)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setMatricula', [$matricula]);

        return parent::setMatricula($matricula);
    }

    /**
     * {@inheritDoc}
     */
    public function getMatricula()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getMatricula', []);

        return parent::getMatricula();
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
    public function setConcepto($concepto)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setConcepto', [$concepto]);

        return parent::setConcepto($concepto);
    }

    /**
     * {@inheritDoc}
     */
    public function getConcepto()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getConcepto', []);

        return parent::getConcepto();
    }

    /**
     * {@inheritDoc}
     */
    public function setFechacompromiso($fechacompromiso)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setFechacompromiso', [$fechacompromiso]);

        return parent::setFechacompromiso($fechacompromiso);
    }

    /**
     * {@inheritDoc}
     */
    public function getFechacompromiso()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getFechacompromiso', []);

        return parent::getFechacompromiso();
    }

    /**
     * {@inheritDoc}
     */
    public function setImportecompromiso($importecompromiso)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setImportecompromiso', [$importecompromiso]);

        return parent::setImportecompromiso($importecompromiso);
    }

    /**
     * {@inheritDoc}
     */
    public function getImportecompromiso()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getImportecompromiso', []);

        return parent::getImportecompromiso();
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
    public function getPlanpagosid()
    {
        if ($this->__isInitialized__ === false) {
            return (int)  parent::getPlanpagosid();
        }


        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getPlanpagosid', []);

        return parent::getPlanpagosid();
    }

    /**
     * {@inheritDoc}
     */
    public function setAcuerdoid(\AppBundle\Entity\CbAcuerdo $acuerdoid = NULL)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setAcuerdoid', [$acuerdoid]);

        return parent::setAcuerdoid($acuerdoid);
    }

    /**
     * {@inheritDoc}
     */
    public function getAcuerdoid()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getAcuerdoid', []);

        return parent::getAcuerdoid();
    }

}
