<?php

namespace Proxies\__CG__\AppBundle\Entity;

/**
 * DO NOT EDIT THIS FILE - IT WAS CREATED BY DOCTRINE'S PROXY GENERATOR
 */
class CePadresotutoresfacturacion extends \AppBundle\Entity\CePadresotutoresfacturacion implements \Doctrine\ORM\Proxy\Proxy
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
            return ['__isInitialized__', '' . "\0" . 'AppBundle\\Entity\\CePadresotutoresfacturacion' . "\0" . 'tipopersonaid', '' . "\0" . 'AppBundle\\Entity\\CePadresotutoresfacturacion' . "\0" . 'rfc', '' . "\0" . 'AppBundle\\Entity\\CePadresotutoresfacturacion' . "\0" . 'razonsocial', '' . "\0" . 'AppBundle\\Entity\\CePadresotutoresfacturacion' . "\0" . 'correo', '' . "\0" . 'AppBundle\\Entity\\CePadresotutoresfacturacion' . "\0" . 'esautomaticacolegiatura', '' . "\0" . 'AppBundle\\Entity\\CePadresotutoresfacturacion' . "\0" . 'esautomaticaotros', '' . "\0" . 'AppBundle\\Entity\\CePadresotutoresfacturacion' . "\0" . 'activo', '' . "\0" . 'AppBundle\\Entity\\CePadresotutoresfacturacion' . "\0" . 'padresotutoresfacturacionid', '' . "\0" . 'AppBundle\\Entity\\CePadresotutoresfacturacion' . "\0" . 'padresotutoresdomicilioid', '' . "\0" . 'AppBundle\\Entity\\CePadresotutoresfacturacion' . "\0" . 'padresotutoresid'];
        }

        return ['__isInitialized__', '' . "\0" . 'AppBundle\\Entity\\CePadresotutoresfacturacion' . "\0" . 'tipopersonaid', '' . "\0" . 'AppBundle\\Entity\\CePadresotutoresfacturacion' . "\0" . 'rfc', '' . "\0" . 'AppBundle\\Entity\\CePadresotutoresfacturacion' . "\0" . 'razonsocial', '' . "\0" . 'AppBundle\\Entity\\CePadresotutoresfacturacion' . "\0" . 'correo', '' . "\0" . 'AppBundle\\Entity\\CePadresotutoresfacturacion' . "\0" . 'esautomaticacolegiatura', '' . "\0" . 'AppBundle\\Entity\\CePadresotutoresfacturacion' . "\0" . 'esautomaticaotros', '' . "\0" . 'AppBundle\\Entity\\CePadresotutoresfacturacion' . "\0" . 'activo', '' . "\0" . 'AppBundle\\Entity\\CePadresotutoresfacturacion' . "\0" . 'padresotutoresfacturacionid', '' . "\0" . 'AppBundle\\Entity\\CePadresotutoresfacturacion' . "\0" . 'padresotutoresdomicilioid', '' . "\0" . 'AppBundle\\Entity\\CePadresotutoresfacturacion' . "\0" . 'padresotutoresid'];
    }

    /**
     * 
     */
    public function __wakeup()
    {
        if ( ! $this->__isInitialized__) {
            $this->__initializer__ = function (CePadresotutoresfacturacion $proxy) {
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
    public function setTipopersonaid($tipopersonaid)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setTipopersonaid', [$tipopersonaid]);

        return parent::setTipopersonaid($tipopersonaid);
    }

    /**
     * {@inheritDoc}
     */
    public function getTipopersonaid()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getTipopersonaid', []);

        return parent::getTipopersonaid();
    }

    /**
     * {@inheritDoc}
     */
    public function setRfc($rfc)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setRfc', [$rfc]);

        return parent::setRfc($rfc);
    }

    /**
     * {@inheritDoc}
     */
    public function getRfc()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getRfc', []);

        return parent::getRfc();
    }

    /**
     * {@inheritDoc}
     */
    public function setRazonsocial($razonsocial)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setRazonsocial', [$razonsocial]);

        return parent::setRazonsocial($razonsocial);
    }

    /**
     * {@inheritDoc}
     */
    public function getRazonsocial()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getRazonsocial', []);

        return parent::getRazonsocial();
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
    public function setEsautomaticacolegiatura($esautomaticacolegiatura)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setEsautomaticacolegiatura', [$esautomaticacolegiatura]);

        return parent::setEsautomaticacolegiatura($esautomaticacolegiatura);
    }

    /**
     * {@inheritDoc}
     */
    public function getEsautomaticacolegiatura()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getEsautomaticacolegiatura', []);

        return parent::getEsautomaticacolegiatura();
    }

    /**
     * {@inheritDoc}
     */
    public function setEsautomaticaotros($esautomaticaotros)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setEsautomaticaotros', [$esautomaticaotros]);

        return parent::setEsautomaticaotros($esautomaticaotros);
    }

    /**
     * {@inheritDoc}
     */
    public function getEsautomaticaotros()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getEsautomaticaotros', []);

        return parent::getEsautomaticaotros();
    }

    /**
     * {@inheritDoc}
     */
    public function setActivo($activo)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setActivo', [$activo]);

        return parent::setActivo($activo);
    }

    /**
     * {@inheritDoc}
     */
    public function getActivo()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getActivo', []);

        return parent::getActivo();
    }

    /**
     * {@inheritDoc}
     */
    public function getPadresotutoresfacturacionid()
    {
        if ($this->__isInitialized__ === false) {
            return (int)  parent::getPadresotutoresfacturacionid();
        }


        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getPadresotutoresfacturacionid', []);

        return parent::getPadresotutoresfacturacionid();
    }

    /**
     * {@inheritDoc}
     */
    public function setPadresotutoresdomicilioid(\AppBundle\Entity\CePadresotutoresdomicilio $padresotutoresdomicilioid = NULL)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setPadresotutoresdomicilioid', [$padresotutoresdomicilioid]);

        return parent::setPadresotutoresdomicilioid($padresotutoresdomicilioid);
    }

    /**
     * {@inheritDoc}
     */
    public function getPadresotutoresdomicilioid()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getPadresotutoresdomicilioid', []);

        return parent::getPadresotutoresdomicilioid();
    }

    /**
     * {@inheritDoc}
     */
    public function setPadresotutoresid(\AppBundle\Entity\CePadresotutores $padresotutoresid = NULL)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setPadresotutoresid', [$padresotutoresid]);

        return parent::setPadresotutoresid($padresotutoresid);
    }

    /**
     * {@inheritDoc}
     */
    public function getPadresotutoresid()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getPadresotutoresid', []);

        return parent::getPadresotutoresid();
    }

}
