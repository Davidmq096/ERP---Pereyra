<?php

namespace Proxies\__CG__\AppBundle\Entity;

/**
 * DO NOT EDIT THIS FILE - IT WAS CREATED BY DOCTRINE'S PROXY GENERATOR
 */
class CeAlumnocicloportaller extends \AppBundle\Entity\CeAlumnocicloportaller implements \Doctrine\ORM\Proxy\Proxy
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
            return ['__isInitialized__', '' . "\0" . 'AppBundle\\Entity\\CeAlumnocicloportaller' . "\0" . 'vigente', '' . "\0" . 'AppBundle\\Entity\\CeAlumnocicloportaller' . "\0" . 'numerolista', '' . "\0" . 'AppBundle\\Entity\\CeAlumnocicloportaller' . "\0" . 'alumnocicloportallerid', '' . "\0" . 'AppBundle\\Entity\\CeAlumnocicloportaller' . "\0" . 'alumnoporcicloid', '' . "\0" . 'AppBundle\\Entity\\CeAlumnocicloportaller' . "\0" . 'clasificadorparaescolarid', '' . "\0" . 'AppBundle\\Entity\\CeAlumnocicloportaller' . "\0" . 'tallercurricularid'];
        }

        return ['__isInitialized__', '' . "\0" . 'AppBundle\\Entity\\CeAlumnocicloportaller' . "\0" . 'vigente', '' . "\0" . 'AppBundle\\Entity\\CeAlumnocicloportaller' . "\0" . 'numerolista', '' . "\0" . 'AppBundle\\Entity\\CeAlumnocicloportaller' . "\0" . 'alumnocicloportallerid', '' . "\0" . 'AppBundle\\Entity\\CeAlumnocicloportaller' . "\0" . 'alumnoporcicloid', '' . "\0" . 'AppBundle\\Entity\\CeAlumnocicloportaller' . "\0" . 'clasificadorparaescolarid', '' . "\0" . 'AppBundle\\Entity\\CeAlumnocicloportaller' . "\0" . 'tallercurricularid'];
    }

    /**
     * 
     */
    public function __wakeup()
    {
        if ( ! $this->__isInitialized__) {
            $this->__initializer__ = function (CeAlumnocicloportaller $proxy) {
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
    public function setVigente($vigente)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setVigente', [$vigente]);

        return parent::setVigente($vigente);
    }

    /**
     * {@inheritDoc}
     */
    public function getVigente()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getVigente', []);

        return parent::getVigente();
    }

    /**
     * {@inheritDoc}
     */
    public function setNumerolista($numerolista)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setNumerolista', [$numerolista]);

        return parent::setNumerolista($numerolista);
    }

    /**
     * {@inheritDoc}
     */
    public function getNumerolista()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getNumerolista', []);

        return parent::getNumerolista();
    }

    /**
     * {@inheritDoc}
     */
    public function getAlumnocicloportallerid()
    {
        if ($this->__isInitialized__ === false) {
            return (int)  parent::getAlumnocicloportallerid();
        }


        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getAlumnocicloportallerid', []);

        return parent::getAlumnocicloportallerid();
    }

    /**
     * {@inheritDoc}
     */
    public function setAlumnoporcicloid(\AppBundle\Entity\CeAlumnoporciclo $alumnoporcicloid = NULL)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setAlumnoporcicloid', [$alumnoporcicloid]);

        return parent::setAlumnoporcicloid($alumnoporcicloid);
    }

    /**
     * {@inheritDoc}
     */
    public function getAlumnoporcicloid()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getAlumnoporcicloid', []);

        return parent::getAlumnoporcicloid();
    }

    /**
     * {@inheritDoc}
     */
    public function setClasificadorparaescolarid(\AppBundle\Entity\CeClasificadorparaescolares $clasificadorparaescolarid = NULL)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setClasificadorparaescolarid', [$clasificadorparaescolarid]);

        return parent::setClasificadorparaescolarid($clasificadorparaescolarid);
    }

    /**
     * {@inheritDoc}
     */
    public function getClasificadorparaescolarid()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getClasificadorparaescolarid', []);

        return parent::getClasificadorparaescolarid();
    }

    /**
     * {@inheritDoc}
     */
    public function setTallercurricularid(\AppBundle\Entity\CeTallercurricular $tallercurricularid = NULL)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setTallercurricularid', [$tallercurricularid]);

        return parent::setTallercurricularid($tallercurricularid);
    }

    /**
     * {@inheritDoc}
     */
    public function getTallercurricularid()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getTallercurricularid', []);

        return parent::getTallercurricularid();
    }

}
