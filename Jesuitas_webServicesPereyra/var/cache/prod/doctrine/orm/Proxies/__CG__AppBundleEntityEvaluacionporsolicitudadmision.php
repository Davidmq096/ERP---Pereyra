<?php

namespace Proxies\__CG__\AppBundle\Entity;

/**
 * DO NOT EDIT THIS FILE - IT WAS CREATED BY DOCTRINE'S PROXY GENERATOR
 */
class Evaluacionporsolicitudadmision extends \AppBundle\Entity\Evaluacionporsolicitudadmision implements \Doctrine\ORM\Proxy\Proxy
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
            return ['__isInitialized__', '' . "\0" . 'AppBundle\\Entity\\Evaluacionporsolicitudadmision' . "\0" . 'aprobado', '' . "\0" . 'AppBundle\\Entity\\Evaluacionporsolicitudadmision' . "\0" . 'resultado', '' . "\0" . 'AppBundle\\Entity\\Evaluacionporsolicitudadmision' . "\0" . 'conclusion', '' . "\0" . 'AppBundle\\Entity\\Evaluacionporsolicitudadmision' . "\0" . 'asistio', '' . "\0" . 'AppBundle\\Entity\\Evaluacionporsolicitudadmision' . "\0" . 'evidencia', '' . "\0" . 'AppBundle\\Entity\\Evaluacionporsolicitudadmision' . "\0" . 'evaluacionporsolicitudadmisionid', '' . "\0" . 'AppBundle\\Entity\\Evaluacionporsolicitudadmision' . "\0" . 'estatusevaluacionid', '' . "\0" . 'AppBundle\\Entity\\Evaluacionporsolicitudadmision' . "\0" . 'evaluacionid', '' . "\0" . 'AppBundle\\Entity\\Evaluacionporsolicitudadmision' . "\0" . 'eventoevaluacionid', '' . "\0" . 'AppBundle\\Entity\\Evaluacionporsolicitudadmision' . "\0" . 'solicitudadmisionid'];
        }

        return ['__isInitialized__', '' . "\0" . 'AppBundle\\Entity\\Evaluacionporsolicitudadmision' . "\0" . 'aprobado', '' . "\0" . 'AppBundle\\Entity\\Evaluacionporsolicitudadmision' . "\0" . 'resultado', '' . "\0" . 'AppBundle\\Entity\\Evaluacionporsolicitudadmision' . "\0" . 'conclusion', '' . "\0" . 'AppBundle\\Entity\\Evaluacionporsolicitudadmision' . "\0" . 'asistio', '' . "\0" . 'AppBundle\\Entity\\Evaluacionporsolicitudadmision' . "\0" . 'evidencia', '' . "\0" . 'AppBundle\\Entity\\Evaluacionporsolicitudadmision' . "\0" . 'evaluacionporsolicitudadmisionid', '' . "\0" . 'AppBundle\\Entity\\Evaluacionporsolicitudadmision' . "\0" . 'estatusevaluacionid', '' . "\0" . 'AppBundle\\Entity\\Evaluacionporsolicitudadmision' . "\0" . 'evaluacionid', '' . "\0" . 'AppBundle\\Entity\\Evaluacionporsolicitudadmision' . "\0" . 'eventoevaluacionid', '' . "\0" . 'AppBundle\\Entity\\Evaluacionporsolicitudadmision' . "\0" . 'solicitudadmisionid'];
    }

    /**
     * 
     */
    public function __wakeup()
    {
        if ( ! $this->__isInitialized__) {
            $this->__initializer__ = function (Evaluacionporsolicitudadmision $proxy) {
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
    public function setAprobado($aprobado)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setAprobado', [$aprobado]);

        return parent::setAprobado($aprobado);
    }

    /**
     * {@inheritDoc}
     */
    public function getAprobado()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getAprobado', []);

        return parent::getAprobado();
    }

    /**
     * {@inheritDoc}
     */
    public function setResultado($resultado)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setResultado', [$resultado]);

        return parent::setResultado($resultado);
    }

    /**
     * {@inheritDoc}
     */
    public function getResultado()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getResultado', []);

        return parent::getResultado();
    }

    /**
     * {@inheritDoc}
     */
    public function setConclusion($conclusion)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setConclusion', [$conclusion]);

        return parent::setConclusion($conclusion);
    }

    /**
     * {@inheritDoc}
     */
    public function getConclusion()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getConclusion', []);

        return parent::getConclusion();
    }

    /**
     * {@inheritDoc}
     */
    public function setAsistio($asistio)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setAsistio', [$asistio]);

        return parent::setAsistio($asistio);
    }

    /**
     * {@inheritDoc}
     */
    public function getAsistio()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getAsistio', []);

        return parent::getAsistio();
    }

    /**
     * {@inheritDoc}
     */
    public function setEvidencia($evidencia)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setEvidencia', [$evidencia]);

        return parent::setEvidencia($evidencia);
    }

    /**
     * {@inheritDoc}
     */
    public function getEvidencia()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getEvidencia', []);

        return parent::getEvidencia();
    }

    /**
     * {@inheritDoc}
     */
    public function getEvaluacionporsolicitudadmisionid()
    {
        if ($this->__isInitialized__ === false) {
            return (int)  parent::getEvaluacionporsolicitudadmisionid();
        }


        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getEvaluacionporsolicitudadmisionid', []);

        return parent::getEvaluacionporsolicitudadmisionid();
    }

    /**
     * {@inheritDoc}
     */
    public function setEstatusevaluacionid(\AppBundle\Entity\Estatusevaluacion $estatusevaluacionid = NULL)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setEstatusevaluacionid', [$estatusevaluacionid]);

        return parent::setEstatusevaluacionid($estatusevaluacionid);
    }

    /**
     * {@inheritDoc}
     */
    public function getEstatusevaluacionid()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getEstatusevaluacionid', []);

        return parent::getEstatusevaluacionid();
    }

    /**
     * {@inheritDoc}
     */
    public function setEvaluacionid(\AppBundle\Entity\Evaluacion $evaluacionid = NULL)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setEvaluacionid', [$evaluacionid]);

        return parent::setEvaluacionid($evaluacionid);
    }

    /**
     * {@inheritDoc}
     */
    public function getEvaluacionid()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getEvaluacionid', []);

        return parent::getEvaluacionid();
    }

    /**
     * {@inheritDoc}
     */
    public function setEventoevaluacionid(\AppBundle\Entity\Eventoevaluacion $eventoevaluacionid = NULL)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setEventoevaluacionid', [$eventoevaluacionid]);

        return parent::setEventoevaluacionid($eventoevaluacionid);
    }

    /**
     * {@inheritDoc}
     */
    public function getEventoevaluacionid()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getEventoevaluacionid', []);

        return parent::getEventoevaluacionid();
    }

    /**
     * {@inheritDoc}
     */
    public function setSolicitudadmisionid(\AppBundle\Entity\Solicitudadmision $solicitudadmisionid = NULL)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setSolicitudadmisionid', [$solicitudadmisionid]);

        return parent::setSolicitudadmisionid($solicitudadmisionid);
    }

    /**
     * {@inheritDoc}
     */
    public function getSolicitudadmisionid()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getSolicitudadmisionid', []);

        return parent::getSolicitudadmisionid();
    }

}