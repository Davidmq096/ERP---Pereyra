<?php

namespace Proxies\__CG__\AppBundle\Entity;

/**
 * DO NOT EDIT THIS FILE - IT WAS CREATED BY DOCTRINE'S PROXY GENERATOR
 */
class BcPadresotutores extends \AppBundle\Entity\BcPadresotutores implements \Doctrine\ORM\Proxy\Proxy
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
            return ['__isInitialized__', '' . "\0" . 'AppBundle\\Entity\\BcPadresotutores' . "\0" . 'nivelestudioid', '' . "\0" . 'AppBundle\\Entity\\BcPadresotutores' . "\0" . 'ocupacion', '' . "\0" . 'AppBundle\\Entity\\BcPadresotutores' . "\0" . 'tiposanguineoid', '' . "\0" . 'AppBundle\\Entity\\BcPadresotutores' . "\0" . 'generacionid', '' . "\0" . 'AppBundle\\Entity\\BcPadresotutores' . "\0" . 'nacionalidadid', '' . "\0" . 'AppBundle\\Entity\\BcPadresotutores' . "\0" . 'nombre', '' . "\0" . 'AppBundle\\Entity\\BcPadresotutores' . "\0" . 'apellidopaterno', '' . "\0" . 'AppBundle\\Entity\\BcPadresotutores' . "\0" . 'apellidomaterno', '' . "\0" . 'AppBundle\\Entity\\BcPadresotutores' . "\0" . 'telefono', '' . "\0" . 'AppBundle\\Entity\\BcPadresotutores' . "\0" . 'celular', '' . "\0" . 'AppBundle\\Entity\\BcPadresotutores' . "\0" . 'lugartrabajo', '' . "\0" . 'AppBundle\\Entity\\BcPadresotutores' . "\0" . 'capturadordatos', '' . "\0" . 'AppBundle\\Entity\\BcPadresotutores' . "\0" . 'autoriza', '' . "\0" . 'AppBundle\\Entity\\BcPadresotutores' . "\0" . 'tutor', '' . "\0" . 'AppBundle\\Entity\\BcPadresotutores' . "\0" . 'foto', '' . "\0" . 'AppBundle\\Entity\\BcPadresotutores' . "\0" . 'curp', '' . "\0" . 'AppBundle\\Entity\\BcPadresotutores' . "\0" . 'vive', '' . "\0" . 'AppBundle\\Entity\\BcPadresotutores' . "\0" . 'fechanacimiento', '' . "\0" . 'AppBundle\\Entity\\BcPadresotutores' . "\0" . 'especificacionocupacion', '' . "\0" . 'AppBundle\\Entity\\BcPadresotutores' . "\0" . 'empresa', '' . "\0" . 'AppBundle\\Entity\\BcPadresotutores' . "\0" . 'correo', '' . "\0" . 'AppBundle\\Entity\\BcPadresotutores' . "\0" . 'telempresa', '' . "\0" . 'AppBundle\\Entity\\BcPadresotutores' . "\0" . 'extensionempresa', '' . "\0" . 'AppBundle\\Entity\\BcPadresotutores' . "\0" . 'horariotrabajo', '' . "\0" . 'AppBundle\\Entity\\BcPadresotutores' . "\0" . 'exlux', '' . "\0" . 'AppBundle\\Entity\\BcPadresotutores' . "\0" . 'ramo', '' . "\0" . 'AppBundle\\Entity\\BcPadresotutores' . "\0" . 'alumnoinstituto', '' . "\0" . 'AppBundle\\Entity\\BcPadresotutores' . "\0" . 'especificaralumno', '' . "\0" . 'AppBundle\\Entity\\BcPadresotutores' . "\0" . 'custodia', '' . "\0" . 'AppBundle\\Entity\\BcPadresotutores' . "\0" . 'antiguedad', '' . "\0" . 'AppBundle\\Entity\\BcPadresotutores' . "\0" . 'nombrejefeinmediato', '' . "\0" . 'AppBundle\\Entity\\BcPadresotutores' . "\0" . 'domicilioempresa', '' . "\0" . 'AppBundle\\Entity\\BcPadresotutores' . "\0" . 'clavefamiliarid', '' . "\0" . 'AppBundle\\Entity\\BcPadresotutores' . "\0" . 'padresotutoresid', '' . "\0" . 'AppBundle\\Entity\\BcPadresotutores' . "\0" . 'ingresosluxid', '' . "\0" . 'AppBundle\\Entity\\BcPadresotutores' . "\0" . 'solicitudid', '' . "\0" . 'AppBundle\\Entity\\BcPadresotutores' . "\0" . 'escolaridadid', '' . "\0" . 'AppBundle\\Entity\\BcPadresotutores' . "\0" . 'parentescoid', '' . "\0" . 'AppBundle\\Entity\\BcPadresotutores' . "\0" . 'situacionconyugalid', '' . "\0" . 'AppBundle\\Entity\\BcPadresotutores' . "\0" . 'tutorid'];
        }

        return ['__isInitialized__', '' . "\0" . 'AppBundle\\Entity\\BcPadresotutores' . "\0" . 'nivelestudioid', '' . "\0" . 'AppBundle\\Entity\\BcPadresotutores' . "\0" . 'ocupacion', '' . "\0" . 'AppBundle\\Entity\\BcPadresotutores' . "\0" . 'tiposanguineoid', '' . "\0" . 'AppBundle\\Entity\\BcPadresotutores' . "\0" . 'generacionid', '' . "\0" . 'AppBundle\\Entity\\BcPadresotutores' . "\0" . 'nacionalidadid', '' . "\0" . 'AppBundle\\Entity\\BcPadresotutores' . "\0" . 'nombre', '' . "\0" . 'AppBundle\\Entity\\BcPadresotutores' . "\0" . 'apellidopaterno', '' . "\0" . 'AppBundle\\Entity\\BcPadresotutores' . "\0" . 'apellidomaterno', '' . "\0" . 'AppBundle\\Entity\\BcPadresotutores' . "\0" . 'telefono', '' . "\0" . 'AppBundle\\Entity\\BcPadresotutores' . "\0" . 'celular', '' . "\0" . 'AppBundle\\Entity\\BcPadresotutores' . "\0" . 'lugartrabajo', '' . "\0" . 'AppBundle\\Entity\\BcPadresotutores' . "\0" . 'capturadordatos', '' . "\0" . 'AppBundle\\Entity\\BcPadresotutores' . "\0" . 'autoriza', '' . "\0" . 'AppBundle\\Entity\\BcPadresotutores' . "\0" . 'tutor', '' . "\0" . 'AppBundle\\Entity\\BcPadresotutores' . "\0" . 'foto', '' . "\0" . 'AppBundle\\Entity\\BcPadresotutores' . "\0" . 'curp', '' . "\0" . 'AppBundle\\Entity\\BcPadresotutores' . "\0" . 'vive', '' . "\0" . 'AppBundle\\Entity\\BcPadresotutores' . "\0" . 'fechanacimiento', '' . "\0" . 'AppBundle\\Entity\\BcPadresotutores' . "\0" . 'especificacionocupacion', '' . "\0" . 'AppBundle\\Entity\\BcPadresotutores' . "\0" . 'empresa', '' . "\0" . 'AppBundle\\Entity\\BcPadresotutores' . "\0" . 'correo', '' . "\0" . 'AppBundle\\Entity\\BcPadresotutores' . "\0" . 'telempresa', '' . "\0" . 'AppBundle\\Entity\\BcPadresotutores' . "\0" . 'extensionempresa', '' . "\0" . 'AppBundle\\Entity\\BcPadresotutores' . "\0" . 'horariotrabajo', '' . "\0" . 'AppBundle\\Entity\\BcPadresotutores' . "\0" . 'exlux', '' . "\0" . 'AppBundle\\Entity\\BcPadresotutores' . "\0" . 'ramo', '' . "\0" . 'AppBundle\\Entity\\BcPadresotutores' . "\0" . 'alumnoinstituto', '' . "\0" . 'AppBundle\\Entity\\BcPadresotutores' . "\0" . 'especificaralumno', '' . "\0" . 'AppBundle\\Entity\\BcPadresotutores' . "\0" . 'custodia', '' . "\0" . 'AppBundle\\Entity\\BcPadresotutores' . "\0" . 'antiguedad', '' . "\0" . 'AppBundle\\Entity\\BcPadresotutores' . "\0" . 'nombrejefeinmediato', '' . "\0" . 'AppBundle\\Entity\\BcPadresotutores' . "\0" . 'domicilioempresa', '' . "\0" . 'AppBundle\\Entity\\BcPadresotutores' . "\0" . 'clavefamiliarid', '' . "\0" . 'AppBundle\\Entity\\BcPadresotutores' . "\0" . 'padresotutoresid', '' . "\0" . 'AppBundle\\Entity\\BcPadresotutores' . "\0" . 'ingresosluxid', '' . "\0" . 'AppBundle\\Entity\\BcPadresotutores' . "\0" . 'solicitudid', '' . "\0" . 'AppBundle\\Entity\\BcPadresotutores' . "\0" . 'escolaridadid', '' . "\0" . 'AppBundle\\Entity\\BcPadresotutores' . "\0" . 'parentescoid', '' . "\0" . 'AppBundle\\Entity\\BcPadresotutores' . "\0" . 'situacionconyugalid', '' . "\0" . 'AppBundle\\Entity\\BcPadresotutores' . "\0" . 'tutorid'];
    }

    /**
     * 
     */
    public function __wakeup()
    {
        if ( ! $this->__isInitialized__) {
            $this->__initializer__ = function (BcPadresotutores $proxy) {
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
    public function setNivelestudioid($nivelestudioid)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setNivelestudioid', [$nivelestudioid]);

        return parent::setNivelestudioid($nivelestudioid);
    }

    /**
     * {@inheritDoc}
     */
    public function getNivelestudioid()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getNivelestudioid', []);

        return parent::getNivelestudioid();
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
    public function setTiposanguineoid($tiposanguineoid)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setTiposanguineoid', [$tiposanguineoid]);

        return parent::setTiposanguineoid($tiposanguineoid);
    }

    /**
     * {@inheritDoc}
     */
    public function getTiposanguineoid()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getTiposanguineoid', []);

        return parent::getTiposanguineoid();
    }

    /**
     * {@inheritDoc}
     */
    public function setGeneracionid($generacionid)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setGeneracionid', [$generacionid]);

        return parent::setGeneracionid($generacionid);
    }

    /**
     * {@inheritDoc}
     */
    public function getGeneracionid()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getGeneracionid', []);

        return parent::getGeneracionid();
    }

    /**
     * {@inheritDoc}
     */
    public function setNacionalidadid($nacionalidadid)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setNacionalidadid', [$nacionalidadid]);

        return parent::setNacionalidadid($nacionalidadid);
    }

    /**
     * {@inheritDoc}
     */
    public function getNacionalidadid()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getNacionalidadid', []);

        return parent::getNacionalidadid();
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
    public function setLugartrabajo($lugartrabajo)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setLugartrabajo', [$lugartrabajo]);

        return parent::setLugartrabajo($lugartrabajo);
    }

    /**
     * {@inheritDoc}
     */
    public function getLugartrabajo()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getLugartrabajo', []);

        return parent::getLugartrabajo();
    }

    /**
     * {@inheritDoc}
     */
    public function setCapturadordatos($capturadordatos)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setCapturadordatos', [$capturadordatos]);

        return parent::setCapturadordatos($capturadordatos);
    }

    /**
     * {@inheritDoc}
     */
    public function getCapturadordatos()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getCapturadordatos', []);

        return parent::getCapturadordatos();
    }

    /**
     * {@inheritDoc}
     */
    public function setAutoriza($autoriza)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setAutoriza', [$autoriza]);

        return parent::setAutoriza($autoriza);
    }

    /**
     * {@inheritDoc}
     */
    public function getAutoriza()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getAutoriza', []);

        return parent::getAutoriza();
    }

    /**
     * {@inheritDoc}
     */
    public function setTutor($tutor)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setTutor', [$tutor]);

        return parent::setTutor($tutor);
    }

    /**
     * {@inheritDoc}
     */
    public function getTutor()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getTutor', []);

        return parent::getTutor();
    }

    /**
     * {@inheritDoc}
     */
    public function setFoto($foto)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setFoto', [$foto]);

        return parent::setFoto($foto);
    }

    /**
     * {@inheritDoc}
     */
    public function getFoto()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getFoto', []);

        return parent::getFoto();
    }

    /**
     * {@inheritDoc}
     */
    public function setCurp($curp)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setCurp', [$curp]);

        return parent::setCurp($curp);
    }

    /**
     * {@inheritDoc}
     */
    public function getCurp()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getCurp', []);

        return parent::getCurp();
    }

    /**
     * {@inheritDoc}
     */
    public function setVive($vive)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setVive', [$vive]);

        return parent::setVive($vive);
    }

    /**
     * {@inheritDoc}
     */
    public function getVive()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getVive', []);

        return parent::getVive();
    }

    /**
     * {@inheritDoc}
     */
    public function setFechanacimiento($fechanacimiento)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setFechanacimiento', [$fechanacimiento]);

        return parent::setFechanacimiento($fechanacimiento);
    }

    /**
     * {@inheritDoc}
     */
    public function getFechanacimiento()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getFechanacimiento', []);

        return parent::getFechanacimiento();
    }

    /**
     * {@inheritDoc}
     */
    public function setEspecificacionocupacion($especificacionocupacion)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setEspecificacionocupacion', [$especificacionocupacion]);

        return parent::setEspecificacionocupacion($especificacionocupacion);
    }

    /**
     * {@inheritDoc}
     */
    public function getEspecificacionocupacion()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getEspecificacionocupacion', []);

        return parent::getEspecificacionocupacion();
    }

    /**
     * {@inheritDoc}
     */
    public function setEmpresa($empresa)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setEmpresa', [$empresa]);

        return parent::setEmpresa($empresa);
    }

    /**
     * {@inheritDoc}
     */
    public function getEmpresa()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getEmpresa', []);

        return parent::getEmpresa();
    }

    /**
     * {@inheritDoc}
     */
    public function setCorreo($correo)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setCorreo', [$correo]);

        return parent::setCorreo($correo);
    }

    /**
     * {@inheritDoc}
     */
    public function getCorreo()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getCorreo', []);

        return parent::getCorreo();
    }

    /**
     * {@inheritDoc}
     */
    public function setTelempresa($telempresa)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setTelempresa', [$telempresa]);

        return parent::setTelempresa($telempresa);
    }

    /**
     * {@inheritDoc}
     */
    public function getTelempresa()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getTelempresa', []);

        return parent::getTelempresa();
    }

    /**
     * {@inheritDoc}
     */
    public function setExtensionempresa($extensionempresa)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setExtensionempresa', [$extensionempresa]);

        return parent::setExtensionempresa($extensionempresa);
    }

    /**
     * {@inheritDoc}
     */
    public function getExtensionempresa()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getExtensionempresa', []);

        return parent::getExtensionempresa();
    }

    /**
     * {@inheritDoc}
     */
    public function setHorariotrabajo($horariotrabajo)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setHorariotrabajo', [$horariotrabajo]);

        return parent::setHorariotrabajo($horariotrabajo);
    }

    /**
     * {@inheritDoc}
     */
    public function getHorariotrabajo()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getHorariotrabajo', []);

        return parent::getHorariotrabajo();
    }

    /**
     * {@inheritDoc}
     */
    public function setExlux($exlux)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setExlux', [$exlux]);

        return parent::setExlux($exlux);
    }

    /**
     * {@inheritDoc}
     */
    public function getExlux()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getExlux', []);

        return parent::getExlux();
    }

    /**
     * {@inheritDoc}
     */
    public function setRamo($ramo)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setRamo', [$ramo]);

        return parent::setRamo($ramo);
    }

    /**
     * {@inheritDoc}
     */
    public function getRamo()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getRamo', []);

        return parent::getRamo();
    }

    /**
     * {@inheritDoc}
     */
    public function setAlumnoinstituto($alumnoinstituto)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setAlumnoinstituto', [$alumnoinstituto]);

        return parent::setAlumnoinstituto($alumnoinstituto);
    }

    /**
     * {@inheritDoc}
     */
    public function getAlumnoinstituto()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getAlumnoinstituto', []);

        return parent::getAlumnoinstituto();
    }

    /**
     * {@inheritDoc}
     */
    public function setEspecificaralumno($especificaralumno)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setEspecificaralumno', [$especificaralumno]);

        return parent::setEspecificaralumno($especificaralumno);
    }

    /**
     * {@inheritDoc}
     */
    public function getEspecificaralumno()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getEspecificaralumno', []);

        return parent::getEspecificaralumno();
    }

    /**
     * {@inheritDoc}
     */
    public function setCustodia($custodia)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setCustodia', [$custodia]);

        return parent::setCustodia($custodia);
    }

    /**
     * {@inheritDoc}
     */
    public function getCustodia()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getCustodia', []);

        return parent::getCustodia();
    }

    /**
     * {@inheritDoc}
     */
    public function setAntiguedad($antiguedad)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setAntiguedad', [$antiguedad]);

        return parent::setAntiguedad($antiguedad);
    }

    /**
     * {@inheritDoc}
     */
    public function getAntiguedad()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getAntiguedad', []);

        return parent::getAntiguedad();
    }

    /**
     * {@inheritDoc}
     */
    public function setNombrejefeinmediato($nombrejefeinmediato)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setNombrejefeinmediato', [$nombrejefeinmediato]);

        return parent::setNombrejefeinmediato($nombrejefeinmediato);
    }

    /**
     * {@inheritDoc}
     */
    public function getNombrejefeinmediato()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getNombrejefeinmediato', []);

        return parent::getNombrejefeinmediato();
    }

    /**
     * {@inheritDoc}
     */
    public function setDomicilioempresa($domicilioempresa)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setDomicilioempresa', [$domicilioempresa]);

        return parent::setDomicilioempresa($domicilioempresa);
    }

    /**
     * {@inheritDoc}
     */
    public function getDomicilioempresa()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getDomicilioempresa', []);

        return parent::getDomicilioempresa();
    }

    /**
     * {@inheritDoc}
     */
    public function setClavefamiliarid($clavefamiliarid)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setClavefamiliarid', [$clavefamiliarid]);

        return parent::setClavefamiliarid($clavefamiliarid);
    }

    /**
     * {@inheritDoc}
     */
    public function getClavefamiliarid()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getClavefamiliarid', []);

        return parent::getClavefamiliarid();
    }

    /**
     * {@inheritDoc}
     */
    public function getPadresotutoresid()
    {
        if ($this->__isInitialized__ === false) {
            return (int)  parent::getPadresotutoresid();
        }


        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getPadresotutoresid', []);

        return parent::getPadresotutoresid();
    }

    /**
     * {@inheritDoc}
     */
    public function setIngresosluxid(\AppBundle\Entity\BcIngresoslux $ingresosluxid = NULL)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setIngresosluxid', [$ingresosluxid]);

        return parent::setIngresosluxid($ingresosluxid);
    }

    /**
     * {@inheritDoc}
     */
    public function getIngresosluxid()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getIngresosluxid', []);

        return parent::getIngresosluxid();
    }

    /**
     * {@inheritDoc}
     */
    public function setSolicitudid(\AppBundle\Entity\BcSolicitudbeca $solicitudid = NULL)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setSolicitudid', [$solicitudid]);

        return parent::setSolicitudid($solicitudid);
    }

    /**
     * {@inheritDoc}
     */
    public function getSolicitudid()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getSolicitudid', []);

        return parent::getSolicitudid();
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

    /**
     * {@inheritDoc}
     */
    public function setParentescoid(\AppBundle\Entity\Parentesco $parentescoid = NULL)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setParentescoid', [$parentescoid]);

        return parent::setParentescoid($parentescoid);
    }

    /**
     * {@inheritDoc}
     */
    public function getParentescoid()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getParentescoid', []);

        return parent::getParentescoid();
    }

    /**
     * {@inheritDoc}
     */
    public function setSituacionconyugalid(\AppBundle\Entity\Situacionconyugal $situacionconyugalid = NULL)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setSituacionconyugalid', [$situacionconyugalid]);

        return parent::setSituacionconyugalid($situacionconyugalid);
    }

    /**
     * {@inheritDoc}
     */
    public function getSituacionconyugalid()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getSituacionconyugalid', []);

        return parent::getSituacionconyugalid();
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
