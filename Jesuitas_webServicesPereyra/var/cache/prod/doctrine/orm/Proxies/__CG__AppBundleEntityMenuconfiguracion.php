<?php

namespace Proxies\__CG__\AppBundle\Entity;

/**
 * DO NOT EDIT THIS FILE - IT WAS CREATED BY DOCTRINE'S PROXY GENERATOR
 */
class Menuconfiguracion extends \AppBundle\Entity\Menuconfiguracion implements \Doctrine\ORM\Proxy\Proxy
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
            return ['__isInitialized__', '' . "\0" . 'AppBundle\\Entity\\Menuconfiguracion' . "\0" . 'sistema', '' . "\0" . 'AppBundle\\Entity\\Menuconfiguracion' . "\0" . 'title', '' . "\0" . 'AppBundle\\Entity\\Menuconfiguracion' . "\0" . 'key', '' . "\0" . 'AppBundle\\Entity\\Menuconfiguracion' . "\0" . 'icon', '' . "\0" . 'AppBundle\\Entity\\Menuconfiguracion' . "\0" . 'color', '' . "\0" . 'AppBundle\\Entity\\Menuconfiguracion' . "\0" . 'action', '' . "\0" . 'AppBundle\\Entity\\Menuconfiguracion' . "\0" . 'orden', '' . "\0" . 'AppBundle\\Entity\\Menuconfiguracion' . "\0" . 'activo', '' . "\0" . 'AppBundle\\Entity\\Menuconfiguracion' . "\0" . 'menuconfiguracionid', '' . "\0" . 'AppBundle\\Entity\\Menuconfiguracion' . "\0" . 'menuconfiguracionparentid'];
        }

        return ['__isInitialized__', '' . "\0" . 'AppBundle\\Entity\\Menuconfiguracion' . "\0" . 'sistema', '' . "\0" . 'AppBundle\\Entity\\Menuconfiguracion' . "\0" . 'title', '' . "\0" . 'AppBundle\\Entity\\Menuconfiguracion' . "\0" . 'key', '' . "\0" . 'AppBundle\\Entity\\Menuconfiguracion' . "\0" . 'icon', '' . "\0" . 'AppBundle\\Entity\\Menuconfiguracion' . "\0" . 'color', '' . "\0" . 'AppBundle\\Entity\\Menuconfiguracion' . "\0" . 'action', '' . "\0" . 'AppBundle\\Entity\\Menuconfiguracion' . "\0" . 'orden', '' . "\0" . 'AppBundle\\Entity\\Menuconfiguracion' . "\0" . 'activo', '' . "\0" . 'AppBundle\\Entity\\Menuconfiguracion' . "\0" . 'menuconfiguracionid', '' . "\0" . 'AppBundle\\Entity\\Menuconfiguracion' . "\0" . 'menuconfiguracionparentid'];
    }

    /**
     * 
     */
    public function __wakeup()
    {
        if ( ! $this->__isInitialized__) {
            $this->__initializer__ = function (Menuconfiguracion $proxy) {
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
    public function setSistema($sistema)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setSistema', [$sistema]);

        return parent::setSistema($sistema);
    }

    /**
     * {@inheritDoc}
     */
    public function getSistema()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getSistema', []);

        return parent::getSistema();
    }

    /**
     * {@inheritDoc}
     */
    public function setTitle($title)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setTitle', [$title]);

        return parent::setTitle($title);
    }

    /**
     * {@inheritDoc}
     */
    public function getTitle()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getTitle', []);

        return parent::getTitle();
    }

    /**
     * {@inheritDoc}
     */
    public function setKey($key)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setKey', [$key]);

        return parent::setKey($key);
    }

    /**
     * {@inheritDoc}
     */
    public function getKey()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getKey', []);

        return parent::getKey();
    }

    /**
     * {@inheritDoc}
     */
    public function setIcon($icon)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setIcon', [$icon]);

        return parent::setIcon($icon);
    }

    /**
     * {@inheritDoc}
     */
    public function getIcon()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getIcon', []);

        return parent::getIcon();
    }

    /**
     * {@inheritDoc}
     */
    public function setColor($color)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setColor', [$color]);

        return parent::setColor($color);
    }

    /**
     * {@inheritDoc}
     */
    public function getColor()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getColor', []);

        return parent::getColor();
    }

    /**
     * {@inheritDoc}
     */
    public function setAction($action)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setAction', [$action]);

        return parent::setAction($action);
    }

    /**
     * {@inheritDoc}
     */
    public function getAction()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getAction', []);

        return parent::getAction();
    }

    /**
     * {@inheritDoc}
     */
    public function setOrden($orden)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setOrden', [$orden]);

        return parent::setOrden($orden);
    }

    /**
     * {@inheritDoc}
     */
    public function getOrden()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getOrden', []);

        return parent::getOrden();
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
    public function getMenuconfiguracionid()
    {
        if ($this->__isInitialized__ === false) {
            return (int)  parent::getMenuconfiguracionid();
        }


        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getMenuconfiguracionid', []);

        return parent::getMenuconfiguracionid();
    }

    /**
     * {@inheritDoc}
     */
    public function setMenuconfiguracionparentid(\AppBundle\Entity\Menuconfiguracion $menuconfiguracionparentid = NULL)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setMenuconfiguracionparentid', [$menuconfiguracionparentid]);

        return parent::setMenuconfiguracionparentid($menuconfiguracionparentid);
    }

    /**
     * {@inheritDoc}
     */
    public function getMenuconfiguracionparentid()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getMenuconfiguracionparentid', []);

        return parent::getMenuconfiguracionparentid();
    }

}
