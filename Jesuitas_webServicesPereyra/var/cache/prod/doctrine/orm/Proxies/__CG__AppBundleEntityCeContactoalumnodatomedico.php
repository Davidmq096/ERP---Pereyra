<?php

namespace Proxies\__CG__\AppBundle\Entity;

/**
 * DO NOT EDIT THIS FILE - IT WAS CREATED BY DOCTRINE'S PROXY GENERATOR
 */
class CeContactoalumnodatomedico extends \AppBundle\Entity\CeContactoalumnodatomedico implements \Doctrine\ORM\Proxy\Proxy
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
            return ['__isInitialized__', '' . "\0" . 'AppBundle\\Entity\\CeContactoalumnodatomedico' . "\0" . 'contactoemergencianombre', '' . "\0" . 'AppBundle\\Entity\\CeContactoalumnodatomedico' . "\0" . 'contactoemergenciatelefono', '' . "\0" . 'AppBundle\\Entity\\CeContactoalumnodatomedico' . "\0" . 'contactoemergenciaparentesco', '' . "\0" . 'AppBundle\\Entity\\CeContactoalumnodatomedico' . "\0" . 'contactoemergenciaemail', '' . "\0" . 'AppBundle\\Entity\\CeContactoalumnodatomedico' . "\0" . 'alumnodatomedicoid', '' . "\0" . 'AppBundle\\Entity\\CeContactoalumnodatomedico' . "\0" . 'contactoalumnodatomedicoid'];
        }

        return ['__isInitialized__', '' . "\0" . 'AppBundle\\Entity\\CeContactoalumnodatomedico' . "\0" . 'contactoemergencianombre', '' . "\0" . 'AppBundle\\Entity\\CeContactoalumnodatomedico' . "\0" . 'contactoemergenciatelefono', '' . "\0" . 'AppBundle\\Entity\\CeContactoalumnodatomedico' . "\0" . 'contactoemergenciaparentesco', '' . "\0" . 'AppBundle\\Entity\\CeContactoalumnodatomedico' . "\0" . 'contactoemergenciaemail', '' . "\0" . 'AppBundle\\Entity\\CeContactoalumnodatomedico' . "\0" . 'alumnodatomedicoid', '' . "\0" . 'AppBundle\\Entity\\CeContactoalumnodatomedico' . "\0" . 'contactoalumnodatomedicoid'];
    }

    /**
     * 
     */
    public function __wakeup()
    {
        if ( ! $this->__isInitialized__) {
            $this->__initializer__ = function (CeContactoalumnodatomedico $proxy) {
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
    public function setContactoemergencianombre($contactoemergencianombre)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setContactoemergencianombre', [$contactoemergencianombre]);

        return parent::setContactoemergencianombre($contactoemergencianombre);
    }

    /**
     * {@inheritDoc}
     */
    public function getContactoemergencianombre()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getContactoemergencianombre', []);

        return parent::getContactoemergencianombre();
    }

    /**
     * {@inheritDoc}
     */
    public function setContactoemergenciatelefono($contactoemergenciatelefono)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setContactoemergenciatelefono', [$contactoemergenciatelefono]);

        return parent::setContactoemergenciatelefono($contactoemergenciatelefono);
    }

    /**
     * {@inheritDoc}
     */
    public function getContactoemergenciatelefono()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getContactoemergenciatelefono', []);

        return parent::getContactoemergenciatelefono();
    }

    /**
     * {@inheritDoc}
     */
    public function setContactoemergenciaparentesco($contactoemergenciaparentesco)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setContactoemergenciaparentesco', [$contactoemergenciaparentesco]);

        return parent::setContactoemergenciaparentesco($contactoemergenciaparentesco);
    }

    /**
     * {@inheritDoc}
     */
    public function getContactoemergenciaparentesco()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getContactoemergenciaparentesco', []);

        return parent::getContactoemergenciaparentesco();
    }

    /**
     * {@inheritDoc}
     */
    public function setContactoemergenciaemail($contactoemergenciaemail)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setContactoemergenciaemail', [$contactoemergenciaemail]);

        return parent::setContactoemergenciaemail($contactoemergenciaemail);
    }

    /**
     * {@inheritDoc}
     */
    public function getContactoemergenciaemail()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getContactoemergenciaemail', []);

        return parent::getContactoemergenciaemail();
    }

    /**
     * {@inheritDoc}
     */
    public function setAlumnodatomedicoid($alumnodatomedicoid)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setAlumnodatomedicoid', [$alumnodatomedicoid]);

        return parent::setAlumnodatomedicoid($alumnodatomedicoid);
    }

    /**
     * {@inheritDoc}
     */
    public function getAlumnodatomedicoid()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getAlumnodatomedicoid', []);

        return parent::getAlumnodatomedicoid();
    }

    /**
     * {@inheritDoc}
     */
    public function getContactoalumnodatomedicoid()
    {
        if ($this->__isInitialized__ === false) {
            return (int)  parent::getContactoalumnodatomedicoid();
        }


        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getContactoalumnodatomedicoid', []);

        return parent::getContactoalumnodatomedicoid();
    }

}
