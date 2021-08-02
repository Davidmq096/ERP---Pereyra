<?php

namespace Proxies\__CG__\AppBundle\Entity;

/**
 * DO NOT EDIT THIS FILE - IT WAS CREATED BY DOCTRINE'S PROXY GENERATOR
 */
class Escuelaprocedencia extends \AppBundle\Entity\Escuelaprocedencia implements \Doctrine\ORM\Proxy\Proxy
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
            return ['__isInitialized__', '' . "\0" . 'AppBundle\\Entity\\Escuelaprocedencia' . "\0" . 'nombre', '' . "\0" . 'AppBundle\\Entity\\Escuelaprocedencia' . "\0" . 'municipio', '' . "\0" . 'AppBundle\\Entity\\Escuelaprocedencia' . "\0" . 'causaseparacion', '' . "\0" . 'AppBundle\\Entity\\Escuelaprocedencia' . "\0" . 'seccion', '' . "\0" . 'AppBundle\\Entity\\Escuelaprocedencia' . "\0" . 'gradoinicio', '' . "\0" . 'AppBundle\\Entity\\Escuelaprocedencia' . "\0" . 'gradofin', '' . "\0" . 'AppBundle\\Entity\\Escuelaprocedencia' . "\0" . 'matricula', '' . "\0" . 'AppBundle\\Entity\\Escuelaprocedencia' . "\0" . 'escuelaprocedenciaid', '' . "\0" . 'AppBundle\\Entity\\Escuelaprocedencia' . "\0" . 'escuelajesuitaid', '' . "\0" . 'AppBundle\\Entity\\Escuelaprocedencia' . "\0" . 'datoaspiranteid'];
        }

        return ['__isInitialized__', '' . "\0" . 'AppBundle\\Entity\\Escuelaprocedencia' . "\0" . 'nombre', '' . "\0" . 'AppBundle\\Entity\\Escuelaprocedencia' . "\0" . 'municipio', '' . "\0" . 'AppBundle\\Entity\\Escuelaprocedencia' . "\0" . 'causaseparacion', '' . "\0" . 'AppBundle\\Entity\\Escuelaprocedencia' . "\0" . 'seccion', '' . "\0" . 'AppBundle\\Entity\\Escuelaprocedencia' . "\0" . 'gradoinicio', '' . "\0" . 'AppBundle\\Entity\\Escuelaprocedencia' . "\0" . 'gradofin', '' . "\0" . 'AppBundle\\Entity\\Escuelaprocedencia' . "\0" . 'matricula', '' . "\0" . 'AppBundle\\Entity\\Escuelaprocedencia' . "\0" . 'escuelaprocedenciaid', '' . "\0" . 'AppBundle\\Entity\\Escuelaprocedencia' . "\0" . 'escuelajesuitaid', '' . "\0" . 'AppBundle\\Entity\\Escuelaprocedencia' . "\0" . 'datoaspiranteid'];
    }

    /**
     * 
     */
    public function __wakeup()
    {
        if ( ! $this->__isInitialized__) {
            $this->__initializer__ = function (Escuelaprocedencia $proxy) {
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
    public function setMunicipio($municipio)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setMunicipio', [$municipio]);

        return parent::setMunicipio($municipio);
    }

    /**
     * {@inheritDoc}
     */
    public function getMunicipio()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getMunicipio', []);

        return parent::getMunicipio();
    }

    /**
     * {@inheritDoc}
     */
    public function setCausaseparacion($causaseparacion)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setCausaseparacion', [$causaseparacion]);

        return parent::setCausaseparacion($causaseparacion);
    }

    /**
     * {@inheritDoc}
     */
    public function getCausaseparacion()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getCausaseparacion', []);

        return parent::getCausaseparacion();
    }

    /**
     * {@inheritDoc}
     */
    public function setSeccion($seccion)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setSeccion', [$seccion]);

        return parent::setSeccion($seccion);
    }

    /**
     * {@inheritDoc}
     */
    public function getSeccion()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getSeccion', []);

        return parent::getSeccion();
    }

    /**
     * {@inheritDoc}
     */
    public function setGradoinicio($gradoinicio)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setGradoinicio', [$gradoinicio]);

        return parent::setGradoinicio($gradoinicio);
    }

    /**
     * {@inheritDoc}
     */
    public function getGradoinicio()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getGradoinicio', []);

        return parent::getGradoinicio();
    }

    /**
     * {@inheritDoc}
     */
    public function setGradofin($gradofin)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setGradofin', [$gradofin]);

        return parent::setGradofin($gradofin);
    }

    /**
     * {@inheritDoc}
     */
    public function getGradofin()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getGradofin', []);

        return parent::getGradofin();
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
    public function getEscuelaprocedenciaid()
    {
        if ($this->__isInitialized__ === false) {
            return (int)  parent::getEscuelaprocedenciaid();
        }


        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getEscuelaprocedenciaid', []);

        return parent::getEscuelaprocedenciaid();
    }

    /**
     * {@inheritDoc}
     */
    public function setEscuelajesuitaid(\AppBundle\Entity\Escuelajesuita $escuelajesuitaid = NULL)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setEscuelajesuitaid', [$escuelajesuitaid]);

        return parent::setEscuelajesuitaid($escuelajesuitaid);
    }

    /**
     * {@inheritDoc}
     */
    public function getEscuelajesuitaid()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getEscuelajesuitaid', []);

        return parent::getEscuelajesuitaid();
    }

    /**
     * {@inheritDoc}
     */
    public function setDatoaspiranteid(\AppBundle\Entity\Datoaspirante $datoaspiranteid = NULL)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setDatoaspiranteid', [$datoaspiranteid]);

        return parent::setDatoaspiranteid($datoaspiranteid);
    }

    /**
     * {@inheritDoc}
     */
    public function getDatoaspiranteid()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getDatoaspiranteid', []);

        return parent::getDatoaspiranteid();
    }

}
