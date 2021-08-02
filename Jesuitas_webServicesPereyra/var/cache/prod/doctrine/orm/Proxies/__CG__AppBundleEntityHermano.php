<?php

namespace Proxies\__CG__\AppBundle\Entity;

/**
 * DO NOT EDIT THIS FILE - IT WAS CREATED BY DOCTRINE'S PROXY GENERATOR
 */
class Hermano extends \AppBundle\Entity\Hermano implements \Doctrine\ORM\Proxy\Proxy
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
            return ['__isInitialized__', '' . "\0" . 'AppBundle\\Entity\\Hermano' . "\0" . 'nombre', '' . "\0" . 'AppBundle\\Entity\\Hermano' . "\0" . 'apellidopaterno', '' . "\0" . 'AppBundle\\Entity\\Hermano' . "\0" . 'apellidomaterno', '' . "\0" . 'AppBundle\\Entity\\Hermano' . "\0" . 'edad', '' . "\0" . 'AppBundle\\Entity\\Hermano' . "\0" . 'fechanacimiento', '' . "\0" . 'AppBundle\\Entity\\Hermano' . "\0" . 'curp', '' . "\0" . 'AppBundle\\Entity\\Hermano' . "\0" . 'nombreescuela', '' . "\0" . 'AppBundle\\Entity\\Hermano' . "\0" . 'generacion', '' . "\0" . 'AppBundle\\Entity\\Hermano' . "\0" . 'tipohermano', '' . "\0" . 'AppBundle\\Entity\\Hermano' . "\0" . 'hermanoid', '' . "\0" . 'AppBundle\\Entity\\Hermano' . "\0" . 'datosaspiranteid', '' . "\0" . 'AppBundle\\Entity\\Hermano' . "\0" . 'gradoid', '' . "\0" . 'AppBundle\\Entity\\Hermano' . "\0" . 'generacionid'];
        }

        return ['__isInitialized__', '' . "\0" . 'AppBundle\\Entity\\Hermano' . "\0" . 'nombre', '' . "\0" . 'AppBundle\\Entity\\Hermano' . "\0" . 'apellidopaterno', '' . "\0" . 'AppBundle\\Entity\\Hermano' . "\0" . 'apellidomaterno', '' . "\0" . 'AppBundle\\Entity\\Hermano' . "\0" . 'edad', '' . "\0" . 'AppBundle\\Entity\\Hermano' . "\0" . 'fechanacimiento', '' . "\0" . 'AppBundle\\Entity\\Hermano' . "\0" . 'curp', '' . "\0" . 'AppBundle\\Entity\\Hermano' . "\0" . 'nombreescuela', '' . "\0" . 'AppBundle\\Entity\\Hermano' . "\0" . 'generacion', '' . "\0" . 'AppBundle\\Entity\\Hermano' . "\0" . 'tipohermano', '' . "\0" . 'AppBundle\\Entity\\Hermano' . "\0" . 'hermanoid', '' . "\0" . 'AppBundle\\Entity\\Hermano' . "\0" . 'datosaspiranteid', '' . "\0" . 'AppBundle\\Entity\\Hermano' . "\0" . 'gradoid', '' . "\0" . 'AppBundle\\Entity\\Hermano' . "\0" . 'generacionid'];
    }

    /**
     * 
     */
    public function __wakeup()
    {
        if ( ! $this->__isInitialized__) {
            $this->__initializer__ = function (Hermano $proxy) {
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
    public function setApellidopaterno($apellidopaterno)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setApellidopaterno', [$apellidopaterno]);

        return parent::setApellidopaterno($apellidopaterno);
    }

    /**
     * {@inheritDoc}
     */
    public function getApellidopaterno()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getApellidopaterno', []);

        return parent::getApellidopaterno();
    }

    /**
     * {@inheritDoc}
     */
    public function setApellidomaterno($apellidomaterno)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setApellidomaterno', [$apellidomaterno]);

        return parent::setApellidomaterno($apellidomaterno);
    }

    /**
     * {@inheritDoc}
     */
    public function getApellidomaterno()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getApellidomaterno', []);

        return parent::getApellidomaterno();
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
    public function setFechanacimiento($fechanacimiento)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setFechanacimiento', [$fechanacimiento]);

        return parent::setFechanacimiento($fechanacimiento);
    }

    /**
     * {@inheritDoc}
     */
    public function getFechanacimiento()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getFechanacimiento', []);

        return parent::getFechanacimiento();
    }

    /**
     * {@inheritDoc}
     */
    public function setCurp($curp)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setCurp', [$curp]);

        return parent::setCurp($curp);
    }

    /**
     * {@inheritDoc}
     */
    public function getCurp()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getCurp', []);

        return parent::getCurp();
    }

    /**
     * {@inheritDoc}
     */
    public function setNombreescuela($nombreescuela)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setNombreescuela', [$nombreescuela]);

        return parent::setNombreescuela($nombreescuela);
    }

    /**
     * {@inheritDoc}
     */
    public function getNombreescuela()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getNombreescuela', []);

        return parent::getNombreescuela();
    }

    /**
     * {@inheritDoc}
     */
    public function setGeneracion($generacion)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setGeneracion', [$generacion]);

        return parent::setGeneracion($generacion);
    }

    /**
     * {@inheritDoc}
     */
    public function getGeneracion()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getGeneracion', []);

        return parent::getGeneracion();
    }

    /**
     * {@inheritDoc}
     */
    public function setTipohermano($tipohermano)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setTipohermano', [$tipohermano]);

        return parent::setTipohermano($tipohermano);
    }

    /**
     * {@inheritDoc}
     */
    public function getTipohermano()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getTipohermano', []);

        return parent::getTipohermano();
    }

    /**
     * {@inheritDoc}
     */
    public function getHermanoid()
    {
        if ($this->__isInitialized__ === false) {
            return (int)  parent::getHermanoid();
        }


        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getHermanoid', []);

        return parent::getHermanoid();
    }

    /**
     * {@inheritDoc}
     */
    public function setDatosaspiranteid(\AppBundle\Entity\Datoaspirante $datosaspiranteid = NULL)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setDatosaspiranteid', [$datosaspiranteid]);

        return parent::setDatosaspiranteid($datosaspiranteid);
    }

    /**
     * {@inheritDoc}
     */
    public function getDatosaspiranteid()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getDatosaspiranteid', []);

        return parent::getDatosaspiranteid();
    }

    /**
     * {@inheritDoc}
     */
    public function setGradoid(\AppBundle\Entity\Grado $gradoid = NULL)
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
    public function setGeneracionid(\AppBundle\Entity\Generacion $generacionid = NULL)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setGeneracionid', [$generacionid]);

        return parent::setGeneracionid($generacionid);
    }

    /**
     * {@inheritDoc}
     */
    public function getGeneracionid()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getGeneracionid', []);

        return parent::getGeneracionid();
    }

}
