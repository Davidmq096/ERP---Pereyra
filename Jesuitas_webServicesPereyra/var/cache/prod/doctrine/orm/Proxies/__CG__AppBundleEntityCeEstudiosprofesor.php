<?php

namespace Proxies\__CG__\AppBundle\Entity;

/**
 * DO NOT EDIT THIS FILE - IT WAS CREATED BY DOCTRINE'S PROXY GENERATOR
 */
class CeEstudiosprofesor extends \AppBundle\Entity\CeEstudiosprofesor implements \Doctrine\ORM\Proxy\Proxy
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
            return ['__isInitialized__', '' . "\0" . 'AppBundle\\Entity\\CeEstudiosprofesor' . "\0" . 'institucioneducativa', '' . "\0" . 'AppBundle\\Entity\\CeEstudiosprofesor' . "\0" . 'cedulaprofesional', '' . "\0" . 'AppBundle\\Entity\\CeEstudiosprofesor' . "\0" . 'titulo', '' . "\0" . 'AppBundle\\Entity\\CeEstudiosprofesor' . "\0" . 'estudioprofesorid', '' . "\0" . 'AppBundle\\Entity\\CeEstudiosprofesor' . "\0" . 'estatusestudioid', '' . "\0" . 'AppBundle\\Entity\\CeEstudiosprofesor' . "\0" . 'profesorid', '' . "\0" . 'AppBundle\\Entity\\CeEstudiosprofesor' . "\0" . 'escolaridadid'];
        }

        return ['__isInitialized__', '' . "\0" . 'AppBundle\\Entity\\CeEstudiosprofesor' . "\0" . 'institucioneducativa', '' . "\0" . 'AppBundle\\Entity\\CeEstudiosprofesor' . "\0" . 'cedulaprofesional', '' . "\0" . 'AppBundle\\Entity\\CeEstudiosprofesor' . "\0" . 'titulo', '' . "\0" . 'AppBundle\\Entity\\CeEstudiosprofesor' . "\0" . 'estudioprofesorid', '' . "\0" . 'AppBundle\\Entity\\CeEstudiosprofesor' . "\0" . 'estatusestudioid', '' . "\0" . 'AppBundle\\Entity\\CeEstudiosprofesor' . "\0" . 'profesorid', '' . "\0" . 'AppBundle\\Entity\\CeEstudiosprofesor' . "\0" . 'escolaridadid'];
    }

    /**
     * 
     */
    public function __wakeup()
    {
        if ( ! $this->__isInitialized__) {
            $this->__initializer__ = function (CeEstudiosprofesor $proxy) {
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
    public function setInstitucioneducativa($institucioneducativa)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setInstitucioneducativa', [$institucioneducativa]);

        return parent::setInstitucioneducativa($institucioneducativa);
    }

    /**
     * {@inheritDoc}
     */
    public function getInstitucioneducativa()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getInstitucioneducativa', []);

        return parent::getInstitucioneducativa();
    }

    /**
     * {@inheritDoc}
     */
    public function setCedulaprofesional($cedulaprofesional)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setCedulaprofesional', [$cedulaprofesional]);

        return parent::setCedulaprofesional($cedulaprofesional);
    }

    /**
     * {@inheritDoc}
     */
    public function getCedulaprofesional()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getCedulaprofesional', []);

        return parent::getCedulaprofesional();
    }

    /**
     * {@inheritDoc}
     */
    public function setTitulo($titulo)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setTitulo', [$titulo]);

        return parent::setTitulo($titulo);
    }

    /**
     * {@inheritDoc}
     */
    public function getTitulo()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getTitulo', []);

        return parent::getTitulo();
    }

    /**
     * {@inheritDoc}
     */
    public function getEstudioprofesorid()
    {
        if ($this->__isInitialized__ === false) {
            return (int)  parent::getEstudioprofesorid();
        }


        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getEstudioprofesorid', []);

        return parent::getEstudioprofesorid();
    }

    /**
     * {@inheritDoc}
     */
    public function setEstatusestudioid(\AppBundle\Entity\CeEstatusestudio $estatusestudioid = NULL)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setEstatusestudioid', [$estatusestudioid]);

        return parent::setEstatusestudioid($estatusestudioid);
    }

    /**
     * {@inheritDoc}
     */
    public function getEstatusestudioid()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getEstatusestudioid', []);

        return parent::getEstatusestudioid();
    }

    /**
     * {@inheritDoc}
     */
    public function setProfesorid(\AppBundle\Entity\CeProfesor $profesorid = NULL)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setProfesorid', [$profesorid]);

        return parent::setProfesorid($profesorid);
    }

    /**
     * {@inheritDoc}
     */
    public function getProfesorid()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getProfesorid', []);

        return parent::getProfesorid();
    }

    /**
     * {@inheritDoc}
     */
    public function setEscolaridadid(\AppBundle\Entity\Escolaridad $escolaridadid = NULL)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setEscolaridadid', [$escolaridadid]);

        return parent::setEscolaridadid($escolaridadid);
    }

    /**
     * {@inheritDoc}
     */
    public function getEscolaridadid()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getEscolaridadid', []);

        return parent::getEscolaridadid();
    }

}