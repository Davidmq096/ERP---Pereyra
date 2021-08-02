<?php

namespace Proxies\__CG__\AppBundle\Entity;

/**
 * DO NOT EDIT THIS FILE - IT WAS CREATED BY DOCTRINE'S PROXY GENERATOR
 */
class CeAsistenciapordia extends \AppBundle\Entity\CeAsistenciapordia implements \Doctrine\ORM\Proxy\Proxy
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
            return ['__isInitialized__', '' . "\0" . 'AppBundle\\Entity\\CeAsistenciapordia' . "\0" . 'fecha', '' . "\0" . 'AppBundle\\Entity\\CeAsistenciapordia' . "\0" . 'hora', '' . "\0" . 'AppBundle\\Entity\\CeAsistenciapordia' . "\0" . 'ignorar', '' . "\0" . 'AppBundle\\Entity\\CeAsistenciapordia' . "\0" . 'asistenciapordiaid', '' . "\0" . 'AppBundle\\Entity\\CeAsistenciapordia' . "\0" . 'alumnoporcicloid', '' . "\0" . 'AppBundle\\Entity\\CeAsistenciapordia' . "\0" . 'estatusinasistenciaid', '' . "\0" . 'AppBundle\\Entity\\CeAsistenciapordia' . "\0" . 'grupoid', '' . "\0" . 'AppBundle\\Entity\\CeAsistenciapordia' . "\0" . 'periodoevaluacionid', '' . "\0" . 'AppBundle\\Entity\\CeAsistenciapordia' . "\0" . 'tipoasistenciaid', '' . "\0" . 'AppBundle\\Entity\\CeAsistenciapordia' . "\0" . 'usuarioid'];
        }

        return ['__isInitialized__', '' . "\0" . 'AppBundle\\Entity\\CeAsistenciapordia' . "\0" . 'fecha', '' . "\0" . 'AppBundle\\Entity\\CeAsistenciapordia' . "\0" . 'hora', '' . "\0" . 'AppBundle\\Entity\\CeAsistenciapordia' . "\0" . 'ignorar', '' . "\0" . 'AppBundle\\Entity\\CeAsistenciapordia' . "\0" . 'asistenciapordiaid', '' . "\0" . 'AppBundle\\Entity\\CeAsistenciapordia' . "\0" . 'alumnoporcicloid', '' . "\0" . 'AppBundle\\Entity\\CeAsistenciapordia' . "\0" . 'estatusinasistenciaid', '' . "\0" . 'AppBundle\\Entity\\CeAsistenciapordia' . "\0" . 'grupoid', '' . "\0" . 'AppBundle\\Entity\\CeAsistenciapordia' . "\0" . 'periodoevaluacionid', '' . "\0" . 'AppBundle\\Entity\\CeAsistenciapordia' . "\0" . 'tipoasistenciaid', '' . "\0" . 'AppBundle\\Entity\\CeAsistenciapordia' . "\0" . 'usuarioid'];
    }

    /**
     * 
     */
    public function __wakeup()
    {
        if ( ! $this->__isInitialized__) {
            $this->__initializer__ = function (CeAsistenciapordia $proxy) {
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
    public function setFecha($fecha)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setFecha', [$fecha]);

        return parent::setFecha($fecha);
    }

    /**
     * {@inheritDoc}
     */
    public function getFecha()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getFecha', []);

        return parent::getFecha();
    }

    /**
     * {@inheritDoc}
     */
    public function setHora($hora)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setHora', [$hora]);

        return parent::setHora($hora);
    }

    /**
     * {@inheritDoc}
     */
    public function getHora()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getHora', []);

        return parent::getHora();
    }

    /**
     * {@inheritDoc}
     */
    public function setIgnorar($ignorar)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setIgnorar', [$ignorar]);

        return parent::setIgnorar($ignorar);
    }

    /**
     * {@inheritDoc}
     */
    public function getIgnorar()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getIgnorar', []);

        return parent::getIgnorar();
    }

    /**
     * {@inheritDoc}
     */
    public function getAsistenciapordiaid()
    {
        if ($this->__isInitialized__ === false) {
            return (int)  parent::getAsistenciapordiaid();
        }


        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getAsistenciapordiaid', []);

        return parent::getAsistenciapordiaid();
    }

    /**
     * {@inheritDoc}
     */
    public function setAlumnoporcicloid(\AppBundle\Entity\CeAlumnoporciclo $alumnoporcicloid = NULL)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setAlumnoporcicloid', [$alumnoporcicloid]);

        return parent::setAlumnoporcicloid($alumnoporcicloid);
    }

    /**
     * {@inheritDoc}
     */
    public function getAlumnoporcicloid()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getAlumnoporcicloid', []);

        return parent::getAlumnoporcicloid();
    }

    /**
     * {@inheritDoc}
     */
    public function setEstatusinasistenciaid(\AppBundle\Entity\CeEstatusinasistencia $estatusinasistenciaid = NULL)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setEstatusinasistenciaid', [$estatusinasistenciaid]);

        return parent::setEstatusinasistenciaid($estatusinasistenciaid);
    }

    /**
     * {@inheritDoc}
     */
    public function getEstatusinasistenciaid()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getEstatusinasistenciaid', []);

        return parent::getEstatusinasistenciaid();
    }

    /**
     * {@inheritDoc}
     */
    public function setGrupoid(\AppBundle\Entity\CeGrupo $grupoid = NULL)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setGrupoid', [$grupoid]);

        return parent::setGrupoid($grupoid);
    }

    /**
     * {@inheritDoc}
     */
    public function getGrupoid()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getGrupoid', []);

        return parent::getGrupoid();
    }

    /**
     * {@inheritDoc}
     */
    public function setPeriodoevaluacionid(\AppBundle\Entity\CePeriodoevaluacion $periodoevaluacionid = NULL)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setPeriodoevaluacionid', [$periodoevaluacionid]);

        return parent::setPeriodoevaluacionid($periodoevaluacionid);
    }

    /**
     * {@inheritDoc}
     */
    public function getPeriodoevaluacionid()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getPeriodoevaluacionid', []);

        return parent::getPeriodoevaluacionid();
    }

    /**
     * {@inheritDoc}
     */
    public function setTipoasistenciaid(\AppBundle\Entity\CeTipoasistencia $tipoasistenciaid = NULL)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setTipoasistenciaid', [$tipoasistenciaid]);

        return parent::setTipoasistenciaid($tipoasistenciaid);
    }

    /**
     * {@inheritDoc}
     */
    public function getTipoasistenciaid()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getTipoasistenciaid', []);

        return parent::getTipoasistenciaid();
    }

    /**
     * {@inheritDoc}
     */
    public function setUsuarioid(\AppBundle\Entity\Usuario $usuarioid = NULL)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setUsuarioid', [$usuarioid]);

        return parent::setUsuarioid($usuarioid);
    }

    /**
     * {@inheritDoc}
     */
    public function getUsuarioid()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getUsuarioid', []);

        return parent::getUsuarioid();
    }

}
