<?php

namespace Proxies\__CG__\AppBundle\Entity;

/**
 * DO NOT EDIT THIS FILE - IT WAS CREATED BY DOCTRINE'S PROXY GENERATOR
 */
class CmNotificacion extends \AppBundle\Entity\CmNotificacion implements \Doctrine\ORM\Proxy\Proxy
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
            return ['__isInitialized__', '' . "\0" . 'AppBundle\\Entity\\CmNotificacion' . "\0" . 'enviarpadres', '' . "\0" . 'AppBundle\\Entity\\CmNotificacion' . "\0" . 'enviaralumnos', '' . "\0" . 'AppBundle\\Entity\\CmNotificacion' . "\0" . 'fecha', '' . "\0" . 'AppBundle\\Entity\\CmNotificacion' . "\0" . 'hora', '' . "\0" . 'AppBundle\\Entity\\CmNotificacion' . "\0" . 'titulo', '' . "\0" . 'AppBundle\\Entity\\CmNotificacion' . "\0" . 'mensaje', '' . "\0" . 'AppBundle\\Entity\\CmNotificacion' . "\0" . 'vinculo', '' . "\0" . 'AppBundle\\Entity\\CmNotificacion' . "\0" . 'formato', '' . "\0" . 'AppBundle\\Entity\\CmNotificacion' . "\0" . 'estatus', '' . "\0" . 'AppBundle\\Entity\\CmNotificacion' . "\0" . 'tipoimagen', '' . "\0" . 'AppBundle\\Entity\\CmNotificacion' . "\0" . 'fechamodificacion', '' . "\0" . 'AppBundle\\Entity\\CmNotificacion' . "\0" . 'notificacionid', '' . "\0" . 'AppBundle\\Entity\\CmNotificacion' . "\0" . 'usuarioid'];
        }

        return ['__isInitialized__', '' . "\0" . 'AppBundle\\Entity\\CmNotificacion' . "\0" . 'enviarpadres', '' . "\0" . 'AppBundle\\Entity\\CmNotificacion' . "\0" . 'enviaralumnos', '' . "\0" . 'AppBundle\\Entity\\CmNotificacion' . "\0" . 'fecha', '' . "\0" . 'AppBundle\\Entity\\CmNotificacion' . "\0" . 'hora', '' . "\0" . 'AppBundle\\Entity\\CmNotificacion' . "\0" . 'titulo', '' . "\0" . 'AppBundle\\Entity\\CmNotificacion' . "\0" . 'mensaje', '' . "\0" . 'AppBundle\\Entity\\CmNotificacion' . "\0" . 'vinculo', '' . "\0" . 'AppBundle\\Entity\\CmNotificacion' . "\0" . 'formato', '' . "\0" . 'AppBundle\\Entity\\CmNotificacion' . "\0" . 'estatus', '' . "\0" . 'AppBundle\\Entity\\CmNotificacion' . "\0" . 'tipoimagen', '' . "\0" . 'AppBundle\\Entity\\CmNotificacion' . "\0" . 'fechamodificacion', '' . "\0" . 'AppBundle\\Entity\\CmNotificacion' . "\0" . 'notificacionid', '' . "\0" . 'AppBundle\\Entity\\CmNotificacion' . "\0" . 'usuarioid'];
    }

    /**
     * 
     */
    public function __wakeup()
    {
        if ( ! $this->__isInitialized__) {
            $this->__initializer__ = function (CmNotificacion $proxy) {
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
    public function setEnviarpadres($enviarpadres)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setEnviarpadres', [$enviarpadres]);

        return parent::setEnviarpadres($enviarpadres);
    }

    /**
     * {@inheritDoc}
     */
    public function getEnviarpadres()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getEnviarpadres', []);

        return parent::getEnviarpadres();
    }

    /**
     * {@inheritDoc}
     */
    public function setEnviaralumnos($enviaralumnos)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setEnviaralumnos', [$enviaralumnos]);

        return parent::setEnviaralumnos($enviaralumnos);
    }

    /**
     * {@inheritDoc}
     */
    public function getEnviaralumnos()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getEnviaralumnos', []);

        return parent::getEnviaralumnos();
    }

    /**
     * {@inheritDoc}
     */
    public function setFecha($fecha)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setFecha', [$fecha]);

        return parent::setFecha($fecha);
    }

    /**
     * {@inheritDoc}
     */
    public function getFecha()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getFecha', []);

        return parent::getFecha();
    }

    /**
     * {@inheritDoc}
     */
    public function setHora($hora)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setHora', [$hora]);

        return parent::setHora($hora);
    }

    /**
     * {@inheritDoc}
     */
    public function getHora()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getHora', []);

        return parent::getHora();
    }

    /**
     * {@inheritDoc}
     */
    public function setTitulo($titulo)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setTitulo', [$titulo]);

        return parent::setTitulo($titulo);
    }

    /**
     * {@inheritDoc}
     */
    public function getTitulo()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getTitulo', []);

        return parent::getTitulo();
    }

    /**
     * {@inheritDoc}
     */
    public function setMensaje($mensaje)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setMensaje', [$mensaje]);

        return parent::setMensaje($mensaje);
    }

    /**
     * {@inheritDoc}
     */
    public function getMensaje()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getMensaje', []);

        return parent::getMensaje();
    }

    /**
     * {@inheritDoc}
     */
    public function setVinculo($vinculo)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setVinculo', [$vinculo]);

        return parent::setVinculo($vinculo);
    }

    /**
     * {@inheritDoc}
     */
    public function getVinculo()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getVinculo', []);

        return parent::getVinculo();
    }

    /**
     * {@inheritDoc}
     */
    public function setFormato($formato)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setFormato', [$formato]);

        return parent::setFormato($formato);
    }

    /**
     * {@inheritDoc}
     */
    public function getFormato()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getFormato', []);

        return parent::getFormato();
    }

    /**
     * {@inheritDoc}
     */
    public function setEstatus($estatus)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setEstatus', [$estatus]);

        return parent::setEstatus($estatus);
    }

    /**
     * {@inheritDoc}
     */
    public function getEstatus()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getEstatus', []);

        return parent::getEstatus();
    }

    /**
     * {@inheritDoc}
     */
    public function setTipoimagen($tipoimagen)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setTipoimagen', [$tipoimagen]);

        return parent::setTipoimagen($tipoimagen);
    }

    /**
     * {@inheritDoc}
     */
    public function getTipoimagen()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getTipoimagen', []);

        return parent::getTipoimagen();
    }

    /**
     * {@inheritDoc}
     */
    public function setFechamodificacion($fechamodificacion)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setFechamodificacion', [$fechamodificacion]);

        return parent::setFechamodificacion($fechamodificacion);
    }

    /**
     * {@inheritDoc}
     */
    public function getFechamodificacion()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getFechamodificacion', []);

        return parent::getFechamodificacion();
    }

    /**
     * {@inheritDoc}
     */
    public function getNotificacionid()
    {
        if ($this->__isInitialized__ === false) {
            return (int)  parent::getNotificacionid();
        }


        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getNotificacionid', []);

        return parent::getNotificacionid();
    }

    /**
     * {@inheritDoc}
     */
    public function setUsuarioid(\AppBundle\Entity\Usuario $usuarioid = NULL)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setUsuarioid', [$usuarioid]);

        return parent::setUsuarioid($usuarioid);
    }

    /**
     * {@inheritDoc}
     */
    public function getUsuarioid()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getUsuarioid', []);

        return parent::getUsuarioid();
    }

}
