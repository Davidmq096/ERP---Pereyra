<?php

namespace Proxies\__CG__\AppBundle\Entity;

/**
 * DO NOT EDIT THIS FILE - IT WAS CREATED BY DOCTRINE'S PROXY GENERATOR
 */
class Encuesta extends \AppBundle\Entity\Encuesta implements \Doctrine\ORM\Proxy\Proxy
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
            return ['__isInitialized__', '' . "\0" . 'AppBundle\\Entity\\Encuesta' . "\0" . 'nombre', '' . "\0" . 'AppBundle\\Entity\\Encuesta' . "\0" . 'parentesco', '' . "\0" . 'AppBundle\\Entity\\Encuesta' . "\0" . 'eleccion', '' . "\0" . 'AppBundle\\Entity\\Encuesta' . "\0" . 'correo', '' . "\0" . 'AppBundle\\Entity\\Encuesta' . "\0" . 'sexo', '' . "\0" . 'AppBundle\\Entity\\Encuesta' . "\0" . 'edad', '' . "\0" . 'AppBundle\\Entity\\Encuesta' . "\0" . 'colonia', '' . "\0" . 'AppBundle\\Entity\\Encuesta' . "\0" . 'otromedio', '' . "\0" . 'AppBundle\\Entity\\Encuesta' . "\0" . 'encuestaid'];
        }

        return ['__isInitialized__', '' . "\0" . 'AppBundle\\Entity\\Encuesta' . "\0" . 'nombre', '' . "\0" . 'AppBundle\\Entity\\Encuesta' . "\0" . 'parentesco', '' . "\0" . 'AppBundle\\Entity\\Encuesta' . "\0" . 'eleccion', '' . "\0" . 'AppBundle\\Entity\\Encuesta' . "\0" . 'correo', '' . "\0" . 'AppBundle\\Entity\\Encuesta' . "\0" . 'sexo', '' . "\0" . 'AppBundle\\Entity\\Encuesta' . "\0" . 'edad', '' . "\0" . 'AppBundle\\Entity\\Encuesta' . "\0" . 'colonia', '' . "\0" . 'AppBundle\\Entity\\Encuesta' . "\0" . 'otromedio', '' . "\0" . 'AppBundle\\Entity\\Encuesta' . "\0" . 'encuestaid'];
    }

    /**
     * 
     */
    public function __wakeup()
    {
        if ( ! $this->__isInitialized__) {
            $this->__initializer__ = function (Encuesta $proxy) {
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
    public function setParentesco($parentesco)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setParentesco', [$parentesco]);

        return parent::setParentesco($parentesco);
    }

    /**
     * {@inheritDoc}
     */
    public function getParentesco()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getParentesco', []);

        return parent::getParentesco();
    }

    /**
     * {@inheritDoc}
     */
    public function setEleccion($eleccion)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setEleccion', [$eleccion]);

        return parent::setEleccion($eleccion);
    }

    /**
     * {@inheritDoc}
     */
    public function getEleccion()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getEleccion', []);

        return parent::getEleccion();
    }

    /**
     * {@inheritDoc}
     */
    public function setCorreo($correo)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setCorreo', [$correo]);

        return parent::setCorreo($correo);
    }

    /**
     * {@inheritDoc}
     */
    public function getCorreo()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getCorreo', []);

        return parent::getCorreo();
    }

    /**
     * {@inheritDoc}
     */
    public function setSexo($sexo)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setSexo', [$sexo]);

        return parent::setSexo($sexo);
    }

    /**
     * {@inheritDoc}
     */
    public function getSexo()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getSexo', []);

        return parent::getSexo();
    }

    /**
     * {@inheritDoc}
     */
    public function setEdad($edad)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setEdad', [$edad]);

        return parent::setEdad($edad);
    }

    /**
     * {@inheritDoc}
     */
    public function getEdad()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getEdad', []);

        return parent::getEdad();
    }

    /**
     * {@inheritDoc}
     */
    public function setColonia($colonia)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setColonia', [$colonia]);

        return parent::setColonia($colonia);
    }

    /**
     * {@inheritDoc}
     */
    public function getColonia()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getColonia', []);

        return parent::getColonia();
    }

    /**
     * {@inheritDoc}
     */
    public function setOtromedio($otromedio)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setOtromedio', [$otromedio]);

        return parent::setOtromedio($otromedio);
    }

    /**
     * {@inheritDoc}
     */
    public function getOtromedio()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getOtromedio', []);

        return parent::getOtromedio();
    }

    /**
     * {@inheritDoc}
     */
    public function getEncuestaid()
    {
        if ($this->__isInitialized__ === false) {
            return (int)  parent::getEncuestaid();
        }


        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getEncuestaid', []);

        return parent::getEncuestaid();
    }

}
