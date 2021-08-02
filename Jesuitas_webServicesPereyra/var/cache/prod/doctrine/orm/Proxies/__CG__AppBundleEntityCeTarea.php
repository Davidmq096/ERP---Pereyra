<?php

namespace Proxies\__CG__\AppBundle\Entity;

/**
 * DO NOT EDIT THIS FILE - IT WAS CREATED BY DOCTRINE'S PROXY GENERATOR
 */
class CeTarea extends \AppBundle\Entity\CeTarea implements \Doctrine\ORM\Proxy\Proxy
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
            return ['__isInitialized__', '' . "\0" . 'AppBundle\\Entity\\CeTarea' . "\0" . 'nombre', '' . "\0" . 'AppBundle\\Entity\\CeTarea' . "\0" . 'descripcion', '' . "\0" . 'AppBundle\\Entity\\CeTarea' . "\0" . 'captura', '' . "\0" . 'AppBundle\\Entity\\CeTarea' . "\0" . 'fechainicio', '' . "\0" . 'AppBundle\\Entity\\CeTarea' . "\0" . 'fechafin', '' . "\0" . 'AppBundle\\Entity\\CeTarea' . "\0" . 'horalimite', '' . "\0" . 'AppBundle\\Entity\\CeTarea' . "\0" . 'entregaextemporanea', '' . "\0" . 'AppBundle\\Entity\\CeTarea' . "\0" . 'tareaid', '' . "\0" . 'AppBundle\\Entity\\CeTarea' . "\0" . 'criterioevaluaciongrupoid', '' . "\0" . 'AppBundle\\Entity\\CeTarea' . "\0" . 'tipoentregaid', '' . "\0" . 'AppBundle\\Entity\\CeTarea' . "\0" . 'materiaid'];
        }

        return ['__isInitialized__', '' . "\0" . 'AppBundle\\Entity\\CeTarea' . "\0" . 'nombre', '' . "\0" . 'AppBundle\\Entity\\CeTarea' . "\0" . 'descripcion', '' . "\0" . 'AppBundle\\Entity\\CeTarea' . "\0" . 'captura', '' . "\0" . 'AppBundle\\Entity\\CeTarea' . "\0" . 'fechainicio', '' . "\0" . 'AppBundle\\Entity\\CeTarea' . "\0" . 'fechafin', '' . "\0" . 'AppBundle\\Entity\\CeTarea' . "\0" . 'horalimite', '' . "\0" . 'AppBundle\\Entity\\CeTarea' . "\0" . 'entregaextemporanea', '' . "\0" . 'AppBundle\\Entity\\CeTarea' . "\0" . 'tareaid', '' . "\0" . 'AppBundle\\Entity\\CeTarea' . "\0" . 'criterioevaluaciongrupoid', '' . "\0" . 'AppBundle\\Entity\\CeTarea' . "\0" . 'tipoentregaid', '' . "\0" . 'AppBundle\\Entity\\CeTarea' . "\0" . 'materiaid'];
    }

    /**
     * 
     */
    public function __wakeup()
    {
        if ( ! $this->__isInitialized__) {
            $this->__initializer__ = function (CeTarea $proxy) {
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
    public function setCaptura($captura)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setCaptura', [$captura]);

        return parent::setCaptura($captura);
    }

    /**
     * {@inheritDoc}
     */
    public function getCaptura()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getCaptura', []);

        return parent::getCaptura();
    }

    /**
     * {@inheritDoc}
     */
    public function setFechainicio($fechainicio)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setFechainicio', [$fechainicio]);

        return parent::setFechainicio($fechainicio);
    }

    /**
     * {@inheritDoc}
     */
    public function getFechainicio()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getFechainicio', []);

        return parent::getFechainicio();
    }

    /**
     * {@inheritDoc}
     */
    public function setFechafin($fechafin)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setFechafin', [$fechafin]);

        return parent::setFechafin($fechafin);
    }

    /**
     * {@inheritDoc}
     */
    public function getFechafin()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getFechafin', []);

        return parent::getFechafin();
    }

    /**
     * {@inheritDoc}
     */
    public function setHoralimite($horalimite)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setHoralimite', [$horalimite]);

        return parent::setHoralimite($horalimite);
    }

    /**
     * {@inheritDoc}
     */
    public function getHoralimite()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getHoralimite', []);

        return parent::getHoralimite();
    }

    /**
     * {@inheritDoc}
     */
    public function setEntregaextemporanea($entregaextemporanea)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setEntregaextemporanea', [$entregaextemporanea]);

        return parent::setEntregaextemporanea($entregaextemporanea);
    }

    /**
     * {@inheritDoc}
     */
    public function getEntregaextemporanea()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getEntregaextemporanea', []);

        return parent::getEntregaextemporanea();
    }

    /**
     * {@inheritDoc}
     */
    public function getTareaid()
    {
        if ($this->__isInitialized__ === false) {
            return (int)  parent::getTareaid();
        }


        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getTareaid', []);

        return parent::getTareaid();
    }

    /**
     * {@inheritDoc}
     */
    public function setCriterioevaluaciongrupoid(\AppBundle\Entity\CeCriterioevaluaciongrupo $criterioevaluaciongrupoid = NULL)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setCriterioevaluaciongrupoid', [$criterioevaluaciongrupoid]);

        return parent::setCriterioevaluaciongrupoid($criterioevaluaciongrupoid);
    }

    /**
     * {@inheritDoc}
     */
    public function getCriterioevaluaciongrupoid()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getCriterioevaluaciongrupoid', []);

        return parent::getCriterioevaluaciongrupoid();
    }

    /**
     * {@inheritDoc}
     */
    public function setTipoentregaid(\AppBundle\Entity\CeTipoentrega $tipoentregaid = NULL)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setTipoentregaid', [$tipoentregaid]);

        return parent::setTipoentregaid($tipoentregaid);
    }

    /**
     * {@inheritDoc}
     */
    public function getTipoentregaid()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getTipoentregaid', []);

        return parent::getTipoentregaid();
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

}