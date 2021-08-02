<?php

namespace Proxies\__CG__\AppBundle\Entity;

/**
 * DO NOT EDIT THIS FILE - IT WAS CREATED BY DOCTRINE'S PROXY GENERATOR
 */
class CePlanestudios extends \AppBundle\Entity\CePlanestudios implements \Doctrine\ORM\Proxy\Proxy
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
            return ['__isInitialized__', '' . "\0" . 'AppBundle\\Entity\\CePlanestudios' . "\0" . 'nombre', '' . "\0" . 'AppBundle\\Entity\\CePlanestudios' . "\0" . 'vigente', '' . "\0" . 'AppBundle\\Entity\\CePlanestudios' . "\0" . 'puntopase', '' . "\0" . 'AppBundle\\Entity\\CePlanestudios' . "\0" . 'calificacionminima', '' . "\0" . 'AppBundle\\Entity\\CePlanestudios' . "\0" . 'decimalescapturanumerica', '' . "\0" . 'AppBundle\\Entity\\CePlanestudios' . "\0" . 'calificacionextraordinario', '' . "\0" . 'AppBundle\\Entity\\CePlanestudios' . "\0" . 'planestudioid', '' . "\0" . 'AppBundle\\Entity\\CePlanestudios' . "\0" . 'areaespecializacionid', '' . "\0" . 'AppBundle\\Entity\\CePlanestudios' . "\0" . 'ciclofinalid', '' . "\0" . 'AppBundle\\Entity\\CePlanestudios' . "\0" . 'cicloinicialid', '' . "\0" . 'AppBundle\\Entity\\CePlanestudios' . "\0" . 'gradoid', '' . "\0" . 'AppBundle\\Entity\\CePlanestudios' . "\0" . 'tiporedondeofinalid', '' . "\0" . 'AppBundle\\Entity\\CePlanestudios' . "\0" . 'tiporedondeoperiodoid', '' . "\0" . 'AppBundle\\Entity\\CePlanestudios' . "\0" . 'tiporedondeocalfinalid'];
        }

        return ['__isInitialized__', '' . "\0" . 'AppBundle\\Entity\\CePlanestudios' . "\0" . 'nombre', '' . "\0" . 'AppBundle\\Entity\\CePlanestudios' . "\0" . 'vigente', '' . "\0" . 'AppBundle\\Entity\\CePlanestudios' . "\0" . 'puntopase', '' . "\0" . 'AppBundle\\Entity\\CePlanestudios' . "\0" . 'calificacionminima', '' . "\0" . 'AppBundle\\Entity\\CePlanestudios' . "\0" . 'decimalescapturanumerica', '' . "\0" . 'AppBundle\\Entity\\CePlanestudios' . "\0" . 'calificacionextraordinario', '' . "\0" . 'AppBundle\\Entity\\CePlanestudios' . "\0" . 'planestudioid', '' . "\0" . 'AppBundle\\Entity\\CePlanestudios' . "\0" . 'areaespecializacionid', '' . "\0" . 'AppBundle\\Entity\\CePlanestudios' . "\0" . 'ciclofinalid', '' . "\0" . 'AppBundle\\Entity\\CePlanestudios' . "\0" . 'cicloinicialid', '' . "\0" . 'AppBundle\\Entity\\CePlanestudios' . "\0" . 'gradoid', '' . "\0" . 'AppBundle\\Entity\\CePlanestudios' . "\0" . 'tiporedondeofinalid', '' . "\0" . 'AppBundle\\Entity\\CePlanestudios' . "\0" . 'tiporedondeoperiodoid', '' . "\0" . 'AppBundle\\Entity\\CePlanestudios' . "\0" . 'tiporedondeocalfinalid'];
    }

    /**
     * 
     */
    public function __wakeup()
    {
        if ( ! $this->__isInitialized__) {
            $this->__initializer__ = function (CePlanestudios $proxy) {
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
    public function setVigente($vigente)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setVigente', [$vigente]);

        return parent::setVigente($vigente);
    }

    /**
     * {@inheritDoc}
     */
    public function getVigente()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getVigente', []);

        return parent::getVigente();
    }

    /**
     * {@inheritDoc}
     */
    public function setPuntopase($puntopase)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setPuntopase', [$puntopase]);

        return parent::setPuntopase($puntopase);
    }

    /**
     * {@inheritDoc}
     */
    public function getPuntopase()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getPuntopase', []);

        return parent::getPuntopase();
    }

    /**
     * {@inheritDoc}
     */
    public function setCalificacionminima($calificacionminima)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setCalificacionminima', [$calificacionminima]);

        return parent::setCalificacionminima($calificacionminima);
    }

    /**
     * {@inheritDoc}
     */
    public function getCalificacionminima()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getCalificacionminima', []);

        return parent::getCalificacionminima();
    }

    /**
     * {@inheritDoc}
     */
    public function setDecimalescapturanumerica($decimalescapturanumerica)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setDecimalescapturanumerica', [$decimalescapturanumerica]);

        return parent::setDecimalescapturanumerica($decimalescapturanumerica);
    }

    /**
     * {@inheritDoc}
     */
    public function getDecimalescapturanumerica()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getDecimalescapturanumerica', []);

        return parent::getDecimalescapturanumerica();
    }

    /**
     * {@inheritDoc}
     */
    public function setCalificacionextraordinario($calificacionextraordinario)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setCalificacionextraordinario', [$calificacionextraordinario]);

        return parent::setCalificacionextraordinario($calificacionextraordinario);
    }

    /**
     * {@inheritDoc}
     */
    public function getCalificacionextraordinario()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getCalificacionextraordinario', []);

        return parent::getCalificacionextraordinario();
    }

    /**
     * {@inheritDoc}
     */
    public function getPlanestudioid()
    {
        if ($this->__isInitialized__ === false) {
            return (int)  parent::getPlanestudioid();
        }


        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getPlanestudioid', []);

        return parent::getPlanestudioid();
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
    public function setCiclofinalid(\AppBundle\Entity\Ciclo $ciclofinalid = NULL)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setCiclofinalid', [$ciclofinalid]);

        return parent::setCiclofinalid($ciclofinalid);
    }

    /**
     * {@inheritDoc}
     */
    public function getCiclofinalid()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getCiclofinalid', []);

        return parent::getCiclofinalid();
    }

    /**
     * {@inheritDoc}
     */
    public function setCicloinicialid(\AppBundle\Entity\Ciclo $cicloinicialid = NULL)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setCicloinicialid', [$cicloinicialid]);

        return parent::setCicloinicialid($cicloinicialid);
    }

    /**
     * {@inheritDoc}
     */
    public function getCicloinicialid()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getCicloinicialid', []);

        return parent::getCicloinicialid();
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

    /**
     * {@inheritDoc}
     */
    public function setTiporedondeofinalid(\AppBundle\Entity\CeTiporedondeo $tiporedondeofinalid = NULL)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setTiporedondeofinalid', [$tiporedondeofinalid]);

        return parent::setTiporedondeofinalid($tiporedondeofinalid);
    }

    /**
     * {@inheritDoc}
     */
    public function getTiporedondeofinalid()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getTiporedondeofinalid', []);

        return parent::getTiporedondeofinalid();
    }

    /**
     * {@inheritDoc}
     */
    public function setTiporedondeoperiodoid(\AppBundle\Entity\CeTiporedondeo $tiporedondeoperiodoid = NULL)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setTiporedondeoperiodoid', [$tiporedondeoperiodoid]);

        return parent::setTiporedondeoperiodoid($tiporedondeoperiodoid);
    }

    /**
     * {@inheritDoc}
     */
    public function getTiporedondeoperiodoid()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getTiporedondeoperiodoid', []);

        return parent::getTiporedondeoperiodoid();
    }

    /**
     * {@inheritDoc}
     */
    public function setTiporedondeocalfinalid(\AppBundle\Entity\CeTiporedondeo $tiporedondeocalfinalid = NULL)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setTiporedondeocalfinalid', [$tiporedondeocalfinalid]);

        return parent::setTiporedondeocalfinalid($tiporedondeocalfinalid);
    }

    /**
     * {@inheritDoc}
     */
    public function getTiporedondeocalfinalid()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getTiporedondeocalfinalid', []);

        return parent::getTiporedondeocalfinalid();
    }

}
