<?php

namespace Proxies\__CG__\AppBundle\Entity;

/**
 * DO NOT EDIT THIS FILE - IT WAS CREATED BY DOCTRINE'S PROXY GENERATOR
 */
class CeBitacoracalificacionglobal extends \AppBundle\Entity\CeBitacoracalificacionglobal implements \Doctrine\ORM\Proxy\Proxy
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
            return ['__isInitialized__', '' . "\0" . 'AppBundle\\Entity\\CeBitacoracalificacionglobal' . "\0" . 'ciclo', '' . "\0" . 'AppBundle\\Entity\\CeBitacoracalificacionglobal' . "\0" . 'nivel', '' . "\0" . 'AppBundle\\Entity\\CeBitacoracalificacionglobal' . "\0" . 'grado', '' . "\0" . 'AppBundle\\Entity\\CeBitacoracalificacionglobal' . "\0" . 'alumno', '' . "\0" . 'AppBundle\\Entity\\CeBitacoracalificacionglobal' . "\0" . 'asistenciaanterior', '' . "\0" . 'AppBundle\\Entity\\CeBitacoracalificacionglobal' . "\0" . 'asistencianuevo', '' . "\0" . 'AppBundle\\Entity\\CeBitacoracalificacionglobal' . "\0" . 'comanterior', '' . "\0" . 'AppBundle\\Entity\\CeBitacoracalificacionglobal' . "\0" . 'comnuevo', '' . "\0" . 'AppBundle\\Entity\\CeBitacoracalificacionglobal' . "\0" . 'tareasolicitadaanterior', '' . "\0" . 'AppBundle\\Entity\\CeBitacoracalificacionglobal' . "\0" . 'tareasolicitadanuevo', '' . "\0" . 'AppBundle\\Entity\\CeBitacoracalificacionglobal' . "\0" . 'tareaentregadaanterior', '' . "\0" . 'AppBundle\\Entity\\CeBitacoracalificacionglobal' . "\0" . 'tareaentregadanuevo', '' . "\0" . 'AppBundle\\Entity\\CeBitacoracalificacionglobal' . "\0" . 'fecha', '' . "\0" . 'AppBundle\\Entity\\CeBitacoracalificacionglobal' . "\0" . 'bitacoracalificacionglobalid', '' . "\0" . 'AppBundle\\Entity\\CeBitacoracalificacionglobal' . "\0" . 'usuarioid', '' . "\0" . 'AppBundle\\Entity\\CeBitacoracalificacionglobal' . "\0" . 'periodoevaluacionid', '' . "\0" . 'AppBundle\\Entity\\CeBitacoracalificacionglobal' . "\0" . 'capturaalumnoporperiodoid'];
        }

        return ['__isInitialized__', '' . "\0" . 'AppBundle\\Entity\\CeBitacoracalificacionglobal' . "\0" . 'ciclo', '' . "\0" . 'AppBundle\\Entity\\CeBitacoracalificacionglobal' . "\0" . 'nivel', '' . "\0" . 'AppBundle\\Entity\\CeBitacoracalificacionglobal' . "\0" . 'grado', '' . "\0" . 'AppBundle\\Entity\\CeBitacoracalificacionglobal' . "\0" . 'alumno', '' . "\0" . 'AppBundle\\Entity\\CeBitacoracalificacionglobal' . "\0" . 'asistenciaanterior', '' . "\0" . 'AppBundle\\Entity\\CeBitacoracalificacionglobal' . "\0" . 'asistencianuevo', '' . "\0" . 'AppBundle\\Entity\\CeBitacoracalificacionglobal' . "\0" . 'comanterior', '' . "\0" . 'AppBundle\\Entity\\CeBitacoracalificacionglobal' . "\0" . 'comnuevo', '' . "\0" . 'AppBundle\\Entity\\CeBitacoracalificacionglobal' . "\0" . 'tareasolicitadaanterior', '' . "\0" . 'AppBundle\\Entity\\CeBitacoracalificacionglobal' . "\0" . 'tareasolicitadanuevo', '' . "\0" . 'AppBundle\\Entity\\CeBitacoracalificacionglobal' . "\0" . 'tareaentregadaanterior', '' . "\0" . 'AppBundle\\Entity\\CeBitacoracalificacionglobal' . "\0" . 'tareaentregadanuevo', '' . "\0" . 'AppBundle\\Entity\\CeBitacoracalificacionglobal' . "\0" . 'fecha', '' . "\0" . 'AppBundle\\Entity\\CeBitacoracalificacionglobal' . "\0" . 'bitacoracalificacionglobalid', '' . "\0" . 'AppBundle\\Entity\\CeBitacoracalificacionglobal' . "\0" . 'usuarioid', '' . "\0" . 'AppBundle\\Entity\\CeBitacoracalificacionglobal' . "\0" . 'periodoevaluacionid', '' . "\0" . 'AppBundle\\Entity\\CeBitacoracalificacionglobal' . "\0" . 'capturaalumnoporperiodoid'];
    }

    /**
     * 
     */
    public function __wakeup()
    {
        if ( ! $this->__isInitialized__) {
            $this->__initializer__ = function (CeBitacoracalificacionglobal $proxy) {
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
    public function setCiclo($ciclo)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setCiclo', [$ciclo]);

        return parent::setCiclo($ciclo);
    }

    /**
     * {@inheritDoc}
     */
    public function getCiclo()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getCiclo', []);

        return parent::getCiclo();
    }

    /**
     * {@inheritDoc}
     */
    public function setNivel($nivel)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setNivel', [$nivel]);

        return parent::setNivel($nivel);
    }

    /**
     * {@inheritDoc}
     */
    public function getNivel()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getNivel', []);

        return parent::getNivel();
    }

    /**
     * {@inheritDoc}
     */
    public function setGrado($grado)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setGrado', [$grado]);

        return parent::setGrado($grado);
    }

    /**
     * {@inheritDoc}
     */
    public function getGrado()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getGrado', []);

        return parent::getGrado();
    }

    /**
     * {@inheritDoc}
     */
    public function setAlumno($alumno)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setAlumno', [$alumno]);

        return parent::setAlumno($alumno);
    }

    /**
     * {@inheritDoc}
     */
    public function getAlumno()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getAlumno', []);

        return parent::getAlumno();
    }

    /**
     * {@inheritDoc}
     */
    public function setAsistenciaanterior($asistenciaanterior)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setAsistenciaanterior', [$asistenciaanterior]);

        return parent::setAsistenciaanterior($asistenciaanterior);
    }

    /**
     * {@inheritDoc}
     */
    public function getAsistenciaanterior()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getAsistenciaanterior', []);

        return parent::getAsistenciaanterior();
    }

    /**
     * {@inheritDoc}
     */
    public function setAsistencianuevo($asistencianuevo)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setAsistencianuevo', [$asistencianuevo]);

        return parent::setAsistencianuevo($asistencianuevo);
    }

    /**
     * {@inheritDoc}
     */
    public function getAsistencianuevo()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getAsistencianuevo', []);

        return parent::getAsistencianuevo();
    }

    /**
     * {@inheritDoc}
     */
    public function setComanterior($comanterior)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setComanterior', [$comanterior]);

        return parent::setComanterior($comanterior);
    }

    /**
     * {@inheritDoc}
     */
    public function getComanterior()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getComanterior', []);

        return parent::getComanterior();
    }

    /**
     * {@inheritDoc}
     */
    public function setComnuevo($comnuevo)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setComnuevo', [$comnuevo]);

        return parent::setComnuevo($comnuevo);
    }

    /**
     * {@inheritDoc}
     */
    public function getComnuevo()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getComnuevo', []);

        return parent::getComnuevo();
    }

    /**
     * {@inheritDoc}
     */
    public function setTareasolicitadaanterior($tareasolicitadaanterior)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setTareasolicitadaanterior', [$tareasolicitadaanterior]);

        return parent::setTareasolicitadaanterior($tareasolicitadaanterior);
    }

    /**
     * {@inheritDoc}
     */
    public function getTareasolicitadaanterior()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getTareasolicitadaanterior', []);

        return parent::getTareasolicitadaanterior();
    }

    /**
     * {@inheritDoc}
     */
    public function setTareasolicitadanuevo($tareasolicitadanuevo)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setTareasolicitadanuevo', [$tareasolicitadanuevo]);

        return parent::setTareasolicitadanuevo($tareasolicitadanuevo);
    }

    /**
     * {@inheritDoc}
     */
    public function getTareasolicitadanuevo()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getTareasolicitadanuevo', []);

        return parent::getTareasolicitadanuevo();
    }

    /**
     * {@inheritDoc}
     */
    public function setTareaentregadaanterior($tareaentregadaanterior)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setTareaentregadaanterior', [$tareaentregadaanterior]);

        return parent::setTareaentregadaanterior($tareaentregadaanterior);
    }

    /**
     * {@inheritDoc}
     */
    public function getTareaentregadaanterior()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getTareaentregadaanterior', []);

        return parent::getTareaentregadaanterior();
    }

    /**
     * {@inheritDoc}
     */
    public function setTareaentregadanuevo($tareaentregadanuevo)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setTareaentregadanuevo', [$tareaentregadanuevo]);

        return parent::setTareaentregadanuevo($tareaentregadanuevo);
    }

    /**
     * {@inheritDoc}
     */
    public function getTareaentregadanuevo()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getTareaentregadanuevo', []);

        return parent::getTareaentregadanuevo();
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
    public function getBitacoracalificacionglobalid()
    {
        if ($this->__isInitialized__ === false) {
            return (int)  parent::getBitacoracalificacionglobalid();
        }


        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getBitacoracalificacionglobalid', []);

        return parent::getBitacoracalificacionglobalid();
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
    public function setCapturaalumnoporperiodoid(\AppBundle\Entity\CeCapturaalumnoporperiodo $capturaalumnoporperiodoid = NULL)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setCapturaalumnoporperiodoid', [$capturaalumnoporperiodoid]);

        return parent::setCapturaalumnoporperiodoid($capturaalumnoporperiodoid);
    }

    /**
     * {@inheritDoc}
     */
    public function getCapturaalumnoporperiodoid()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getCapturaalumnoporperiodoid', []);

        return parent::getCapturaalumnoporperiodoid();
    }

}
