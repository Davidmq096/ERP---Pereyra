<?php

namespace Proxies\__CG__\AppBundle\Entity;

/**
 * DO NOT EDIT THIS FILE - IT WAS CREATED BY DOCTRINE'S PROXY GENERATOR
 */
class CbDocumentogarantia extends \AppBundle\Entity\CbDocumentogarantia implements \Doctrine\ORM\Proxy\Proxy
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
            return ['__isInitialized__', '' . "\0" . 'AppBundle\\Entity\\CbDocumentogarantia' . "\0" . 'importe', '' . "\0" . 'AppBundle\\Entity\\CbDocumentogarantia' . "\0" . 'descripcion', '' . "\0" . 'AppBundle\\Entity\\CbDocumentogarantia' . "\0" . 'archivo', '' . "\0" . 'AppBundle\\Entity\\CbDocumentogarantia' . "\0" . 'archivosize', '' . "\0" . 'AppBundle\\Entity\\CbDocumentogarantia' . "\0" . 'archivotipo', '' . "\0" . 'AppBundle\\Entity\\CbDocumentogarantia' . "\0" . 'documentogarantiaid', '' . "\0" . 'AppBundle\\Entity\\CbDocumentogarantia' . "\0" . 'acuerdoid', '' . "\0" . 'AppBundle\\Entity\\CbDocumentogarantia' . "\0" . 'tipogarantiaid'];
        }

        return ['__isInitialized__', '' . "\0" . 'AppBundle\\Entity\\CbDocumentogarantia' . "\0" . 'importe', '' . "\0" . 'AppBundle\\Entity\\CbDocumentogarantia' . "\0" . 'descripcion', '' . "\0" . 'AppBundle\\Entity\\CbDocumentogarantia' . "\0" . 'archivo', '' . "\0" . 'AppBundle\\Entity\\CbDocumentogarantia' . "\0" . 'archivosize', '' . "\0" . 'AppBundle\\Entity\\CbDocumentogarantia' . "\0" . 'archivotipo', '' . "\0" . 'AppBundle\\Entity\\CbDocumentogarantia' . "\0" . 'documentogarantiaid', '' . "\0" . 'AppBundle\\Entity\\CbDocumentogarantia' . "\0" . 'acuerdoid', '' . "\0" . 'AppBundle\\Entity\\CbDocumentogarantia' . "\0" . 'tipogarantiaid'];
    }

    /**
     * 
     */
    public function __wakeup()
    {
        if ( ! $this->__isInitialized__) {
            $this->__initializer__ = function (CbDocumentogarantia $proxy) {
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
    public function setImporte($importe)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setImporte', [$importe]);

        return parent::setImporte($importe);
    }

    /**
     * {@inheritDoc}
     */
    public function getImporte()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getImporte', []);

        return parent::getImporte();
    }

    /**
     * {@inheritDoc}
     */
    public function setDescripcion($descripcion)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setDescripcion', [$descripcion]);

        return parent::setDescripcion($descripcion);
    }

    /**
     * {@inheritDoc}
     */
    public function getDescripcion()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getDescripcion', []);

        return parent::getDescripcion();
    }

    /**
     * {@inheritDoc}
     */
    public function setArchivo($archivo)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setArchivo', [$archivo]);

        return parent::setArchivo($archivo);
    }

    /**
     * {@inheritDoc}
     */
    public function getArchivo()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getArchivo', []);

        return parent::getArchivo();
    }

    /**
     * {@inheritDoc}
     */
    public function setArchivosize($archivosize)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setArchivosize', [$archivosize]);

        return parent::setArchivosize($archivosize);
    }

    /**
     * {@inheritDoc}
     */
    public function getArchivosize()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getArchivosize', []);

        return parent::getArchivosize();
    }

    /**
     * {@inheritDoc}
     */
    public function setArchivotipo($archivotipo)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setArchivotipo', [$archivotipo]);

        return parent::setArchivotipo($archivotipo);
    }

    /**
     * {@inheritDoc}
     */
    public function getArchivotipo()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getArchivotipo', []);

        return parent::getArchivotipo();
    }

    /**
     * {@inheritDoc}
     */
    public function getDocumentogarantiaid()
    {
        if ($this->__isInitialized__ === false) {
            return (int)  parent::getDocumentogarantiaid();
        }


        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getDocumentogarantiaid', []);

        return parent::getDocumentogarantiaid();
    }

    /**
     * {@inheritDoc}
     */
    public function setAcuerdoid(\AppBundle\Entity\CbAcuerdo $acuerdoid = NULL)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setAcuerdoid', [$acuerdoid]);

        return parent::setAcuerdoid($acuerdoid);
    }

    /**
     * {@inheritDoc}
     */
    public function getAcuerdoid()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getAcuerdoid', []);

        return parent::getAcuerdoid();
    }

    /**
     * {@inheritDoc}
     */
    public function setTipogarantiaid(\AppBundle\Entity\CbTipogarantia $tipogarantiaid = NULL)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setTipogarantiaid', [$tipogarantiaid]);

        return parent::setTipogarantiaid($tipogarantiaid);
    }

    /**
     * {@inheritDoc}
     */
    public function getTipogarantiaid()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getTipogarantiaid', []);

        return parent::getTipogarantiaid();
    }

}
