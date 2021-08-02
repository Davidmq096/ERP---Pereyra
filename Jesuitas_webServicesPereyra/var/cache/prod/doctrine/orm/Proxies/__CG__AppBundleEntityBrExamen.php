<?php

namespace Proxies\__CG__\AppBundle\Entity;

/**
 * DO NOT EDIT THIS FILE - IT WAS CREATED BY DOCTRINE'S PROXY GENERATOR
 */
class BrExamen extends \AppBundle\Entity\BrExamen implements \Doctrine\ORM\Proxy\Proxy
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
            return ['__isInitialized__', '' . "\0" . 'AppBundle\\Entity\\BrExamen' . "\0" . 'clave', '' . "\0" . 'AppBundle\\Entity\\BrExamen' . "\0" . 'nombre', '' . "\0" . 'AppBundle\\Entity\\BrExamen' . "\0" . 'descripcion', '' . "\0" . 'AppBundle\\Entity\\BrExamen' . "\0" . 'activo', '' . "\0" . 'AppBundle\\Entity\\BrExamen' . "\0" . 'examenid', '' . "\0" . 'AppBundle\\Entity\\BrExamen' . "\0" . 'areaid', '' . "\0" . 'AppBundle\\Entity\\BrExamen' . "\0" . 'cicloid', '' . "\0" . 'AppBundle\\Entity\\BrExamen' . "\0" . 'examenpresentacionid', '' . "\0" . 'AppBundle\\Entity\\BrExamen' . "\0" . 'gradoid', '' . "\0" . 'AppBundle\\Entity\\BrExamen' . "\0" . 'materiaid', '' . "\0" . 'AppBundle\\Entity\\BrExamen' . "\0" . 'sistemacalificacionid', '' . "\0" . 'AppBundle\\Entity\\BrExamen' . "\0" . 'tipoexamenid'];
        }

        return ['__isInitialized__', '' . "\0" . 'AppBundle\\Entity\\BrExamen' . "\0" . 'clave', '' . "\0" . 'AppBundle\\Entity\\BrExamen' . "\0" . 'nombre', '' . "\0" . 'AppBundle\\Entity\\BrExamen' . "\0" . 'descripcion', '' . "\0" . 'AppBundle\\Entity\\BrExamen' . "\0" . 'activo', '' . "\0" . 'AppBundle\\Entity\\BrExamen' . "\0" . 'examenid', '' . "\0" . 'AppBundle\\Entity\\BrExamen' . "\0" . 'areaid', '' . "\0" . 'AppBundle\\Entity\\BrExamen' . "\0" . 'cicloid', '' . "\0" . 'AppBundle\\Entity\\BrExamen' . "\0" . 'examenpresentacionid', '' . "\0" . 'AppBundle\\Entity\\BrExamen' . "\0" . 'gradoid', '' . "\0" . 'AppBundle\\Entity\\BrExamen' . "\0" . 'materiaid', '' . "\0" . 'AppBundle\\Entity\\BrExamen' . "\0" . 'sistemacalificacionid', '' . "\0" . 'AppBundle\\Entity\\BrExamen' . "\0" . 'tipoexamenid'];
    }

    /**
     * 
     */
    public function __wakeup()
    {
        if ( ! $this->__isInitialized__) {
            $this->__initializer__ = function (BrExamen $proxy) {
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
    public function setClave($clave)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setClave', [$clave]);

        return parent::setClave($clave);
    }

    /**
     * {@inheritDoc}
     */
    public function getClave()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getClave', []);

        return parent::getClave();
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
    public function getExamenid()
    {
        if ($this->__isInitialized__ === false) {
            return (int)  parent::getExamenid();
        }


        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getExamenid', []);

        return parent::getExamenid();
    }

    /**
     * {@inheritDoc}
     */
    public function setAreaid(\AppBundle\Entity\CeAreaacademica $areaid = NULL)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setAreaid', [$areaid]);

        return parent::setAreaid($areaid);
    }

    /**
     * {@inheritDoc}
     */
    public function getAreaid()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getAreaid', []);

        return parent::getAreaid();
    }

    /**
     * {@inheritDoc}
     */
    public function setCicloid(\AppBundle\Entity\Ciclo $cicloid = NULL)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setCicloid', [$cicloid]);

        return parent::setCicloid($cicloid);
    }

    /**
     * {@inheritDoc}
     */
    public function getCicloid()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getCicloid', []);

        return parent::getCicloid();
    }

    /**
     * {@inheritDoc}
     */
    public function setExamenpresentacionid(\AppBundle\Entity\BrExamenpresentacion $examenpresentacionid = NULL)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setExamenpresentacionid', [$examenpresentacionid]);

        return parent::setExamenpresentacionid($examenpresentacionid);
    }

    /**
     * {@inheritDoc}
     */
    public function getExamenpresentacionid()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getExamenpresentacionid', []);

        return parent::getExamenpresentacionid();
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
    public function setMateriaid(\AppBundle\Entity\Materia $materiaid = NULL)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setMateriaid', [$materiaid]);

        return parent::setMateriaid($materiaid);
    }

    /**
     * {@inheritDoc}
     */
    public function getMateriaid()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getMateriaid', []);

        return parent::getMateriaid();
    }

    /**
     * {@inheritDoc}
     */
    public function setSistemacalificacionid(\AppBundle\Entity\BrSistemacalificacion $sistemacalificacionid = NULL)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setSistemacalificacionid', [$sistemacalificacionid]);

        return parent::setSistemacalificacionid($sistemacalificacionid);
    }

    /**
     * {@inheritDoc}
     */
    public function getSistemacalificacionid()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getSistemacalificacionid', []);

        return parent::getSistemacalificacionid();
    }

    /**
     * {@inheritDoc}
     */
    public function setTipoexamenid(\AppBundle\Entity\BrTipoexamen $tipoexamenid = NULL)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setTipoexamenid', [$tipoexamenid]);

        return parent::setTipoexamenid($tipoexamenid);
    }

    /**
     * {@inheritDoc}
     */
    public function getTipoexamenid()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getTipoexamenid', []);

        return parent::getTipoexamenid();
    }

}
