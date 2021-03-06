<?php

namespace Proxies\__CG__\AppBundle\Entity;

/**
 * DO NOT EDIT THIS FILE - IT WAS CREATED BY DOCTRINE'S PROXY GENERATOR
 */
class CeAvisosporcaratulaarchivo extends \AppBundle\Entity\CeAvisosporcaratulaarchivo implements \Doctrine\ORM\Proxy\Proxy
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
            return ['__isInitialized__', '' . "\0" . 'AppBundle\\Entity\\CeAvisosporcaratulaarchivo' . "\0" . 'contenido', '' . "\0" . 'AppBundle\\Entity\\CeAvisosporcaratulaarchivo' . "\0" . 'size', '' . "\0" . 'AppBundle\\Entity\\CeAvisosporcaratulaarchivo' . "\0" . 'tipo', '' . "\0" . 'AppBundle\\Entity\\CeAvisosporcaratulaarchivo' . "\0" . 'nombre', '' . "\0" . 'AppBundle\\Entity\\CeAvisosporcaratulaarchivo' . "\0" . 'avisocaratulaarchivoid', '' . "\0" . 'AppBundle\\Entity\\CeAvisosporcaratulaarchivo' . "\0" . 'avisocaratulaid'];
        }

        return ['__isInitialized__', '' . "\0" . 'AppBundle\\Entity\\CeAvisosporcaratulaarchivo' . "\0" . 'contenido', '' . "\0" . 'AppBundle\\Entity\\CeAvisosporcaratulaarchivo' . "\0" . 'size', '' . "\0" . 'AppBundle\\Entity\\CeAvisosporcaratulaarchivo' . "\0" . 'tipo', '' . "\0" . 'AppBundle\\Entity\\CeAvisosporcaratulaarchivo' . "\0" . 'nombre', '' . "\0" . 'AppBundle\\Entity\\CeAvisosporcaratulaarchivo' . "\0" . 'avisocaratulaarchivoid', '' . "\0" . 'AppBundle\\Entity\\CeAvisosporcaratulaarchivo' . "\0" . 'avisocaratulaid'];
    }

    /**
     * 
     */
    public function __wakeup()
    {
        if ( ! $this->__isInitialized__) {
            $this->__initializer__ = function (CeAvisosporcaratulaarchivo $proxy) {
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
    public function setContenido($contenido)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setContenido', [$contenido]);

        return parent::setContenido($contenido);
    }

    /**
     * {@inheritDoc}
     */
    public function getContenido()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getContenido', []);

        return parent::getContenido();
    }

    /**
     * {@inheritDoc}
     */
    public function setSize($size)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setSize', [$size]);

        return parent::setSize($size);
    }

    /**
     * {@inheritDoc}
     */
    public function getSize()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getSize', []);

        return parent::getSize();
    }

    /**
     * {@inheritDoc}
     */
    public function setTipo($tipo)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setTipo', [$tipo]);

        return parent::setTipo($tipo);
    }

    /**
     * {@inheritDoc}
     */
    public function getTipo()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getTipo', []);

        return parent::getTipo();
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
    public function getAvisocaratulaarchivoid()
    {
        if ($this->__isInitialized__ === false) {
            return (int)  parent::getAvisocaratulaarchivoid();
        }


        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getAvisocaratulaarchivoid', []);

        return parent::getAvisocaratulaarchivoid();
    }

    /**
     * {@inheritDoc}
     */
    public function setAvisocaratulaid(\AppBundle\Entity\CeAvisosporcaratula $avisocaratulaid = NULL)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setAvisocaratulaid', [$avisocaratulaid]);

        return parent::setAvisocaratulaid($avisocaratulaid);
    }

    /**
     * {@inheritDoc}
     */
    public function getAvisocaratulaid()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getAvisocaratulaid', []);

        return parent::getAvisocaratulaid();
    }

}
