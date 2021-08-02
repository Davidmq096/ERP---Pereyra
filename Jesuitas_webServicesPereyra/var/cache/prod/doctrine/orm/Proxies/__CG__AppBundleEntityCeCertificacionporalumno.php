<?php

namespace Proxies\__CG__\AppBundle\Entity;

/**
 * DO NOT EDIT THIS FILE - IT WAS CREATED BY DOCTRINE'S PROXY GENERATOR
 */
class CeCertificacionporalumno extends \AppBundle\Entity\CeCertificacionporalumno implements \Doctrine\ORM\Proxy\Proxy
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
            return ['__isInitialized__', '' . "\0" . 'AppBundle\\Entity\\CeCertificacionporalumno' . "\0" . 'calificacion', '' . "\0" . 'AppBundle\\Entity\\CeCertificacionporalumno' . "\0" . 'fechacertificado', '' . "\0" . 'AppBundle\\Entity\\CeCertificacionporalumno' . "\0" . 'vigencia', '' . "\0" . 'AppBundle\\Entity\\CeCertificacionporalumno' . "\0" . 'certificacionporalumnoid', '' . "\0" . 'AppBundle\\Entity\\CeCertificacionporalumno' . "\0" . 'alumnoid', '' . "\0" . 'AppBundle\\Entity\\CeCertificacionporalumno' . "\0" . 'certificacionid'];
        }

        return ['__isInitialized__', '' . "\0" . 'AppBundle\\Entity\\CeCertificacionporalumno' . "\0" . 'calificacion', '' . "\0" . 'AppBundle\\Entity\\CeCertificacionporalumno' . "\0" . 'fechacertificado', '' . "\0" . 'AppBundle\\Entity\\CeCertificacionporalumno' . "\0" . 'vigencia', '' . "\0" . 'AppBundle\\Entity\\CeCertificacionporalumno' . "\0" . 'certificacionporalumnoid', '' . "\0" . 'AppBundle\\Entity\\CeCertificacionporalumno' . "\0" . 'alumnoid', '' . "\0" . 'AppBundle\\Entity\\CeCertificacionporalumno' . "\0" . 'certificacionid'];
    }

    /**
     * 
     */
    public function __wakeup()
    {
        if ( ! $this->__isInitialized__) {
            $this->__initializer__ = function (CeCertificacionporalumno $proxy) {
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
    public function setCalificacion($calificacion)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setCalificacion', [$calificacion]);

        return parent::setCalificacion($calificacion);
    }

    /**
     * {@inheritDoc}
     */
    public function getCalificacion()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getCalificacion', []);

        return parent::getCalificacion();
    }

    /**
     * {@inheritDoc}
     */
    public function setFechacertificado($fechacertificado)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setFechacertificado', [$fechacertificado]);

        return parent::setFechacertificado($fechacertificado);
    }

    /**
     * {@inheritDoc}
     */
    public function getFechacertificado()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getFechacertificado', []);

        return parent::getFechacertificado();
    }

    /**
     * {@inheritDoc}
     */
    public function setVigencia($vigencia)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setVigencia', [$vigencia]);

        return parent::setVigencia($vigencia);
    }

    /**
     * {@inheritDoc}
     */
    public function getVigencia()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getVigencia', []);

        return parent::getVigencia();
    }

    /**
     * {@inheritDoc}
     */
    public function getCertificacionporalumnoid()
    {
        if ($this->__isInitialized__ === false) {
            return (int)  parent::getCertificacionporalumnoid();
        }


        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getCertificacionporalumnoid', []);

        return parent::getCertificacionporalumnoid();
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
    public function setCertificacionid(\AppBundle\Entity\CeCertificacion $certificacionid = NULL)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setCertificacionid', [$certificacionid]);

        return parent::setCertificacionid($certificacionid);
    }

    /**
     * {@inheritDoc}
     */
    public function getCertificacionid()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getCertificacionid', []);

        return parent::getCertificacionid();
    }

}