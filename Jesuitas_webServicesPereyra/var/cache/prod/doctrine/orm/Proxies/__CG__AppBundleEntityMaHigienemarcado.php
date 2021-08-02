<?php

namespace Proxies\__CG__\AppBundle\Entity;

/**
 * DO NOT EDIT THIS FILE - IT WAS CREATED BY DOCTRINE'S PROXY GENERATOR
 */
class MaHigienemarcado extends \AppBundle\Entity\MaHigienemarcado implements \Doctrine\ORM\Proxy\Proxy
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
            return ['__isInitialized__', '' . "\0" . 'AppBundle\\Entity\\MaHigienemarcado' . "\0" . 'hecho', '' . "\0" . 'AppBundle\\Entity\\MaHigienemarcado' . "\0" . 'archivado', '' . "\0" . 'AppBundle\\Entity\\MaHigienemarcado' . "\0" . 'higienemarcadoid', '' . "\0" . 'AppBundle\\Entity\\MaHigienemarcado' . "\0" . 'higieneid', '' . "\0" . 'AppBundle\\Entity\\MaHigienemarcado' . "\0" . 'informeid'];
        }

        return ['__isInitialized__', '' . "\0" . 'AppBundle\\Entity\\MaHigienemarcado' . "\0" . 'hecho', '' . "\0" . 'AppBundle\\Entity\\MaHigienemarcado' . "\0" . 'archivado', '' . "\0" . 'AppBundle\\Entity\\MaHigienemarcado' . "\0" . 'higienemarcadoid', '' . "\0" . 'AppBundle\\Entity\\MaHigienemarcado' . "\0" . 'higieneid', '' . "\0" . 'AppBundle\\Entity\\MaHigienemarcado' . "\0" . 'informeid'];
    }

    /**
     * 
     */
    public function __wakeup()
    {
        if ( ! $this->__isInitialized__) {
            $this->__initializer__ = function (MaHigienemarcado $proxy) {
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
    public function setHecho($hecho)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setHecho', [$hecho]);

        return parent::setHecho($hecho);
    }

    /**
     * {@inheritDoc}
     */
    public function getHecho()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getHecho', []);

        return parent::getHecho();
    }

    /**
     * {@inheritDoc}
     */
    public function setArchivado($archivado)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setArchivado', [$archivado]);

        return parent::setArchivado($archivado);
    }

    /**
     * {@inheritDoc}
     */
    public function getArchivado()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getArchivado', []);

        return parent::getArchivado();
    }

    /**
     * {@inheritDoc}
     */
    public function getHigienemarcadoid()
    {
        if ($this->__isInitialized__ === false) {
            return (int)  parent::getHigienemarcadoid();
        }


        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getHigienemarcadoid', []);

        return parent::getHigienemarcadoid();
    }

    /**
     * {@inheritDoc}
     */
    public function setHigieneid(\AppBundle\Entity\MaHigiene $higieneid = NULL)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setHigieneid', [$higieneid]);

        return parent::setHigieneid($higieneid);
    }

    /**
     * {@inheritDoc}
     */
    public function getHigieneid()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getHigieneid', []);

        return parent::getHigieneid();
    }

    /**
     * {@inheritDoc}
     */
    public function setInformeid(\AppBundle\Entity\MaInforme $informeid = NULL)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setInformeid', [$informeid]);

        return parent::setInformeid($informeid);
    }

    /**
     * {@inheritDoc}
     */
    public function getInformeid()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getInformeid', []);

        return parent::getInformeid();
    }

}