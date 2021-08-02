<?php

namespace Proxies\__CG__\AppBundle\Entity;

/**
 * DO NOT EDIT THIS FILE - IT WAS CREATED BY DOCTRINE'S PROXY GENERATOR
 */
class CjConcepto extends \AppBundle\Entity\CjConcepto implements \Doctrine\ORM\Proxy\Proxy
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
            return ['__isInitialized__', '' . "\0" . 'AppBundle\\Entity\\CjConcepto' . "\0" . 'clave', '' . "\0" . 'AppBundle\\Entity\\CjConcepto' . "\0" . 'alias', '' . "\0" . 'AppBundle\\Entity\\CjConcepto' . "\0" . 'nombre', '' . "\0" . 'AppBundle\\Entity\\CjConcepto' . "\0" . 'tipomovimiento', '' . "\0" . 'AppBundle\\Entity\\CjConcepto' . "\0" . 'clasificacion', '' . "\0" . 'AppBundle\\Entity\\CjConcepto' . "\0" . 'esdiverso', '' . "\0" . 'AppBundle\\Entity\\CjConcepto' . "\0" . 'escurricular', '' . "\0" . 'AppBundle\\Entity\\CjConcepto' . "\0" . 'esfijo', '' . "\0" . 'AppBundle\\Entity\\CjConcepto' . "\0" . 'gravado', '' . "\0" . 'AppBundle\\Entity\\CjConcepto' . "\0" . 'tipoasignacion', '' . "\0" . 'AppBundle\\Entity\\CjConcepto' . "\0" . 'activo', '' . "\0" . 'AppBundle\\Entity\\CjConcepto' . "\0" . 'conceptoid', '' . "\0" . 'AppBundle\\Entity\\CjConcepto' . "\0" . 'centrocostoid', '' . "\0" . 'AppBundle\\Entity\\CjConcepto' . "\0" . 'empresaid'];
        }

        return ['__isInitialized__', '' . "\0" . 'AppBundle\\Entity\\CjConcepto' . "\0" . 'clave', '' . "\0" . 'AppBundle\\Entity\\CjConcepto' . "\0" . 'alias', '' . "\0" . 'AppBundle\\Entity\\CjConcepto' . "\0" . 'nombre', '' . "\0" . 'AppBundle\\Entity\\CjConcepto' . "\0" . 'tipomovimiento', '' . "\0" . 'AppBundle\\Entity\\CjConcepto' . "\0" . 'clasificacion', '' . "\0" . 'AppBundle\\Entity\\CjConcepto' . "\0" . 'esdiverso', '' . "\0" . 'AppBundle\\Entity\\CjConcepto' . "\0" . 'escurricular', '' . "\0" . 'AppBundle\\Entity\\CjConcepto' . "\0" . 'esfijo', '' . "\0" . 'AppBundle\\Entity\\CjConcepto' . "\0" . 'gravado', '' . "\0" . 'AppBundle\\Entity\\CjConcepto' . "\0" . 'tipoasignacion', '' . "\0" . 'AppBundle\\Entity\\CjConcepto' . "\0" . 'activo', '' . "\0" . 'AppBundle\\Entity\\CjConcepto' . "\0" . 'conceptoid', '' . "\0" . 'AppBundle\\Entity\\CjConcepto' . "\0" . 'centrocostoid', '' . "\0" . 'AppBundle\\Entity\\CjConcepto' . "\0" . 'empresaid'];
    }

    /**
     * 
     */
    public function __wakeup()
    {
        if ( ! $this->__isInitialized__) {
            $this->__initializer__ = function (CjConcepto $proxy) {
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
    public function setAlias($alias)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setAlias', [$alias]);

        return parent::setAlias($alias);
    }

    /**
     * {@inheritDoc}
     */
    public function getAlias()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getAlias', []);

        return parent::getAlias();
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
    public function setTipomovimiento($tipomovimiento)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setTipomovimiento', [$tipomovimiento]);

        return parent::setTipomovimiento($tipomovimiento);
    }

    /**
     * {@inheritDoc}
     */
    public function getTipomovimiento()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getTipomovimiento', []);

        return parent::getTipomovimiento();
    }

    /**
     * {@inheritDoc}
     */
    public function setClasificacion($clasificacion)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setClasificacion', [$clasificacion]);

        return parent::setClasificacion($clasificacion);
    }

    /**
     * {@inheritDoc}
     */
    public function getClasificacion()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getClasificacion', []);

        return parent::getClasificacion();
    }

    /**
     * {@inheritDoc}
     */
    public function setEsdiverso($esdiverso)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setEsdiverso', [$esdiverso]);

        return parent::setEsdiverso($esdiverso);
    }

    /**
     * {@inheritDoc}
     */
    public function getEsdiverso()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getEsdiverso', []);

        return parent::getEsdiverso();
    }

    /**
     * {@inheritDoc}
     */
    public function setEscurricular($escurricular)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setEscurricular', [$escurricular]);

        return parent::setEscurricular($escurricular);
    }

    /**
     * {@inheritDoc}
     */
    public function getEscurricular()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getEscurricular', []);

        return parent::getEscurricular();
    }

    /**
     * {@inheritDoc}
     */
    public function setEsfijo($esfijo)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setEsfijo', [$esfijo]);

        return parent::setEsfijo($esfijo);
    }

    /**
     * {@inheritDoc}
     */
    public function getEsfijo()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getEsfijo', []);

        return parent::getEsfijo();
    }

    /**
     * {@inheritDoc}
     */
    public function setGravado($gravado)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setGravado', [$gravado]);

        return parent::setGravado($gravado);
    }

    /**
     * {@inheritDoc}
     */
    public function getGravado()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getGravado', []);

        return parent::getGravado();
    }

    /**
     * {@inheritDoc}
     */
    public function setTipoasignacion($tipoasignacion)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setTipoasignacion', [$tipoasignacion]);

        return parent::setTipoasignacion($tipoasignacion);
    }

    /**
     * {@inheritDoc}
     */
    public function getTipoasignacion()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getTipoasignacion', []);

        return parent::getTipoasignacion();
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
    public function getConceptoid()
    {
        if ($this->__isInitialized__ === false) {
            return (int)  parent::getConceptoid();
        }


        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getConceptoid', []);

        return parent::getConceptoid();
    }

    /**
     * {@inheritDoc}
     */
    public function setCentrocostoid(\AppBundle\Entity\CjCentrocosto $centrocostoid = NULL)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setCentrocostoid', [$centrocostoid]);

        return parent::setCentrocostoid($centrocostoid);
    }

    /**
     * {@inheritDoc}
     */
    public function getCentrocostoid()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getCentrocostoid', []);

        return parent::getCentrocostoid();
    }

    /**
     * {@inheritDoc}
     */
    public function setEmpresaid(\AppBundle\Entity\CjEmpresa $empresaid = NULL)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setEmpresaid', [$empresaid]);

        return parent::setEmpresaid($empresaid);
    }

    /**
     * {@inheritDoc}
     */
    public function getEmpresaid()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getEmpresaid', []);

        return parent::getEmpresaid();
    }

}
