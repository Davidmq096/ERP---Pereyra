<?php

namespace Proxies\__CG__\AppBundle\Entity;

/**
 * DO NOT EDIT THIS FILE - IT WAS CREATED BY DOCTRINE'S PROXY GENERATOR
 */
class AdAdmisioncontratoresponsable extends \AppBundle\Entity\AdAdmisioncontratoresponsable implements \Doctrine\ORM\Proxy\Proxy
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
            return ['__isInitialized__', '' . "\0" . 'AppBundle\\Entity\\AdAdmisioncontratoresponsable' . "\0" . 'nombre', '' . "\0" . 'AppBundle\\Entity\\AdAdmisioncontratoresponsable' . "\0" . 'apellidopaterno', '' . "\0" . 'AppBundle\\Entity\\AdAdmisioncontratoresponsable' . "\0" . 'apellidomaterno', '' . "\0" . 'AppBundle\\Entity\\AdAdmisioncontratoresponsable' . "\0" . 'cp', '' . "\0" . 'AppBundle\\Entity\\AdAdmisioncontratoresponsable' . "\0" . 'colonia', '' . "\0" . 'AppBundle\\Entity\\AdAdmisioncontratoresponsable' . "\0" . 'calle', '' . "\0" . 'AppBundle\\Entity\\AdAdmisioncontratoresponsable' . "\0" . 'numeroext', '' . "\0" . 'AppBundle\\Entity\\AdAdmisioncontratoresponsable' . "\0" . 'numeroint', '' . "\0" . 'AppBundle\\Entity\\AdAdmisioncontratoresponsable' . "\0" . 'telefono', '' . "\0" . 'AppBundle\\Entity\\AdAdmisioncontratoresponsable' . "\0" . 'celular', '' . "\0" . 'AppBundle\\Entity\\AdAdmisioncontratoresponsable' . "\0" . 'ocupacion', '' . "\0" . 'AppBundle\\Entity\\AdAdmisioncontratoresponsable' . "\0" . 'edad', '' . "\0" . 'AppBundle\\Entity\\AdAdmisioncontratoresponsable' . "\0" . 'responsablecontratoid', '' . "\0" . 'AppBundle\\Entity\\AdAdmisioncontratoresponsable' . "\0" . 'admisioncontratoid', '' . "\0" . 'AppBundle\\Entity\\AdAdmisioncontratoresponsable' . "\0" . 'contratoid', '' . "\0" . 'AppBundle\\Entity\\AdAdmisioncontratoresponsable' . "\0" . 'estadoid', '' . "\0" . 'AppBundle\\Entity\\AdAdmisioncontratoresponsable' . "\0" . 'municipioid', '' . "\0" . 'AppBundle\\Entity\\AdAdmisioncontratoresponsable' . "\0" . 'tutorid'];
        }

        return ['__isInitialized__', '' . "\0" . 'AppBundle\\Entity\\AdAdmisioncontratoresponsable' . "\0" . 'nombre', '' . "\0" . 'AppBundle\\Entity\\AdAdmisioncontratoresponsable' . "\0" . 'apellidopaterno', '' . "\0" . 'AppBundle\\Entity\\AdAdmisioncontratoresponsable' . "\0" . 'apellidomaterno', '' . "\0" . 'AppBundle\\Entity\\AdAdmisioncontratoresponsable' . "\0" . 'cp', '' . "\0" . 'AppBundle\\Entity\\AdAdmisioncontratoresponsable' . "\0" . 'colonia', '' . "\0" . 'AppBundle\\Entity\\AdAdmisioncontratoresponsable' . "\0" . 'calle', '' . "\0" . 'AppBundle\\Entity\\AdAdmisioncontratoresponsable' . "\0" . 'numeroext', '' . "\0" . 'AppBundle\\Entity\\AdAdmisioncontratoresponsable' . "\0" . 'numeroint', '' . "\0" . 'AppBundle\\Entity\\AdAdmisioncontratoresponsable' . "\0" . 'telefono', '' . "\0" . 'AppBundle\\Entity\\AdAdmisioncontratoresponsable' . "\0" . 'celular', '' . "\0" . 'AppBundle\\Entity\\AdAdmisioncontratoresponsable' . "\0" . 'ocupacion', '' . "\0" . 'AppBundle\\Entity\\AdAdmisioncontratoresponsable' . "\0" . 'edad', '' . "\0" . 'AppBundle\\Entity\\AdAdmisioncontratoresponsable' . "\0" . 'responsablecontratoid', '' . "\0" . 'AppBundle\\Entity\\AdAdmisioncontratoresponsable' . "\0" . 'admisioncontratoid', '' . "\0" . 'AppBundle\\Entity\\AdAdmisioncontratoresponsable' . "\0" . 'contratoid', '' . "\0" . 'AppBundle\\Entity\\AdAdmisioncontratoresponsable' . "\0" . 'estadoid', '' . "\0" . 'AppBundle\\Entity\\AdAdmisioncontratoresponsable' . "\0" . 'municipioid', '' . "\0" . 'AppBundle\\Entity\\AdAdmisioncontratoresponsable' . "\0" . 'tutorid'];
    }

    /**
     * 
     */
    public function __wakeup()
    {
        if ( ! $this->__isInitialized__) {
            $this->__initializer__ = function (AdAdmisioncontratoresponsable $proxy) {
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
    public function setApellidopaterno($apellidopaterno)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setApellidopaterno', [$apellidopaterno]);

        return parent::setApellidopaterno($apellidopaterno);
    }

    /**
     * {@inheritDoc}
     */
    public function getApellidopaterno()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getApellidopaterno', []);

        return parent::getApellidopaterno();
    }

    /**
     * {@inheritDoc}
     */
    public function setApellidomaterno($apellidomaterno)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setApellidomaterno', [$apellidomaterno]);

        return parent::setApellidomaterno($apellidomaterno);
    }

    /**
     * {@inheritDoc}
     */
    public function getApellidomaterno()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getApellidomaterno', []);

        return parent::getApellidomaterno();
    }

    /**
     * {@inheritDoc}
     */
    public function setCp($cp)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setCp', [$cp]);

        return parent::setCp($cp);
    }

    /**
     * {@inheritDoc}
     */
    public function getCp()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getCp', []);

        return parent::getCp();
    }

    /**
     * {@inheritDoc}
     */
    public function setColonia($colonia)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setColonia', [$colonia]);

        return parent::setColonia($colonia);
    }

    /**
     * {@inheritDoc}
     */
    public function getColonia()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getColonia', []);

        return parent::getColonia();
    }

    /**
     * {@inheritDoc}
     */
    public function setCalle($calle)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setCalle', [$calle]);

        return parent::setCalle($calle);
    }

    /**
     * {@inheritDoc}
     */
    public function getCalle()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getCalle', []);

        return parent::getCalle();
    }

    /**
     * {@inheritDoc}
     */
    public function setNumeroext($numeroext)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setNumeroext', [$numeroext]);

        return parent::setNumeroext($numeroext);
    }

    /**
     * {@inheritDoc}
     */
    public function getNumeroext()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getNumeroext', []);

        return parent::getNumeroext();
    }

    /**
     * {@inheritDoc}
     */
    public function setNumeroint($numeroint)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setNumeroint', [$numeroint]);

        return parent::setNumeroint($numeroint);
    }

    /**
     * {@inheritDoc}
     */
    public function getNumeroint()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getNumeroint', []);

        return parent::getNumeroint();
    }

    /**
     * {@inheritDoc}
     */
    public function setTelefono($telefono)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setTelefono', [$telefono]);

        return parent::setTelefono($telefono);
    }

    /**
     * {@inheritDoc}
     */
    public function getTelefono()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getTelefono', []);

        return parent::getTelefono();
    }

    /**
     * {@inheritDoc}
     */
    public function setCelular($celular)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setCelular', [$celular]);

        return parent::setCelular($celular);
    }

    /**
     * {@inheritDoc}
     */
    public function getCelular()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getCelular', []);

        return parent::getCelular();
    }

    /**
     * {@inheritDoc}
     */
    public function setOcupacion($ocupacion)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setOcupacion', [$ocupacion]);

        return parent::setOcupacion($ocupacion);
    }

    /**
     * {@inheritDoc}
     */
    public function getOcupacion()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getOcupacion', []);

        return parent::getOcupacion();
    }

    /**
     * {@inheritDoc}
     */
    public function setEdad($edad)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setEdad', [$edad]);

        return parent::setEdad($edad);
    }

    /**
     * {@inheritDoc}
     */
    public function getEdad()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getEdad', []);

        return parent::getEdad();
    }

    /**
     * {@inheritDoc}
     */
    public function getResponsablecontratoid()
    {
        if ($this->__isInitialized__ === false) {
            return (int)  parent::getResponsablecontratoid();
        }


        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getResponsablecontratoid', []);

        return parent::getResponsablecontratoid();
    }

    /**
     * {@inheritDoc}
     */
    public function setAdmisioncontratoid(\AppBundle\Entity\AdAdmisionseguimientocontrato $admisioncontratoid = NULL)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setAdmisioncontratoid', [$admisioncontratoid]);

        return parent::setAdmisioncontratoid($admisioncontratoid);
    }

    /**
     * {@inheritDoc}
     */
    public function getAdmisioncontratoid()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getAdmisioncontratoid', []);

        return parent::getAdmisioncontratoid();
    }

    /**
     * {@inheritDoc}
     */
    public function setContratoid(\AppBundle\Entity\AdAdmisioncontrato $contratoid = NULL)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setContratoid', [$contratoid]);

        return parent::setContratoid($contratoid);
    }

    /**
     * {@inheritDoc}
     */
    public function getContratoid()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getContratoid', []);

        return parent::getContratoid();
    }

    /**
     * {@inheritDoc}
     */
    public function setEstadoid(\AppBundle\Entity\Estado $estadoid = NULL)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setEstadoid', [$estadoid]);

        return parent::setEstadoid($estadoid);
    }

    /**
     * {@inheritDoc}
     */
    public function getEstadoid()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getEstadoid', []);

        return parent::getEstadoid();
    }

    /**
     * {@inheritDoc}
     */
    public function setMunicipioid(\AppBundle\Entity\Municipio $municipioid = NULL)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setMunicipioid', [$municipioid]);

        return parent::setMunicipioid($municipioid);
    }

    /**
     * {@inheritDoc}
     */
    public function getMunicipioid()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getMunicipioid', []);

        return parent::getMunicipioid();
    }

    /**
     * {@inheritDoc}
     */
    public function setTutorid(\AppBundle\Entity\Tutor $tutorid = NULL)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setTutorid', [$tutorid]);

        return parent::setTutorid($tutorid);
    }

    /**
     * {@inheritDoc}
     */
    public function getTutorid()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getTutorid', []);

        return parent::getTutorid();
    }

}
