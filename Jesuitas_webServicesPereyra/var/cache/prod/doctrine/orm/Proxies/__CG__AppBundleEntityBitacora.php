<?php

namespace Proxies\__CG__\AppBundle\Entity;

/**
 * DO NOT EDIT THIS FILE - IT WAS CREATED BY DOCTRINE'S PROXY GENERATOR
 */
class Bitacora extends \AppBundle\Entity\Bitacora implements \Doctrine\ORM\Proxy\Proxy
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
            return ['__isInitialized__', '' . "\0" . 'AppBundle\\Entity\\Bitacora' . "\0" . 'usuario', '' . "\0" . 'AppBundle\\Entity\\Bitacora' . "\0" . 'direccionip', '' . "\0" . 'AppBundle\\Entity\\Bitacora' . "\0" . 'accion', '' . "\0" . 'AppBundle\\Entity\\Bitacora' . "\0" . 'bitacora', '' . "\0" . 'AppBundle\\Entity\\Bitacora' . "\0" . 'registro', '' . "\0" . 'AppBundle\\Entity\\Bitacora' . "\0" . 'bitacoraid', '' . "\0" . 'AppBundle\\Entity\\Bitacora' . "\0" . 'pantallaid'];
        }

        return ['__isInitialized__', '' . "\0" . 'AppBundle\\Entity\\Bitacora' . "\0" . 'usuario', '' . "\0" . 'AppBundle\\Entity\\Bitacora' . "\0" . 'direccionip', '' . "\0" . 'AppBundle\\Entity\\Bitacora' . "\0" . 'accion', '' . "\0" . 'AppBundle\\Entity\\Bitacora' . "\0" . 'bitacora', '' . "\0" . 'AppBundle\\Entity\\Bitacora' . "\0" . 'registro', '' . "\0" . 'AppBundle\\Entity\\Bitacora' . "\0" . 'bitacoraid', '' . "\0" . 'AppBundle\\Entity\\Bitacora' . "\0" . 'pantallaid'];
    }

    /**
     * 
     */
    public function __wakeup()
    {
        if ( ! $this->__isInitialized__) {
            $this->__initializer__ = function (Bitacora $proxy) {
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
    public function setUsuario($usuario)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setUsuario', [$usuario]);

        return parent::setUsuario($usuario);
    }

    /**
     * {@inheritDoc}
     */
    public function getUsuario()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getUsuario', []);

        return parent::getUsuario();
    }

    /**
     * {@inheritDoc}
     */
    public function setDireccionip($direccionip)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setDireccionip', [$direccionip]);

        return parent::setDireccionip($direccionip);
    }

    /**
     * {@inheritDoc}
     */
    public function getDireccionip()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getDireccionip', []);

        return parent::getDireccionip();
    }

    /**
     * {@inheritDoc}
     */
    public function setAccion($accion)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setAccion', [$accion]);

        return parent::setAccion($accion);
    }

    /**
     * {@inheritDoc}
     */
    public function getAccion()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getAccion', []);

        return parent::getAccion();
    }

    /**
     * {@inheritDoc}
     */
    public function setBitacora($bitacora)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setBitacora', [$bitacora]);

        return parent::setBitacora($bitacora);
    }

    /**
     * {@inheritDoc}
     */
    public function getBitacora()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getBitacora', []);

        return parent::getBitacora();
    }

    /**
     * {@inheritDoc}
     */
    public function setRegistro($registro)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setRegistro', [$registro]);

        return parent::setRegistro($registro);
    }

    /**
     * {@inheritDoc}
     */
    public function getRegistro()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getRegistro', []);

        return parent::getRegistro();
    }

    /**
     * {@inheritDoc}
     */
    public function getBitacoraid()
    {
        if ($this->__isInitialized__ === false) {
            return (int)  parent::getBitacoraid();
        }


        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getBitacoraid', []);

        return parent::getBitacoraid();
    }

    /**
     * {@inheritDoc}
     */
    public function setPantallaid(\AppBundle\Entity\Pantalla $pantallaid = NULL)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setPantallaid', [$pantallaid]);

        return parent::setPantallaid($pantallaid);
    }

    /**
     * {@inheritDoc}
     */
    public function getPantallaid()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getPantallaid', []);

        return parent::getPantallaid();
    }

}