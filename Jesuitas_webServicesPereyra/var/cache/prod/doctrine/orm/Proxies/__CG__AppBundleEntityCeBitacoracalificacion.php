<?php

namespace Proxies\__CG__\AppBundle\Entity;

/**
 * DO NOT EDIT THIS FILE - IT WAS CREATED BY DOCTRINE'S PROXY GENERATOR
 */
class CeBitacoracalificacion extends \AppBundle\Entity\CeBitacoracalificacion implements \Doctrine\ORM\Proxy\Proxy
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
            return ['__isInitialized__', '' . "\0" . 'AppBundle\\Entity\\CeBitacoracalificacion' . "\0" . 'ciclo', '' . "\0" . 'AppBundle\\Entity\\CeBitacoracalificacion' . "\0" . 'nivel', '' . "\0" . 'AppBundle\\Entity\\CeBitacoracalificacion' . "\0" . 'grado', '' . "\0" . 'AppBundle\\Entity\\CeBitacoracalificacion' . "\0" . 'clase', '' . "\0" . 'AppBundle\\Entity\\CeBitacoracalificacion' . "\0" . 'materia', '' . "\0" . 'AppBundle\\Entity\\CeBitacoracalificacion' . "\0" . 'criterioevaluacion', '' . "\0" . 'AppBundle\\Entity\\CeBitacoracalificacion' . "\0" . 'numerocaptura', '' . "\0" . 'AppBundle\\Entity\\CeBitacoracalificacion' . "\0" . 'alumno', '' . "\0" . 'AppBundle\\Entity\\CeBitacoracalificacion' . "\0" . 'capturaanterior', '' . "\0" . 'AppBundle\\Entity\\CeBitacoracalificacion' . "\0" . 'capturanuevo', '' . "\0" . 'AppBundle\\Entity\\CeBitacoracalificacion' . "\0" . 'calperiodoanterior', '' . "\0" . 'AppBundle\\Entity\\CeBitacoracalificacion' . "\0" . 'calperiodonuevo', '' . "\0" . 'AppBundle\\Entity\\CeBitacoracalificacion' . "\0" . 'opcperiodoanterior', '' . "\0" . 'AppBundle\\Entity\\CeBitacoracalificacion' . "\0" . 'opcperiodonuevo', '' . "\0" . 'AppBundle\\Entity\\CeBitacoracalificacion' . "\0" . 'comperiodoanterior', '' . "\0" . 'AppBundle\\Entity\\CeBitacoracalificacion' . "\0" . 'comperiodonuevo', '' . "\0" . 'AppBundle\\Entity\\CeBitacoracalificacion' . "\0" . 'calfinalanterior', '' . "\0" . 'AppBundle\\Entity\\CeBitacoracalificacion' . "\0" . 'calfinalnuevo', '' . "\0" . 'AppBundle\\Entity\\CeBitacoracalificacion' . "\0" . 'opcfinalanterior', '' . "\0" . 'AppBundle\\Entity\\CeBitacoracalificacion' . "\0" . 'opcfinalnuevo', '' . "\0" . 'AppBundle\\Entity\\CeBitacoracalificacion' . "\0" . 'fecha', '' . "\0" . 'AppBundle\\Entity\\CeBitacoracalificacion' . "\0" . 'folioedicionextemporanea', '' . "\0" . 'AppBundle\\Entity\\CeBitacoracalificacion' . "\0" . 'bitacoracalificacionid', '' . "\0" . 'AppBundle\\Entity\\CeBitacoracalificacion' . "\0" . 'periodoevaluacionid', '' . "\0" . 'AppBundle\\Entity\\CeBitacoracalificacion' . "\0" . 'profesorpormateriaplanestudiosid', '' . "\0" . 'AppBundle\\Entity\\CeBitacoracalificacion' . "\0" . 'usuarioid'];
        }

        return ['__isInitialized__', '' . "\0" . 'AppBundle\\Entity\\CeBitacoracalificacion' . "\0" . 'ciclo', '' . "\0" . 'AppBundle\\Entity\\CeBitacoracalificacion' . "\0" . 'nivel', '' . "\0" . 'AppBundle\\Entity\\CeBitacoracalificacion' . "\0" . 'grado', '' . "\0" . 'AppBundle\\Entity\\CeBitacoracalificacion' . "\0" . 'clase', '' . "\0" . 'AppBundle\\Entity\\CeBitacoracalificacion' . "\0" . 'materia', '' . "\0" . 'AppBundle\\Entity\\CeBitacoracalificacion' . "\0" . 'criterioevaluacion', '' . "\0" . 'AppBundle\\Entity\\CeBitacoracalificacion' . "\0" . 'numerocaptura', '' . "\0" . 'AppBundle\\Entity\\CeBitacoracalificacion' . "\0" . 'alumno', '' . "\0" . 'AppBundle\\Entity\\CeBitacoracalificacion' . "\0" . 'capturaanterior', '' . "\0" . 'AppBundle\\Entity\\CeBitacoracalificacion' . "\0" . 'capturanuevo', '' . "\0" . 'AppBundle\\Entity\\CeBitacoracalificacion' . "\0" . 'calperiodoanterior', '' . "\0" . 'AppBundle\\Entity\\CeBitacoracalificacion' . "\0" . 'calperiodonuevo', '' . "\0" . 'AppBundle\\Entity\\CeBitacoracalificacion' . "\0" . 'opcperiodoanterior', '' . "\0" . 'AppBundle\\Entity\\CeBitacoracalificacion' . "\0" . 'opcperiodonuevo', '' . "\0" . 'AppBundle\\Entity\\CeBitacoracalificacion' . "\0" . 'comperiodoanterior', '' . "\0" . 'AppBundle\\Entity\\CeBitacoracalificacion' . "\0" . 'comperiodonuevo', '' . "\0" . 'AppBundle\\Entity\\CeBitacoracalificacion' . "\0" . 'calfinalanterior', '' . "\0" . 'AppBundle\\Entity\\CeBitacoracalificacion' . "\0" . 'calfinalnuevo', '' . "\0" . 'AppBundle\\Entity\\CeBitacoracalificacion' . "\0" . 'opcfinalanterior', '' . "\0" . 'AppBundle\\Entity\\CeBitacoracalificacion' . "\0" . 'opcfinalnuevo', '' . "\0" . 'AppBundle\\Entity\\CeBitacoracalificacion' . "\0" . 'fecha', '' . "\0" . 'AppBundle\\Entity\\CeBitacoracalificacion' . "\0" . 'folioedicionextemporanea', '' . "\0" . 'AppBundle\\Entity\\CeBitacoracalificacion' . "\0" . 'bitacoracalificacionid', '' . "\0" . 'AppBundle\\Entity\\CeBitacoracalificacion' . "\0" . 'periodoevaluacionid', '' . "\0" . 'AppBundle\\Entity\\CeBitacoracalificacion' . "\0" . 'profesorpormateriaplanestudiosid', '' . "\0" . 'AppBundle\\Entity\\CeBitacoracalificacion' . "\0" . 'usuarioid'];
    }

    /**
     * 
     */
    public function __wakeup()
    {
        if ( ! $this->__isInitialized__) {
            $this->__initializer__ = function (CeBitacoracalificacion $proxy) {
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
    public function setClase($clase)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setClase', [$clase]);

        return parent::setClase($clase);
    }

    /**
     * {@inheritDoc}
     */
    public function getClase()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getClase', []);

        return parent::getClase();
    }

    /**
     * {@inheritDoc}
     */
    public function setMateria($materia)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setMateria', [$materia]);

        return parent::setMateria($materia);
    }

    /**
     * {@inheritDoc}
     */
    public function getMateria()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getMateria', []);

        return parent::getMateria();
    }

    /**
     * {@inheritDoc}
     */
    public function setCriterioevaluacion($criterioevaluacion)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setCriterioevaluacion', [$criterioevaluacion]);

        return parent::setCriterioevaluacion($criterioevaluacion);
    }

    /**
     * {@inheritDoc}
     */
    public function getCriterioevaluacion()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getCriterioevaluacion', []);

        return parent::getCriterioevaluacion();
    }

    /**
     * {@inheritDoc}
     */
    public function setNumerocaptura($numerocaptura)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setNumerocaptura', [$numerocaptura]);

        return parent::setNumerocaptura($numerocaptura);
    }

    /**
     * {@inheritDoc}
     */
    public function getNumerocaptura()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getNumerocaptura', []);

        return parent::getNumerocaptura();
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
    public function setCapturaanterior($capturaanterior)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setCapturaanterior', [$capturaanterior]);

        return parent::setCapturaanterior($capturaanterior);
    }

    /**
     * {@inheritDoc}
     */
    public function getCapturaanterior()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getCapturaanterior', []);

        return parent::getCapturaanterior();
    }

    /**
     * {@inheritDoc}
     */
    public function setCapturanuevo($capturanuevo)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setCapturanuevo', [$capturanuevo]);

        return parent::setCapturanuevo($capturanuevo);
    }

    /**
     * {@inheritDoc}
     */
    public function getCapturanuevo()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getCapturanuevo', []);

        return parent::getCapturanuevo();
    }

    /**
     * {@inheritDoc}
     */
    public function setCalperiodoanterior($calperiodoanterior)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setCalperiodoanterior', [$calperiodoanterior]);

        return parent::setCalperiodoanterior($calperiodoanterior);
    }

    /**
     * {@inheritDoc}
     */
    public function getCalperiodoanterior()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getCalperiodoanterior', []);

        return parent::getCalperiodoanterior();
    }

    /**
     * {@inheritDoc}
     */
    public function setCalperiodonuevo($calperiodonuevo)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setCalperiodonuevo', [$calperiodonuevo]);

        return parent::setCalperiodonuevo($calperiodonuevo);
    }

    /**
     * {@inheritDoc}
     */
    public function getCalperiodonuevo()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getCalperiodonuevo', []);

        return parent::getCalperiodonuevo();
    }

    /**
     * {@inheritDoc}
     */
    public function setOpcperiodoanterior($opcperiodoanterior)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setOpcperiodoanterior', [$opcperiodoanterior]);

        return parent::setOpcperiodoanterior($opcperiodoanterior);
    }

    /**
     * {@inheritDoc}
     */
    public function getOpcperiodoanterior()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getOpcperiodoanterior', []);

        return parent::getOpcperiodoanterior();
    }

    /**
     * {@inheritDoc}
     */
    public function setOpcperiodonuevo($opcperiodonuevo)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setOpcperiodonuevo', [$opcperiodonuevo]);

        return parent::setOpcperiodonuevo($opcperiodonuevo);
    }

    /**
     * {@inheritDoc}
     */
    public function getOpcperiodonuevo()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getOpcperiodonuevo', []);

        return parent::getOpcperiodonuevo();
    }

    /**
     * {@inheritDoc}
     */
    public function setComperiodoanterior($comperiodoanterior)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setComperiodoanterior', [$comperiodoanterior]);

        return parent::setComperiodoanterior($comperiodoanterior);
    }

    /**
     * {@inheritDoc}
     */
    public function getComperiodoanterior()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getComperiodoanterior', []);

        return parent::getComperiodoanterior();
    }

    /**
     * {@inheritDoc}
     */
    public function setComperiodonuevo($comperiodonuevo)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setComperiodonuevo', [$comperiodonuevo]);

        return parent::setComperiodonuevo($comperiodonuevo);
    }

    /**
     * {@inheritDoc}
     */
    public function getComperiodonuevo()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getComperiodonuevo', []);

        return parent::getComperiodonuevo();
    }

    /**
     * {@inheritDoc}
     */
    public function setCalfinalanterior($calfinalanterior)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setCalfinalanterior', [$calfinalanterior]);

        return parent::setCalfinalanterior($calfinalanterior);
    }

    /**
     * {@inheritDoc}
     */
    public function getCalfinalanterior()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getCalfinalanterior', []);

        return parent::getCalfinalanterior();
    }

    /**
     * {@inheritDoc}
     */
    public function setCalfinalnuevo($calfinalnuevo)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setCalfinalnuevo', [$calfinalnuevo]);

        return parent::setCalfinalnuevo($calfinalnuevo);
    }

    /**
     * {@inheritDoc}
     */
    public function getCalfinalnuevo()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getCalfinalnuevo', []);

        return parent::getCalfinalnuevo();
    }

    /**
     * {@inheritDoc}
     */
    public function setOpcfinalanterior($opcfinalanterior)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setOpcfinalanterior', [$opcfinalanterior]);

        return parent::setOpcfinalanterior($opcfinalanterior);
    }

    /**
     * {@inheritDoc}
     */
    public function getOpcfinalanterior()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getOpcfinalanterior', []);

        return parent::getOpcfinalanterior();
    }

    /**
     * {@inheritDoc}
     */
    public function setOpcfinalnuevo($opcfinalnuevo)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setOpcfinalnuevo', [$opcfinalnuevo]);

        return parent::setOpcfinalnuevo($opcfinalnuevo);
    }

    /**
     * {@inheritDoc}
     */
    public function getOpcfinalnuevo()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getOpcfinalnuevo', []);

        return parent::getOpcfinalnuevo();
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
    public function setFolioedicionextemporanea($folioedicionextemporanea)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setFolioedicionextemporanea', [$folioedicionextemporanea]);

        return parent::setFolioedicionextemporanea($folioedicionextemporanea);
    }

    /**
     * {@inheritDoc}
     */
    public function getFolioedicionextemporanea()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getFolioedicionextemporanea', []);

        return parent::getFolioedicionextemporanea();
    }

    /**
     * {@inheritDoc}
     */
    public function getBitacoracalificacionid()
    {
        if ($this->__isInitialized__ === false) {
            return (int)  parent::getBitacoracalificacionid();
        }


        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getBitacoracalificacionid', []);

        return parent::getBitacoracalificacionid();
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
    public function setProfesorpormateriaplanestudiosid(\AppBundle\Entity\CeProfesorpormateriaplanestudios $profesorpormateriaplanestudiosid = NULL)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setProfesorpormateriaplanestudiosid', [$profesorpormateriaplanestudiosid]);

        return parent::setProfesorpormateriaplanestudiosid($profesorpormateriaplanestudiosid);
    }

    /**
     * {@inheritDoc}
     */
    public function getProfesorpormateriaplanestudiosid()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getProfesorpormateriaplanestudiosid', []);

        return parent::getProfesorpormateriaplanestudiosid();
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
