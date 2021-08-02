<?php

namespace Proxies\__CG__\AppBundle\Entity;

/**
 * DO NOT EDIT THIS FILE - IT WAS CREATED BY DOCTRINE'S PROXY GENERATOR
 */
class Formato extends \AppBundle\Entity\Formato implements \Doctrine\ORM\Proxy\Proxy
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
            return ['__isInitialized__', '' . "\0" . 'AppBundle\\Entity\\Formato' . "\0" . 'nombre', '' . "\0" . 'AppBundle\\Entity\\Formato' . "\0" . 'formatocontenido', '' . "\0" . 'AppBundle\\Entity\\Formato' . "\0" . 'formatosize', '' . "\0" . 'AppBundle\\Entity\\Formato' . "\0" . 'formatotipo', '' . "\0" . 'AppBundle\\Entity\\Formato' . "\0" . 'obligatorio', '' . "\0" . 'AppBundle\\Entity\\Formato' . "\0" . 'activo', '' . "\0" . 'AppBundle\\Entity\\Formato' . "\0" . 'formatoid', '' . "\0" . 'AppBundle\\Entity\\Formato' . "\0" . 'tipoformatoid'];
        }

        return ['__isInitialized__', '' . "\0" . 'AppBundle\\Entity\\Formato' . "\0" . 'nombre', '' . "\0" . 'AppBundle\\Entity\\Formato' . "\0" . 'formatocontenido', '' . "\0" . 'AppBundle\\Entity\\Formato' . "\0" . 'formatosize', '' . "\0" . 'AppBundle\\Entity\\Formato' . "\0" . 'formatotipo', '' . "\0" . 'AppBundle\\Entity\\Formato' . "\0" . 'obligatorio', '' . "\0" . 'AppBundle\\Entity\\Formato' . "\0" . 'activo', '' . "\0" . 'AppBundle\\Entity\\Formato' . "\0" . 'formatoid', '' . "\0" . 'AppBundle\\Entity\\Formato' . "\0" . 'tipoformatoid'];
    }

    /**
     * 
     */
    public function __wakeup()
    {
        if ( ! $this->__isInitialized__) {
            $this->__initializer__ = function (Formato $proxy) {
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
    public function setFormatocontenido($formatocontenido)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setFormatocontenido', [$formatocontenido]);

        return parent::setFormatocontenido($formatocontenido);
    }

    /**
     * {@inheritDoc}
     */
    public function getFormatocontenido()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getFormatocontenido', []);

        return parent::getFormatocontenido();
    }

    /**
     * {@inheritDoc}
     */
    public function setFormatosize($formatosize)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setFormatosize', [$formatosize]);

        return parent::setFormatosize($formatosize);
    }

    /**
     * {@inheritDoc}
     */
    public function getFormatosize()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getFormatosize', []);

        return parent::getFormatosize();
    }

    /**
     * {@inheritDoc}
     */
    public function setFormatotipo($formatotipo)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setFormatotipo', [$formatotipo]);

        return parent::setFormatotipo($formatotipo);
    }

    /**
     * {@inheritDoc}
     */
    public function getFormatotipo()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getFormatotipo', []);

        return parent::getFormatotipo();
    }

    /**
     * {@inheritDoc}
     */
    public function setObligatorio($obligatorio)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setObligatorio', [$obligatorio]);

        return parent::setObligatorio($obligatorio);
    }

    /**
     * {@inheritDoc}
     */
    public function getObligatorio()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getObligatorio', []);

        return parent::getObligatorio();
    }

    /**
     * {@inheritDoc}
     */
    public function setActivo($activo)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setActivo', [$activo]);

        return parent::setActivo($activo);
    }

    /**
     * {@inheritDoc}
     */
    public function getActivo()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getActivo', []);

        return parent::getActivo();
    }

    /**
     * {@inheritDoc}
     */
    public function getFormatoid()
    {
        if ($this->__isInitialized__ === false) {
            return (int)  parent::getFormatoid();
        }


        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getFormatoid', []);

        return parent::getFormatoid();
    }

    /**
     * {@inheritDoc}
     */
    public function setTipoformatoid(\AppBundle\Entity\Tipoformato $tipoformatoid = NULL)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setTipoformatoid', [$tipoformatoid]);

        return parent::setTipoformatoid($tipoformatoid);
    }

    /**
     * {@inheritDoc}
     */
    public function getTipoformatoid()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getTipoformatoid', []);

        return parent::getTipoformatoid();
    }

}
