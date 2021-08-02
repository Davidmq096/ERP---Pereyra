<?php

namespace Proxies\__CG__\AppBundle\Entity;

/**
 * DO NOT EDIT THIS FILE - IT WAS CREATED BY DOCTRINE'S PROXY GENERATOR
 */
class Saldos extends \AppBundle\Entity\Saldos implements \Doctrine\ORM\Proxy\Proxy
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
            return ['__isInitialized__', '' . "\0" . 'AppBundle\\Entity\\Saldos' . "\0" . 'alumno', '' . "\0" . 'AppBundle\\Entity\\Saldos' . "\0" . 'subconcepto', '' . "\0" . 'AppBundle\\Entity\\Saldos' . "\0" . 'periodo', '' . "\0" . 'AppBundle\\Entity\\Saldos' . "\0" . 'importe', '' . "\0" . 'AppBundle\\Entity\\Saldos' . "\0" . 'recargos', '' . "\0" . 'AppBundle\\Entity\\Saldos' . "\0" . 'anio', '' . "\0" . 'AppBundle\\Entity\\Saldos' . "\0" . 'mes', '' . "\0" . 'AppBundle\\Entity\\Saldos' . "\0" . 'clave', '' . "\0" . 'AppBundle\\Entity\\Saldos' . "\0" . 'fechavencimiento', '' . "\0" . 'AppBundle\\Entity\\Saldos' . "\0" . 'subconceptoid', '' . "\0" . 'AppBundle\\Entity\\Saldos' . "\0" . 'alumnoid', '' . "\0" . 'AppBundle\\Entity\\Saldos' . "\0" . 'gradoid', '' . "\0" . 'AppBundle\\Entity\\Saldos' . "\0" . 'pk'];
        }

        return ['__isInitialized__', '' . "\0" . 'AppBundle\\Entity\\Saldos' . "\0" . 'alumno', '' . "\0" . 'AppBundle\\Entity\\Saldos' . "\0" . 'subconcepto', '' . "\0" . 'AppBundle\\Entity\\Saldos' . "\0" . 'periodo', '' . "\0" . 'AppBundle\\Entity\\Saldos' . "\0" . 'importe', '' . "\0" . 'AppBundle\\Entity\\Saldos' . "\0" . 'recargos', '' . "\0" . 'AppBundle\\Entity\\Saldos' . "\0" . 'anio', '' . "\0" . 'AppBundle\\Entity\\Saldos' . "\0" . 'mes', '' . "\0" . 'AppBundle\\Entity\\Saldos' . "\0" . 'clave', '' . "\0" . 'AppBundle\\Entity\\Saldos' . "\0" . 'fechavencimiento', '' . "\0" . 'AppBundle\\Entity\\Saldos' . "\0" . 'subconceptoid', '' . "\0" . 'AppBundle\\Entity\\Saldos' . "\0" . 'alumnoid', '' . "\0" . 'AppBundle\\Entity\\Saldos' . "\0" . 'gradoid', '' . "\0" . 'AppBundle\\Entity\\Saldos' . "\0" . 'pk'];
    }

    /**
     * 
     */
    public function __wakeup()
    {
        if ( ! $this->__isInitialized__) {
            $this->__initializer__ = function (Saldos $proxy) {
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
    public function setAlumno($alumno)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setAlumno', [$alumno]);

        return parent::setAlumno($alumno);
    }

    /**
     * {@inheritDoc}
     */
    public function getAlumno()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getAlumno', []);

        return parent::getAlumno();
    }

    /**
     * {@inheritDoc}
     */
    public function setSubconcepto($subconcepto)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setSubconcepto', [$subconcepto]);

        return parent::setSubconcepto($subconcepto);
    }

    /**
     * {@inheritDoc}
     */
    public function getSubconcepto()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getSubconcepto', []);

        return parent::getSubconcepto();
    }

    /**
     * {@inheritDoc}
     */
    public function setPeriodo($periodo)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setPeriodo', [$periodo]);

        return parent::setPeriodo($periodo);
    }

    /**
     * {@inheritDoc}
     */
    public function getPeriodo()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getPeriodo', []);

        return parent::getPeriodo();
    }

    /**
     * {@inheritDoc}
     */
    public function setImporte($importe)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setImporte', [$importe]);

        return parent::setImporte($importe);
    }

    /**
     * {@inheritDoc}
     */
    public function getImporte()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getImporte', []);

        return parent::getImporte();
    }

    /**
     * {@inheritDoc}
     */
    public function setRecargos($recargos)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setRecargos', [$recargos]);

        return parent::setRecargos($recargos);
    }

    /**
     * {@inheritDoc}
     */
    public function getRecargos()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getRecargos', []);

        return parent::getRecargos();
    }

    /**
     * {@inheritDoc}
     */
    public function setAnio($anio)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setAnio', [$anio]);

        return parent::setAnio($anio);
    }

    /**
     * {@inheritDoc}
     */
    public function getAnio()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getAnio', []);

        return parent::getAnio();
    }

    /**
     * {@inheritDoc}
     */
    public function setMes($mes)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setMes', [$mes]);

        return parent::setMes($mes);
    }

    /**
     * {@inheritDoc}
     */
    public function getMes()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getMes', []);

        return parent::getMes();
    }

    /**
     * {@inheritDoc}
     */
    public function setClave($clave)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setClave', [$clave]);

        return parent::setClave($clave);
    }

    /**
     * {@inheritDoc}
     */
    public function getClave()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getClave', []);

        return parent::getClave();
    }

    /**
     * {@inheritDoc}
     */
    public function setFechavencimiento($fechavencimiento)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setFechavencimiento', [$fechavencimiento]);

        return parent::setFechavencimiento($fechavencimiento);
    }

    /**
     * {@inheritDoc}
     */
    public function getFechavencimiento()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getFechavencimiento', []);

        return parent::getFechavencimiento();
    }

    /**
     * {@inheritDoc}
     */
    public function setSubconceptoid($subconceptoid)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setSubconceptoid', [$subconceptoid]);

        return parent::setSubconceptoid($subconceptoid);
    }

    /**
     * {@inheritDoc}
     */
    public function getSubconceptoid()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getSubconceptoid', []);

        return parent::getSubconceptoid();
    }

    /**
     * {@inheritDoc}
     */
    public function setAlumnoid($alumnoid)
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
    public function setGradoid($gradoid)
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
    public function getPk()
    {
        if ($this->__isInitialized__ === false) {
            return (int)  parent::getPk();
        }


        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getPk', []);

        return parent::getPk();
    }

}
