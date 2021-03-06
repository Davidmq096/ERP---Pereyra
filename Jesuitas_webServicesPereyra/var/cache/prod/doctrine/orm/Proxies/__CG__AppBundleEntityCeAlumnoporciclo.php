<?php

namespace Proxies\__CG__\AppBundle\Entity;

/**
 * DO NOT EDIT THIS FILE - IT WAS CREATED BY DOCTRINE'S PROXY GENERATOR
 */
class CeAlumnoporciclo extends \AppBundle\Entity\CeAlumnoporciclo implements \Doctrine\ORM\Proxy\Proxy
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
            return ['__isInitialized__', '' . "\0" . 'AppBundle\\Entity\\CeAlumnoporciclo' . "\0" . 'fechabaja', '' . "\0" . 'AppBundle\\Entity\\CeAlumnoporciclo' . "\0" . 'correoenviado', '' . "\0" . 'AppBundle\\Entity\\CeAlumnoporciclo' . "\0" . 'observacionesbaja', '' . "\0" . 'AppBundle\\Entity\\CeAlumnoporciclo' . "\0" . 'documentosreinscripcion', '' . "\0" . 'AppBundle\\Entity\\CeAlumnoporciclo' . "\0" . 'alumnoporcicloid', '' . "\0" . 'AppBundle\\Entity\\CeAlumnoporciclo' . "\0" . 'alumnoid', '' . "\0" . 'AppBundle\\Entity\\CeAlumnoporciclo' . "\0" . 'areaespecializacionid', '' . "\0" . 'AppBundle\\Entity\\CeAlumnoporciclo' . "\0" . 'cicloid', '' . "\0" . 'AppBundle\\Entity\\CeAlumnoporciclo' . "\0" . 'estatusalumnocicloid', '' . "\0" . 'AppBundle\\Entity\\CeAlumnoporciclo' . "\0" . 'motivobajaid', '' . "\0" . 'AppBundle\\Entity\\CeAlumnoporciclo' . "\0" . 'planestudiosid', '' . "\0" . 'AppBundle\\Entity\\CeAlumnoporciclo' . "\0" . 'intencionreinscribirseid', '' . "\0" . 'AppBundle\\Entity\\CeAlumnoporciclo' . "\0" . 'gradoid'];
        }

        return ['__isInitialized__', '' . "\0" . 'AppBundle\\Entity\\CeAlumnoporciclo' . "\0" . 'fechabaja', '' . "\0" . 'AppBundle\\Entity\\CeAlumnoporciclo' . "\0" . 'correoenviado', '' . "\0" . 'AppBundle\\Entity\\CeAlumnoporciclo' . "\0" . 'observacionesbaja', '' . "\0" . 'AppBundle\\Entity\\CeAlumnoporciclo' . "\0" . 'documentosreinscripcion', '' . "\0" . 'AppBundle\\Entity\\CeAlumnoporciclo' . "\0" . 'alumnoporcicloid', '' . "\0" . 'AppBundle\\Entity\\CeAlumnoporciclo' . "\0" . 'alumnoid', '' . "\0" . 'AppBundle\\Entity\\CeAlumnoporciclo' . "\0" . 'areaespecializacionid', '' . "\0" . 'AppBundle\\Entity\\CeAlumnoporciclo' . "\0" . 'cicloid', '' . "\0" . 'AppBundle\\Entity\\CeAlumnoporciclo' . "\0" . 'estatusalumnocicloid', '' . "\0" . 'AppBundle\\Entity\\CeAlumnoporciclo' . "\0" . 'motivobajaid', '' . "\0" . 'AppBundle\\Entity\\CeAlumnoporciclo' . "\0" . 'planestudiosid', '' . "\0" . 'AppBundle\\Entity\\CeAlumnoporciclo' . "\0" . 'intencionreinscribirseid', '' . "\0" . 'AppBundle\\Entity\\CeAlumnoporciclo' . "\0" . 'gradoid'];
    }

    /**
     * 
     */
    public function __wakeup()
    {
        if ( ! $this->__isInitialized__) {
            $this->__initializer__ = function (CeAlumnoporciclo $proxy) {
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
    public function setFechabaja($fechabaja)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setFechabaja', [$fechabaja]);

        return parent::setFechabaja($fechabaja);
    }

    /**
     * {@inheritDoc}
     */
    public function getFechabaja()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getFechabaja', []);

        return parent::getFechabaja();
    }

    /**
     * {@inheritDoc}
     */
    public function setCorreoenviado($correoenviado)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setCorreoenviado', [$correoenviado]);

        return parent::setCorreoenviado($correoenviado);
    }

    /**
     * {@inheritDoc}
     */
    public function getCorreoenviado()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getCorreoenviado', []);

        return parent::getCorreoenviado();
    }

    /**
     * {@inheritDoc}
     */
    public function setObservacionesbaja($observacionesbaja)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setObservacionesbaja', [$observacionesbaja]);

        return parent::setObservacionesbaja($observacionesbaja);
    }

    /**
     * {@inheritDoc}
     */
    public function getObservacionesbaja()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getObservacionesbaja', []);

        return parent::getObservacionesbaja();
    }

    /**
     * {@inheritDoc}
     */
    public function setDocumentosreinscripcion($documentosreinscripcion)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setDocumentosreinscripcion', [$documentosreinscripcion]);

        return parent::setDocumentosreinscripcion($documentosreinscripcion);
    }

    /**
     * {@inheritDoc}
     */
    public function getDocumentosreinscripcion()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getDocumentosreinscripcion', []);

        return parent::getDocumentosreinscripcion();
    }

    /**
     * {@inheritDoc}
     */
    public function getAlumnoporcicloid()
    {
        if ($this->__isInitialized__ === false) {
            return (int)  parent::getAlumnoporcicloid();
        }


        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getAlumnoporcicloid', []);

        return parent::getAlumnoporcicloid();
    }

    /**
     * {@inheritDoc}
     */
    public function setAlumnoid(\AppBundle\Entity\CeAlumno $alumnoid = NULL)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setAlumnoid', [$alumnoid]);

        return parent::setAlumnoid($alumnoid);
    }

    /**
     * {@inheritDoc}
     */
    public function getAlumnoid()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getAlumnoid', []);

        return parent::getAlumnoid();
    }

    /**
     * {@inheritDoc}
     */
    public function setAreaespecializacionid(\AppBundle\Entity\CeAreaespecializacion $areaespecializacionid = NULL)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setAreaespecializacionid', [$areaespecializacionid]);

        return parent::setAreaespecializacionid($areaespecializacionid);
    }

    /**
     * {@inheritDoc}
     */
    public function getAreaespecializacionid()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getAreaespecializacionid', []);

        return parent::getAreaespecializacionid();
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
    public function setEstatusalumnocicloid(\AppBundle\Entity\CeEstatusalumnoporciclo $estatusalumnocicloid = NULL)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setEstatusalumnocicloid', [$estatusalumnocicloid]);

        return parent::setEstatusalumnocicloid($estatusalumnocicloid);
    }

    /**
     * {@inheritDoc}
     */
    public function getEstatusalumnocicloid()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getEstatusalumnocicloid', []);

        return parent::getEstatusalumnocicloid();
    }

    /**
     * {@inheritDoc}
     */
    public function setMotivobajaid(\AppBundle\Entity\CeMotivobaja $motivobajaid = NULL)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setMotivobajaid', [$motivobajaid]);

        return parent::setMotivobajaid($motivobajaid);
    }

    /**
     * {@inheritDoc}
     */
    public function getMotivobajaid()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getMotivobajaid', []);

        return parent::getMotivobajaid();
    }

    /**
     * {@inheritDoc}
     */
    public function setPlanestudiosid(\AppBundle\Entity\CePlanestudios $planestudiosid = NULL)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setPlanestudiosid', [$planestudiosid]);

        return parent::setPlanestudiosid($planestudiosid);
    }

    /**
     * {@inheritDoc}
     */
    public function getPlanestudiosid()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getPlanestudiosid', []);

        return parent::getPlanestudiosid();
    }

    /**
     * {@inheritDoc}
     */
    public function setIntencionreinscribirseid(\AppBundle\Entity\CeIntencionreinscribirse $intencionreinscribirseid = NULL)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setIntencionreinscribirseid', [$intencionreinscribirseid]);

        return parent::setIntencionreinscribirseid($intencionreinscribirseid);
    }

    /**
     * {@inheritDoc}
     */
    public function getIntencionreinscribirseid()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getIntencionreinscribirseid', []);

        return parent::getIntencionreinscribirseid();
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

}
