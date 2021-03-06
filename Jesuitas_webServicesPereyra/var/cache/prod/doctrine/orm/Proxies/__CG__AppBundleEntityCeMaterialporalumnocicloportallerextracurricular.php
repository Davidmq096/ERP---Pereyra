<?php

namespace Proxies\__CG__\AppBundle\Entity;

/**
 * DO NOT EDIT THIS FILE - IT WAS CREATED BY DOCTRINE'S PROXY GENERATOR
 */
class CeMaterialporalumnocicloportallerextracurricular extends \AppBundle\Entity\CeMaterialporalumnocicloportallerextracurricular implements \Doctrine\ORM\Proxy\Proxy
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
            return ['__isInitialized__', '' . "\0" . 'AppBundle\\Entity\\CeMaterialporalumnocicloportallerextracurricular' . "\0" . 'talla', '' . "\0" . 'AppBundle\\Entity\\CeMaterialporalumnocicloportallerextracurricular' . "\0" . 'fechaentrega', '' . "\0" . 'AppBundle\\Entity\\CeMaterialporalumnocicloportallerextracurricular' . "\0" . 'materialporalumnocicloportallerextracurricularid', '' . "\0" . 'AppBundle\\Entity\\CeMaterialporalumnocicloportallerextracurricular' . "\0" . 'materialportallerextracurricularid', '' . "\0" . 'AppBundle\\Entity\\CeMaterialporalumnocicloportallerextracurricular' . "\0" . 'alumnocicloportallerextraid'];
        }

        return ['__isInitialized__', '' . "\0" . 'AppBundle\\Entity\\CeMaterialporalumnocicloportallerextracurricular' . "\0" . 'talla', '' . "\0" . 'AppBundle\\Entity\\CeMaterialporalumnocicloportallerextracurricular' . "\0" . 'fechaentrega', '' . "\0" . 'AppBundle\\Entity\\CeMaterialporalumnocicloportallerextracurricular' . "\0" . 'materialporalumnocicloportallerextracurricularid', '' . "\0" . 'AppBundle\\Entity\\CeMaterialporalumnocicloportallerextracurricular' . "\0" . 'materialportallerextracurricularid', '' . "\0" . 'AppBundle\\Entity\\CeMaterialporalumnocicloportallerextracurricular' . "\0" . 'alumnocicloportallerextraid'];
    }

    /**
     * 
     */
    public function __wakeup()
    {
        if ( ! $this->__isInitialized__) {
            $this->__initializer__ = function (CeMaterialporalumnocicloportallerextracurricular $proxy) {
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
    public function setTalla($talla)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setTalla', [$talla]);

        return parent::setTalla($talla);
    }

    /**
     * {@inheritDoc}
     */
    public function getTalla()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getTalla', []);

        return parent::getTalla();
    }

    /**
     * {@inheritDoc}
     */
    public function setFechaentrega($fechaentrega)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setFechaentrega', [$fechaentrega]);

        return parent::setFechaentrega($fechaentrega);
    }

    /**
     * {@inheritDoc}
     */
    public function getFechaentrega()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getFechaentrega', []);

        return parent::getFechaentrega();
    }

    /**
     * {@inheritDoc}
     */
    public function getMaterialporalumnocicloportallerextracurricularid()
    {
        if ($this->__isInitialized__ === false) {
            return (int)  parent::getMaterialporalumnocicloportallerextracurricularid();
        }


        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getMaterialporalumnocicloportallerextracurricularid', []);

        return parent::getMaterialporalumnocicloportallerextracurricularid();
    }

    /**
     * {@inheritDoc}
     */
    public function setMaterialportallerextracurricularid(\AppBundle\Entity\CeMaterialportallerextracurricular $materialportallerextracurricularid = NULL)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setMaterialportallerextracurricularid', [$materialportallerextracurricularid]);

        return parent::setMaterialportallerextracurricularid($materialportallerextracurricularid);
    }

    /**
     * {@inheritDoc}
     */
    public function getMaterialportallerextracurricularid()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getMaterialportallerextracurricularid', []);

        return parent::getMaterialportallerextracurricularid();
    }

    /**
     * {@inheritDoc}
     */
    public function setAlumnocicloportallerextraid(\AppBundle\Entity\CeAlumnocicloportallerextra $alumnocicloportallerextraid = NULL)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setAlumnocicloportallerextraid', [$alumnocicloportallerextraid]);

        return parent::setAlumnocicloportallerextraid($alumnocicloportallerextraid);
    }

    /**
     * {@inheritDoc}
     */
    public function getAlumnocicloportallerextraid()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getAlumnocicloportallerextraid', []);

        return parent::getAlumnocicloportallerextraid();
    }

}
