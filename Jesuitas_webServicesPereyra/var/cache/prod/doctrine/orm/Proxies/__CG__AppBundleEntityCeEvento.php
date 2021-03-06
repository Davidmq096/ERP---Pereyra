<?php

namespace Proxies\__CG__\AppBundle\Entity;

/**
 * DO NOT EDIT THIS FILE - IT WAS CREATED BY DOCTRINE'S PROXY GENERATOR
 */
class CeEvento extends \AppBundle\Entity\CeEvento implements \Doctrine\ORM\Proxy\Proxy
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
            return ['__isInitialized__', '' . "\0" . 'AppBundle\\Entity\\CeEvento' . "\0" . 'nombre', '' . "\0" . 'AppBundle\\Entity\\CeEvento' . "\0" . 'descripcion', '' . "\0" . 'AppBundle\\Entity\\CeEvento' . "\0" . 'fechainicio', '' . "\0" . 'AppBundle\\Entity\\CeEvento' . "\0" . 'fechafin', '' . "\0" . 'AppBundle\\Entity\\CeEvento' . "\0" . 'horainicio', '' . "\0" . 'AppBundle\\Entity\\CeEvento' . "\0" . 'horafin', '' . "\0" . 'AppBundle\\Entity\\CeEvento' . "\0" . 'enviopush', '' . "\0" . 'AppBundle\\Entity\\CeEvento' . "\0" . 'fechaenvio', '' . "\0" . 'AppBundle\\Entity\\CeEvento' . "\0" . 'horaenvio', '' . "\0" . 'AppBundle\\Entity\\CeEvento' . "\0" . 'enviado', '' . "\0" . 'AppBundle\\Entity\\CeEvento' . "\0" . 'eventoid', '' . "\0" . 'AppBundle\\Entity\\CeEvento' . "\0" . 'tipoeventoid'];
        }

        return ['__isInitialized__', '' . "\0" . 'AppBundle\\Entity\\CeEvento' . "\0" . 'nombre', '' . "\0" . 'AppBundle\\Entity\\CeEvento' . "\0" . 'descripcion', '' . "\0" . 'AppBundle\\Entity\\CeEvento' . "\0" . 'fechainicio', '' . "\0" . 'AppBundle\\Entity\\CeEvento' . "\0" . 'fechafin', '' . "\0" . 'AppBundle\\Entity\\CeEvento' . "\0" . 'horainicio', '' . "\0" . 'AppBundle\\Entity\\CeEvento' . "\0" . 'horafin', '' . "\0" . 'AppBundle\\Entity\\CeEvento' . "\0" . 'enviopush', '' . "\0" . 'AppBundle\\Entity\\CeEvento' . "\0" . 'fechaenvio', '' . "\0" . 'AppBundle\\Entity\\CeEvento' . "\0" . 'horaenvio', '' . "\0" . 'AppBundle\\Entity\\CeEvento' . "\0" . 'enviado', '' . "\0" . 'AppBundle\\Entity\\CeEvento' . "\0" . 'eventoid', '' . "\0" . 'AppBundle\\Entity\\CeEvento' . "\0" . 'tipoeventoid'];
    }

    /**
     * 
     */
    public function __wakeup()
    {
        if ( ! $this->__isInitialized__) {
            $this->__initializer__ = function (CeEvento $proxy) {
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
    public function setHorainicio($horainicio)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setHorainicio', [$horainicio]);

        return parent::setHorainicio($horainicio);
    }

    /**
     * {@inheritDoc}
     */
    public function getHorainicio()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getHorainicio', []);

        return parent::getHorainicio();
    }

    /**
     * {@inheritDoc}
     */
    public function setHorafin($horafin)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setHorafin', [$horafin]);

        return parent::setHorafin($horafin);
    }

    /**
     * {@inheritDoc}
     */
    public function getHorafin()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getHorafin', []);

        return parent::getHorafin();
    }

    /**
     * {@inheritDoc}
     */
    public function setEnviopush($enviopush)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setEnviopush', [$enviopush]);

        return parent::setEnviopush($enviopush);
    }

    /**
     * {@inheritDoc}
     */
    public function getEnviopush()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getEnviopush', []);

        return parent::getEnviopush();
    }

    /**
     * {@inheritDoc}
     */
    public function setFechaenvio($fechaenvio)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setFechaenvio', [$fechaenvio]);

        return parent::setFechaenvio($fechaenvio);
    }

    /**
     * {@inheritDoc}
     */
    public function getFechaenvio()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getFechaenvio', []);

        return parent::getFechaenvio();
    }

    /**
     * {@inheritDoc}
     */
    public function setHoraenvio($horaenvio)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setHoraenvio', [$horaenvio]);

        return parent::setHoraenvio($horaenvio);
    }

    /**
     * {@inheritDoc}
     */
    public function getHoraenvio()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getHoraenvio', []);

        return parent::getHoraenvio();
    }

    /**
     * {@inheritDoc}
     */
    public function setEnviado($enviado)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setEnviado', [$enviado]);

        return parent::setEnviado($enviado);
    }

    /**
     * {@inheritDoc}
     */
    public function getEnviado()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getEnviado', []);

        return parent::getEnviado();
    }

    /**
     * {@inheritDoc}
     */
    public function getEventoid()
    {
        if ($this->__isInitialized__ === false) {
            return (int)  parent::getEventoid();
        }


        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getEventoid', []);

        return parent::getEventoid();
    }

    /**
     * {@inheritDoc}
     */
    public function setTipoeventoid(\AppBundle\Entity\CeTipoevento $tipoeventoid = NULL)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setTipoeventoid', [$tipoeventoid]);

        return parent::setTipoeventoid($tipoeventoid);
    }

    /**
     * {@inheritDoc}
     */
    public function getTipoeventoid()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getTipoeventoid', []);

        return parent::getTipoeventoid();
    }

}
