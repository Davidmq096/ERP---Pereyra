<?php

namespace Proxies\__CG__\AppBundle\Entity;

/**
 * DO NOT EDIT THIS FILE - IT WAS CREATED BY DOCTRINE'S PROXY GENERATOR
 */
class CeAlumnodinamicafamiliar extends \AppBundle\Entity\CeAlumnodinamicafamiliar implements \Doctrine\ORM\Proxy\Proxy
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
            return ['__isInitialized__', '' . "\0" . 'AppBundle\\Entity\\CeAlumnodinamicafamiliar' . "\0" . 'ninguna', '' . "\0" . 'AppBundle\\Entity\\CeAlumnodinamicafamiliar' . "\0" . 'divorcio', '' . "\0" . 'AppBundle\\Entity\\CeAlumnodinamicafamiliar' . "\0" . 'separacion', '' . "\0" . 'AppBundle\\Entity\\CeAlumnodinamicafamiliar' . "\0" . 'custodia', '' . "\0" . 'AppBundle\\Entity\\CeAlumnodinamicafamiliar' . "\0" . 'enfermedadgrave', '' . "\0" . 'AppBundle\\Entity\\CeAlumnodinamicafamiliar' . "\0" . 'miembroenfermedadgrave', '' . "\0" . 'AppBundle\\Entity\\CeAlumnodinamicafamiliar' . "\0" . 'muerteperdida', '' . "\0" . 'AppBundle\\Entity\\CeAlumnodinamicafamiliar' . "\0" . 'miembromuerteperdida', '' . "\0" . 'AppBundle\\Entity\\CeAlumnodinamicafamiliar' . "\0" . 'cambioresidencia', '' . "\0" . 'AppBundle\\Entity\\CeAlumnodinamicafamiliar' . "\0" . 'medioshermanos', '' . "\0" . 'AppBundle\\Entity\\CeAlumnodinamicafamiliar' . "\0" . 'madrepadresoltero', '' . "\0" . 'AppBundle\\Entity\\CeAlumnodinamicafamiliar' . "\0" . 'segundosmatrimonios', '' . "\0" . 'AppBundle\\Entity\\CeAlumnodinamicafamiliar' . "\0" . 'otros', '' . "\0" . 'AppBundle\\Entity\\CeAlumnodinamicafamiliar' . "\0" . 'descripcionotros', '' . "\0" . 'AppBundle\\Entity\\CeAlumnodinamicafamiliar' . "\0" . 'alumnodinamicafamiliarid', '' . "\0" . 'AppBundle\\Entity\\CeAlumnodinamicafamiliar' . "\0" . 'alumnoid', '' . "\0" . 'AppBundle\\Entity\\CeAlumnodinamicafamiliar' . "\0" . 'parentescoid'];
        }

        return ['__isInitialized__', '' . "\0" . 'AppBundle\\Entity\\CeAlumnodinamicafamiliar' . "\0" . 'ninguna', '' . "\0" . 'AppBundle\\Entity\\CeAlumnodinamicafamiliar' . "\0" . 'divorcio', '' . "\0" . 'AppBundle\\Entity\\CeAlumnodinamicafamiliar' . "\0" . 'separacion', '' . "\0" . 'AppBundle\\Entity\\CeAlumnodinamicafamiliar' . "\0" . 'custodia', '' . "\0" . 'AppBundle\\Entity\\CeAlumnodinamicafamiliar' . "\0" . 'enfermedadgrave', '' . "\0" . 'AppBundle\\Entity\\CeAlumnodinamicafamiliar' . "\0" . 'miembroenfermedadgrave', '' . "\0" . 'AppBundle\\Entity\\CeAlumnodinamicafamiliar' . "\0" . 'muerteperdida', '' . "\0" . 'AppBundle\\Entity\\CeAlumnodinamicafamiliar' . "\0" . 'miembromuerteperdida', '' . "\0" . 'AppBundle\\Entity\\CeAlumnodinamicafamiliar' . "\0" . 'cambioresidencia', '' . "\0" . 'AppBundle\\Entity\\CeAlumnodinamicafamiliar' . "\0" . 'medioshermanos', '' . "\0" . 'AppBundle\\Entity\\CeAlumnodinamicafamiliar' . "\0" . 'madrepadresoltero', '' . "\0" . 'AppBundle\\Entity\\CeAlumnodinamicafamiliar' . "\0" . 'segundosmatrimonios', '' . "\0" . 'AppBundle\\Entity\\CeAlumnodinamicafamiliar' . "\0" . 'otros', '' . "\0" . 'AppBundle\\Entity\\CeAlumnodinamicafamiliar' . "\0" . 'descripcionotros', '' . "\0" . 'AppBundle\\Entity\\CeAlumnodinamicafamiliar' . "\0" . 'alumnodinamicafamiliarid', '' . "\0" . 'AppBundle\\Entity\\CeAlumnodinamicafamiliar' . "\0" . 'alumnoid', '' . "\0" . 'AppBundle\\Entity\\CeAlumnodinamicafamiliar' . "\0" . 'parentescoid'];
    }

    /**
     * 
     */
    public function __wakeup()
    {
        if ( ! $this->__isInitialized__) {
            $this->__initializer__ = function (CeAlumnodinamicafamiliar $proxy) {
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
    public function setNinguna($ninguna)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setNinguna', [$ninguna]);

        return parent::setNinguna($ninguna);
    }

    /**
     * {@inheritDoc}
     */
    public function getNinguna()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getNinguna', []);

        return parent::getNinguna();
    }

    /**
     * {@inheritDoc}
     */
    public function setDivorcio($divorcio)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setDivorcio', [$divorcio]);

        return parent::setDivorcio($divorcio);
    }

    /**
     * {@inheritDoc}
     */
    public function getDivorcio()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getDivorcio', []);

        return parent::getDivorcio();
    }

    /**
     * {@inheritDoc}
     */
    public function setSeparacion($separacion)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setSeparacion', [$separacion]);

        return parent::setSeparacion($separacion);
    }

    /**
     * {@inheritDoc}
     */
    public function getSeparacion()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getSeparacion', []);

        return parent::getSeparacion();
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
    public function setEnfermedadgrave($enfermedadgrave)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setEnfermedadgrave', [$enfermedadgrave]);

        return parent::setEnfermedadgrave($enfermedadgrave);
    }

    /**
     * {@inheritDoc}
     */
    public function getEnfermedadgrave()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getEnfermedadgrave', []);

        return parent::getEnfermedadgrave();
    }

    /**
     * {@inheritDoc}
     */
    public function setMiembroenfermedadgrave($miembroenfermedadgrave)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setMiembroenfermedadgrave', [$miembroenfermedadgrave]);

        return parent::setMiembroenfermedadgrave($miembroenfermedadgrave);
    }

    /**
     * {@inheritDoc}
     */
    public function getMiembroenfermedadgrave()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getMiembroenfermedadgrave', []);

        return parent::getMiembroenfermedadgrave();
    }

    /**
     * {@inheritDoc}
     */
    public function setMuerteperdida($muerteperdida)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setMuerteperdida', [$muerteperdida]);

        return parent::setMuerteperdida($muerteperdida);
    }

    /**
     * {@inheritDoc}
     */
    public function getMuerteperdida()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getMuerteperdida', []);

        return parent::getMuerteperdida();
    }

    /**
     * {@inheritDoc}
     */
    public function setMiembromuerteperdida($miembromuerteperdida)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setMiembromuerteperdida', [$miembromuerteperdida]);

        return parent::setMiembromuerteperdida($miembromuerteperdida);
    }

    /**
     * {@inheritDoc}
     */
    public function getMiembromuerteperdida()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getMiembromuerteperdida', []);

        return parent::getMiembromuerteperdida();
    }

    /**
     * {@inheritDoc}
     */
    public function setCambioresidencia($cambioresidencia)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setCambioresidencia', [$cambioresidencia]);

        return parent::setCambioresidencia($cambioresidencia);
    }

    /**
     * {@inheritDoc}
     */
    public function getCambioresidencia()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getCambioresidencia', []);

        return parent::getCambioresidencia();
    }

    /**
     * {@inheritDoc}
     */
    public function setMedioshermanos($medioshermanos)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setMedioshermanos', [$medioshermanos]);

        return parent::setMedioshermanos($medioshermanos);
    }

    /**
     * {@inheritDoc}
     */
    public function getMedioshermanos()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getMedioshermanos', []);

        return parent::getMedioshermanos();
    }

    /**
     * {@inheritDoc}
     */
    public function setMadrepadresoltero($madrepadresoltero)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setMadrepadresoltero', [$madrepadresoltero]);

        return parent::setMadrepadresoltero($madrepadresoltero);
    }

    /**
     * {@inheritDoc}
     */
    public function getMadrepadresoltero()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getMadrepadresoltero', []);

        return parent::getMadrepadresoltero();
    }

    /**
     * {@inheritDoc}
     */
    public function setSegundosmatrimonios($segundosmatrimonios)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setSegundosmatrimonios', [$segundosmatrimonios]);

        return parent::setSegundosmatrimonios($segundosmatrimonios);
    }

    /**
     * {@inheritDoc}
     */
    public function getSegundosmatrimonios()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getSegundosmatrimonios', []);

        return parent::getSegundosmatrimonios();
    }

    /**
     * {@inheritDoc}
     */
    public function setOtros($otros)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setOtros', [$otros]);

        return parent::setOtros($otros);
    }

    /**
     * {@inheritDoc}
     */
    public function getOtros()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getOtros', []);

        return parent::getOtros();
    }

    /**
     * {@inheritDoc}
     */
    public function setDescripcionotros($descripcionotros)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setDescripcionotros', [$descripcionotros]);

        return parent::setDescripcionotros($descripcionotros);
    }

    /**
     * {@inheritDoc}
     */
    public function getDescripcionotros()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getDescripcionotros', []);

        return parent::getDescripcionotros();
    }

    /**
     * {@inheritDoc}
     */
    public function getAlumnodinamicafamiliarid()
    {
        if ($this->__isInitialized__ === false) {
            return (int)  parent::getAlumnodinamicafamiliarid();
        }


        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getAlumnodinamicafamiliarid', []);

        return parent::getAlumnodinamicafamiliarid();
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

}
