<?php

namespace Proxies\__CG__\AppBundle\Entity;

/**
 * DO NOT EDIT THIS FILE - IT WAS CREATED BY DOCTRINE'S PROXY GENERATOR
 */
class BcDeudascreditos extends \AppBundle\Entity\BcDeudascreditos implements \Doctrine\ORM\Proxy\Proxy
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
            return ['__isInitialized__', '' . "\0" . 'AppBundle\\Entity\\BcDeudascreditos' . "\0" . 'importetotal', '' . "\0" . 'AppBundle\\Entity\\BcDeudascreditos' . "\0" . 'pagomensual', '' . "\0" . 'AppBundle\\Entity\\BcDeudascreditos' . "\0" . 'bancoinstitucion', '' . "\0" . 'AppBundle\\Entity\\BcDeudascreditos' . "\0" . 'limitecredito', '' . "\0" . 'AppBundle\\Entity\\BcDeudascreditos' . "\0" . 'portal', '' . "\0" . 'AppBundle\\Entity\\BcDeudascreditos' . "\0" . 'deudascreditosid', '' . "\0" . 'AppBundle\\Entity\\BcDeudascreditos' . "\0" . 'solicitudid', '' . "\0" . 'AppBundle\\Entity\\BcDeudascreditos' . "\0" . 'tipocreditoid'];
        }

        return ['__isInitialized__', '' . "\0" . 'AppBundle\\Entity\\BcDeudascreditos' . "\0" . 'importetotal', '' . "\0" . 'AppBundle\\Entity\\BcDeudascreditos' . "\0" . 'pagomensual', '' . "\0" . 'AppBundle\\Entity\\BcDeudascreditos' . "\0" . 'bancoinstitucion', '' . "\0" . 'AppBundle\\Entity\\BcDeudascreditos' . "\0" . 'limitecredito', '' . "\0" . 'AppBundle\\Entity\\BcDeudascreditos' . "\0" . 'portal', '' . "\0" . 'AppBundle\\Entity\\BcDeudascreditos' . "\0" . 'deudascreditosid', '' . "\0" . 'AppBundle\\Entity\\BcDeudascreditos' . "\0" . 'solicitudid', '' . "\0" . 'AppBundle\\Entity\\BcDeudascreditos' . "\0" . 'tipocreditoid'];
    }

    /**
     * 
     */
    public function __wakeup()
    {
        if ( ! $this->__isInitialized__) {
            $this->__initializer__ = function (BcDeudascreditos $proxy) {
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
    public function setImportetotal($importetotal)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setImportetotal', [$importetotal]);

        return parent::setImportetotal($importetotal);
    }

    /**
     * {@inheritDoc}
     */
    public function getImportetotal()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getImportetotal', []);

        return parent::getImportetotal();
    }

    /**
     * {@inheritDoc}
     */
    public function setPagomensual($pagomensual)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setPagomensual', [$pagomensual]);

        return parent::setPagomensual($pagomensual);
    }

    /**
     * {@inheritDoc}
     */
    public function getPagomensual()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getPagomensual', []);

        return parent::getPagomensual();
    }

    /**
     * {@inheritDoc}
     */
    public function setBancoinstitucion($bancoinstitucion)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setBancoinstitucion', [$bancoinstitucion]);

        return parent::setBancoinstitucion($bancoinstitucion);
    }

    /**
     * {@inheritDoc}
     */
    public function getBancoinstitucion()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getBancoinstitucion', []);

        return parent::getBancoinstitucion();
    }

    /**
     * {@inheritDoc}
     */
    public function setLimitecredito($limitecredito)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setLimitecredito', [$limitecredito]);

        return parent::setLimitecredito($limitecredito);
    }

    /**
     * {@inheritDoc}
     */
    public function getLimitecredito()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getLimitecredito', []);

        return parent::getLimitecredito();
    }

    /**
     * {@inheritDoc}
     */
    public function setPortal($portal)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setPortal', [$portal]);

        return parent::setPortal($portal);
    }

    /**
     * {@inheritDoc}
     */
    public function getPortal()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getPortal', []);

        return parent::getPortal();
    }

    /**
     * {@inheritDoc}
     */
    public function getDeudascreditosid()
    {
        if ($this->__isInitialized__ === false) {
            return (int)  parent::getDeudascreditosid();
        }


        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getDeudascreditosid', []);

        return parent::getDeudascreditosid();
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
    public function setTipocreditoid(\AppBundle\Entity\BcTipocredito $tipocreditoid = NULL)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setTipocreditoid', [$tipocreditoid]);

        return parent::setTipocreditoid($tipocreditoid);
    }

    /**
     * {@inheritDoc}
     */
    public function getTipocreditoid()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getTipocreditoid', []);

        return parent::getTipocreditoid();
    }

}
