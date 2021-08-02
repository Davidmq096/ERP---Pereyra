<?php

namespace Proxies\__CG__\AppBundle\Entity;

/**
 * DO NOT EDIT THIS FILE - IT WAS CREATED BY DOCTRINE'S PROXY GENERATOR
 */
class Datomedico extends \AppBundle\Entity\Datomedico implements \Doctrine\ORM\Proxy\Proxy
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
            return ['__isInitialized__', '' . "\0" . 'AppBundle\\Entity\\Datomedico' . "\0" . 'padece', '' . "\0" . 'AppBundle\\Entity\\Datomedico' . "\0" . 'alergico', '' . "\0" . 'AppBundle\\Entity\\Datomedico' . "\0" . 'antecedentefamiliar', '' . "\0" . 'AppBundle\\Entity\\Datomedico' . "\0" . 'autorizoantihistaminico', '' . "\0" . 'AppBundle\\Entity\\Datomedico' . "\0" . 'examenvista', '' . "\0" . 'AppBundle\\Entity\\Datomedico' . "\0" . 'lentes', '' . "\0" . 'AppBundle\\Entity\\Datomedico' . "\0" . 'examenauditivo', '' . "\0" . 'AppBundle\\Entity\\Datomedico' . "\0" . 'aparatoauditivo', '' . "\0" . 'AppBundle\\Entity\\Datomedico' . "\0" . 'examenortopedicos', '' . "\0" . 'AppBundle\\Entity\\Datomedico' . "\0" . 'aditamentosortopedico', '' . "\0" . 'AppBundle\\Entity\\Datomedico' . "\0" . 'peso', '' . "\0" . 'AppBundle\\Entity\\Datomedico' . "\0" . 'talla', '' . "\0" . 'AppBundle\\Entity\\Datomedico' . "\0" . 'enfermedadcronica', '' . "\0" . 'AppBundle\\Entity\\Datomedico' . "\0" . 'medicamentoregularidad', '' . "\0" . 'AppBundle\\Entity\\Datomedico' . "\0" . 'alergicosustancias', '' . "\0" . 'AppBundle\\Entity\\Datomedico' . "\0" . 'medicamentoadministrar', '' . "\0" . 'AppBundle\\Entity\\Datomedico' . "\0" . 'analgesicosantinflamatorios', '' . "\0" . 'AppBundle\\Entity\\Datomedico' . "\0" . 'antigripalesantihistaminicos', '' . "\0" . 'AppBundle\\Entity\\Datomedico' . "\0" . 'antiacidos', '' . "\0" . 'AppBundle\\Entity\\Datomedico' . "\0" . 'antiespasmodicos', '' . "\0" . 'AppBundle\\Entity\\Datomedico' . "\0" . 'materialcuracion', '' . "\0" . 'AppBundle\\Entity\\Datomedico' . "\0" . 'unguentos', '' . "\0" . 'AppBundle\\Entity\\Datomedico' . "\0" . 'remediosalternativos', '' . "\0" . 'AppBundle\\Entity\\Datomedico' . "\0" . 'nombreautoriza', '' . "\0" . 'AppBundle\\Entity\\Datomedico' . "\0" . 'firma', '' . "\0" . 'AppBundle\\Entity\\Datomedico' . "\0" . 'personaatiende', '' . "\0" . 'AppBundle\\Entity\\Datomedico' . "\0" . 'telefonopersonaatiende', '' . "\0" . 'AppBundle\\Entity\\Datomedico' . "\0" . 'contactoemergencianombre', '' . "\0" . 'AppBundle\\Entity\\Datomedico' . "\0" . 'contactoemergenciatelefono', '' . "\0" . 'AppBundle\\Entity\\Datomedico' . "\0" . 'contactoemergenciaemail', '' . "\0" . 'AppBundle\\Entity\\Datomedico' . "\0" . 'otraalergia', '' . "\0" . 'AppBundle\\Entity\\Datomedico' . "\0" . 'padeceenfermedadcuidanombre', '' . "\0" . 'AppBundle\\Entity\\Datomedico' . "\0" . 'padeceenfermedadcuidatelefono', '' . "\0" . 'AppBundle\\Entity\\Datomedico' . "\0" . 'padeceenfermedadcuidadescripcion', '' . "\0" . 'AppBundle\\Entity\\Datomedico' . "\0" . 'descripcionantecedenteimportante', '' . "\0" . 'AppBundle\\Entity\\Datomedico' . "\0" . 'datomedicoid', '' . "\0" . 'AppBundle\\Entity\\Datomedico' . "\0" . 'contactoemergenciaparentesco', '' . "\0" . 'AppBundle\\Entity\\Datomedico' . "\0" . 'datosaspiranteid', '' . "\0" . 'AppBundle\\Entity\\Datomedico' . "\0" . 'tiposanguinio'];
        }

        return ['__isInitialized__', '' . "\0" . 'AppBundle\\Entity\\Datomedico' . "\0" . 'padece', '' . "\0" . 'AppBundle\\Entity\\Datomedico' . "\0" . 'alergico', '' . "\0" . 'AppBundle\\Entity\\Datomedico' . "\0" . 'antecedentefamiliar', '' . "\0" . 'AppBundle\\Entity\\Datomedico' . "\0" . 'autorizoantihistaminico', '' . "\0" . 'AppBundle\\Entity\\Datomedico' . "\0" . 'examenvista', '' . "\0" . 'AppBundle\\Entity\\Datomedico' . "\0" . 'lentes', '' . "\0" . 'AppBundle\\Entity\\Datomedico' . "\0" . 'examenauditivo', '' . "\0" . 'AppBundle\\Entity\\Datomedico' . "\0" . 'aparatoauditivo', '' . "\0" . 'AppBundle\\Entity\\Datomedico' . "\0" . 'examenortopedicos', '' . "\0" . 'AppBundle\\Entity\\Datomedico' . "\0" . 'aditamentosortopedico', '' . "\0" . 'AppBundle\\Entity\\Datomedico' . "\0" . 'peso', '' . "\0" . 'AppBundle\\Entity\\Datomedico' . "\0" . 'talla', '' . "\0" . 'AppBundle\\Entity\\Datomedico' . "\0" . 'enfermedadcronica', '' . "\0" . 'AppBundle\\Entity\\Datomedico' . "\0" . 'medicamentoregularidad', '' . "\0" . 'AppBundle\\Entity\\Datomedico' . "\0" . 'alergicosustancias', '' . "\0" . 'AppBundle\\Entity\\Datomedico' . "\0" . 'medicamentoadministrar', '' . "\0" . 'AppBundle\\Entity\\Datomedico' . "\0" . 'analgesicosantinflamatorios', '' . "\0" . 'AppBundle\\Entity\\Datomedico' . "\0" . 'antigripalesantihistaminicos', '' . "\0" . 'AppBundle\\Entity\\Datomedico' . "\0" . 'antiacidos', '' . "\0" . 'AppBundle\\Entity\\Datomedico' . "\0" . 'antiespasmodicos', '' . "\0" . 'AppBundle\\Entity\\Datomedico' . "\0" . 'materialcuracion', '' . "\0" . 'AppBundle\\Entity\\Datomedico' . "\0" . 'unguentos', '' . "\0" . 'AppBundle\\Entity\\Datomedico' . "\0" . 'remediosalternativos', '' . "\0" . 'AppBundle\\Entity\\Datomedico' . "\0" . 'nombreautoriza', '' . "\0" . 'AppBundle\\Entity\\Datomedico' . "\0" . 'firma', '' . "\0" . 'AppBundle\\Entity\\Datomedico' . "\0" . 'personaatiende', '' . "\0" . 'AppBundle\\Entity\\Datomedico' . "\0" . 'telefonopersonaatiende', '' . "\0" . 'AppBundle\\Entity\\Datomedico' . "\0" . 'contactoemergencianombre', '' . "\0" . 'AppBundle\\Entity\\Datomedico' . "\0" . 'contactoemergenciatelefono', '' . "\0" . 'AppBundle\\Entity\\Datomedico' . "\0" . 'contactoemergenciaemail', '' . "\0" . 'AppBundle\\Entity\\Datomedico' . "\0" . 'otraalergia', '' . "\0" . 'AppBundle\\Entity\\Datomedico' . "\0" . 'padeceenfermedadcuidanombre', '' . "\0" . 'AppBundle\\Entity\\Datomedico' . "\0" . 'padeceenfermedadcuidatelefono', '' . "\0" . 'AppBundle\\Entity\\Datomedico' . "\0" . 'padeceenfermedadcuidadescripcion', '' . "\0" . 'AppBundle\\Entity\\Datomedico' . "\0" . 'descripcionantecedenteimportante', '' . "\0" . 'AppBundle\\Entity\\Datomedico' . "\0" . 'datomedicoid', '' . "\0" . 'AppBundle\\Entity\\Datomedico' . "\0" . 'contactoemergenciaparentesco', '' . "\0" . 'AppBundle\\Entity\\Datomedico' . "\0" . 'datosaspiranteid', '' . "\0" . 'AppBundle\\Entity\\Datomedico' . "\0" . 'tiposanguinio'];
    }

    /**
     * 
     */
    public function __wakeup()
    {
        if ( ! $this->__isInitialized__) {
            $this->__initializer__ = function (Datomedico $proxy) {
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
    public function setPadece($padece)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setPadece', [$padece]);

        return parent::setPadece($padece);
    }

    /**
     * {@inheritDoc}
     */
    public function getPadece()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getPadece', []);

        return parent::getPadece();
    }

    /**
     * {@inheritDoc}
     */
    public function setAlergico($alergico)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setAlergico', [$alergico]);

        return parent::setAlergico($alergico);
    }

    /**
     * {@inheritDoc}
     */
    public function getAlergico()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getAlergico', []);

        return parent::getAlergico();
    }

    /**
     * {@inheritDoc}
     */
    public function setAntecedentefamiliar($antecedentefamiliar)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setAntecedentefamiliar', [$antecedentefamiliar]);

        return parent::setAntecedentefamiliar($antecedentefamiliar);
    }

    /**
     * {@inheritDoc}
     */
    public function getAntecedentefamiliar()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getAntecedentefamiliar', []);

        return parent::getAntecedentefamiliar();
    }

    /**
     * {@inheritDoc}
     */
    public function setAutorizoantihistaminico($autorizoantihistaminico)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setAutorizoantihistaminico', [$autorizoantihistaminico]);

        return parent::setAutorizoantihistaminico($autorizoantihistaminico);
    }

    /**
     * {@inheritDoc}
     */
    public function getAutorizoantihistaminico()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getAutorizoantihistaminico', []);

        return parent::getAutorizoantihistaminico();
    }

    /**
     * {@inheritDoc}
     */
    public function setExamenvista($examenvista)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setExamenvista', [$examenvista]);

        return parent::setExamenvista($examenvista);
    }

    /**
     * {@inheritDoc}
     */
    public function getExamenvista()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getExamenvista', []);

        return parent::getExamenvista();
    }

    /**
     * {@inheritDoc}
     */
    public function setLentes($lentes)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setLentes', [$lentes]);

        return parent::setLentes($lentes);
    }

    /**
     * {@inheritDoc}
     */
    public function getLentes()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getLentes', []);

        return parent::getLentes();
    }

    /**
     * {@inheritDoc}
     */
    public function setExamenauditivo($examenauditivo)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setExamenauditivo', [$examenauditivo]);

        return parent::setExamenauditivo($examenauditivo);
    }

    /**
     * {@inheritDoc}
     */
    public function getExamenauditivo()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getExamenauditivo', []);

        return parent::getExamenauditivo();
    }

    /**
     * {@inheritDoc}
     */
    public function setAparatoauditivo($aparatoauditivo)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setAparatoauditivo', [$aparatoauditivo]);

        return parent::setAparatoauditivo($aparatoauditivo);
    }

    /**
     * {@inheritDoc}
     */
    public function getAparatoauditivo()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getAparatoauditivo', []);

        return parent::getAparatoauditivo();
    }

    /**
     * {@inheritDoc}
     */
    public function setExamenortopedicos($examenortopedicos)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setExamenortopedicos', [$examenortopedicos]);

        return parent::setExamenortopedicos($examenortopedicos);
    }

    /**
     * {@inheritDoc}
     */
    public function getExamenortopedicos()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getExamenortopedicos', []);

        return parent::getExamenortopedicos();
    }

    /**
     * {@inheritDoc}
     */
    public function setAditamentosortopedico($aditamentosortopedico)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setAditamentosortopedico', [$aditamentosortopedico]);

        return parent::setAditamentosortopedico($aditamentosortopedico);
    }

    /**
     * {@inheritDoc}
     */
    public function getAditamentosortopedico()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getAditamentosortopedico', []);

        return parent::getAditamentosortopedico();
    }

    /**
     * {@inheritDoc}
     */
    public function setPeso($peso)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setPeso', [$peso]);

        return parent::setPeso($peso);
    }

    /**
     * {@inheritDoc}
     */
    public function getPeso()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getPeso', []);

        return parent::getPeso();
    }

    /**
     * {@inheritDoc}
     */
    public function setTalla($talla)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setTalla', [$talla]);

        return parent::setTalla($talla);
    }

    /**
     * {@inheritDoc}
     */
    public function getTalla()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getTalla', []);

        return parent::getTalla();
    }

    /**
     * {@inheritDoc}
     */
    public function setEnfermedadcronica($enfermedadcronica)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setEnfermedadcronica', [$enfermedadcronica]);

        return parent::setEnfermedadcronica($enfermedadcronica);
    }

    /**
     * {@inheritDoc}
     */
    public function getEnfermedadcronica()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getEnfermedadcronica', []);

        return parent::getEnfermedadcronica();
    }

    /**
     * {@inheritDoc}
     */
    public function setMedicamentoregularidad($medicamentoregularidad)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setMedicamentoregularidad', [$medicamentoregularidad]);

        return parent::setMedicamentoregularidad($medicamentoregularidad);
    }

    /**
     * {@inheritDoc}
     */
    public function getMedicamentoregularidad()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getMedicamentoregularidad', []);

        return parent::getMedicamentoregularidad();
    }

    /**
     * {@inheritDoc}
     */
    public function setAlergicosustancias($alergicosustancias)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setAlergicosustancias', [$alergicosustancias]);

        return parent::setAlergicosustancias($alergicosustancias);
    }

    /**
     * {@inheritDoc}
     */
    public function getAlergicosustancias()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getAlergicosustancias', []);

        return parent::getAlergicosustancias();
    }

    /**
     * {@inheritDoc}
     */
    public function setMedicamentoadministrar($medicamentoadministrar)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setMedicamentoadministrar', [$medicamentoadministrar]);

        return parent::setMedicamentoadministrar($medicamentoadministrar);
    }

    /**
     * {@inheritDoc}
     */
    public function getMedicamentoadministrar()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getMedicamentoadministrar', []);

        return parent::getMedicamentoadministrar();
    }

    /**
     * {@inheritDoc}
     */
    public function setAnalgesicosantinflamatorios($analgesicosantinflamatorios)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setAnalgesicosantinflamatorios', [$analgesicosantinflamatorios]);

        return parent::setAnalgesicosantinflamatorios($analgesicosantinflamatorios);
    }

    /**
     * {@inheritDoc}
     */
    public function getAnalgesicosantinflamatorios()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getAnalgesicosantinflamatorios', []);

        return parent::getAnalgesicosantinflamatorios();
    }

    /**
     * {@inheritDoc}
     */
    public function setAntigripalesantihistaminicos($antigripalesantihistaminicos)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setAntigripalesantihistaminicos', [$antigripalesantihistaminicos]);

        return parent::setAntigripalesantihistaminicos($antigripalesantihistaminicos);
    }

    /**
     * {@inheritDoc}
     */
    public function getAntigripalesantihistaminicos()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getAntigripalesantihistaminicos', []);

        return parent::getAntigripalesantihistaminicos();
    }

    /**
     * {@inheritDoc}
     */
    public function setAntiacidos($antiacidos)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setAntiacidos', [$antiacidos]);

        return parent::setAntiacidos($antiacidos);
    }

    /**
     * {@inheritDoc}
     */
    public function getAntiacidos()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getAntiacidos', []);

        return parent::getAntiacidos();
    }

    /**
     * {@inheritDoc}
     */
    public function setAntiespasmodicos($antiespasmodicos)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setAntiespasmodicos', [$antiespasmodicos]);

        return parent::setAntiespasmodicos($antiespasmodicos);
    }

    /**
     * {@inheritDoc}
     */
    public function getAntiespasmodicos()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getAntiespasmodicos', []);

        return parent::getAntiespasmodicos();
    }

    /**
     * {@inheritDoc}
     */
    public function setMaterialcuracion($materialcuracion)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setMaterialcuracion', [$materialcuracion]);

        return parent::setMaterialcuracion($materialcuracion);
    }

    /**
     * {@inheritDoc}
     */
    public function getMaterialcuracion()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getMaterialcuracion', []);

        return parent::getMaterialcuracion();
    }

    /**
     * {@inheritDoc}
     */
    public function setUnguentos($unguentos)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setUnguentos', [$unguentos]);

        return parent::setUnguentos($unguentos);
    }

    /**
     * {@inheritDoc}
     */
    public function getUnguentos()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getUnguentos', []);

        return parent::getUnguentos();
    }

    /**
     * {@inheritDoc}
     */
    public function setRemediosalternativos($remediosalternativos)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setRemediosalternativos', [$remediosalternativos]);

        return parent::setRemediosalternativos($remediosalternativos);
    }

    /**
     * {@inheritDoc}
     */
    public function getRemediosalternativos()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getRemediosalternativos', []);

        return parent::getRemediosalternativos();
    }

    /**
     * {@inheritDoc}
     */
    public function setNombreautoriza($nombreautoriza)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setNombreautoriza', [$nombreautoriza]);

        return parent::setNombreautoriza($nombreautoriza);
    }

    /**
     * {@inheritDoc}
     */
    public function getNombreautoriza()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getNombreautoriza', []);

        return parent::getNombreautoriza();
    }

    /**
     * {@inheritDoc}
     */
    public function setFirma($firma)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setFirma', [$firma]);

        return parent::setFirma($firma);
    }

    /**
     * {@inheritDoc}
     */
    public function getFirma()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getFirma', []);

        return parent::getFirma();
    }

    /**
     * {@inheritDoc}
     */
    public function setPersonaatiende($personaatiende)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setPersonaatiende', [$personaatiende]);

        return parent::setPersonaatiende($personaatiende);
    }

    /**
     * {@inheritDoc}
     */
    public function getPersonaatiende()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getPersonaatiende', []);

        return parent::getPersonaatiende();
    }

    /**
     * {@inheritDoc}
     */
    public function setTelefonopersonaatiende($telefonopersonaatiende)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setTelefonopersonaatiende', [$telefonopersonaatiende]);

        return parent::setTelefonopersonaatiende($telefonopersonaatiende);
    }

    /**
     * {@inheritDoc}
     */
    public function getTelefonopersonaatiende()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getTelefonopersonaatiende', []);

        return parent::getTelefonopersonaatiende();
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
    public function setOtraalergia($otraalergia)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setOtraalergia', [$otraalergia]);

        return parent::setOtraalergia($otraalergia);
    }

    /**
     * {@inheritDoc}
     */
    public function getOtraalergia()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getOtraalergia', []);

        return parent::getOtraalergia();
    }

    /**
     * {@inheritDoc}
     */
    public function setPadeceenfermedadcuidanombre($padeceenfermedadcuidanombre)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setPadeceenfermedadcuidanombre', [$padeceenfermedadcuidanombre]);

        return parent::setPadeceenfermedadcuidanombre($padeceenfermedadcuidanombre);
    }

    /**
     * {@inheritDoc}
     */
    public function getPadeceenfermedadcuidanombre()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getPadeceenfermedadcuidanombre', []);

        return parent::getPadeceenfermedadcuidanombre();
    }

    /**
     * {@inheritDoc}
     */
    public function setPadeceenfermedadcuidatelefono($padeceenfermedadcuidatelefono)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setPadeceenfermedadcuidatelefono', [$padeceenfermedadcuidatelefono]);

        return parent::setPadeceenfermedadcuidatelefono($padeceenfermedadcuidatelefono);
    }

    /**
     * {@inheritDoc}
     */
    public function getPadeceenfermedadcuidatelefono()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getPadeceenfermedadcuidatelefono', []);

        return parent::getPadeceenfermedadcuidatelefono();
    }

    /**
     * {@inheritDoc}
     */
    public function setPadeceenfermedadcuidadescripcion($padeceenfermedadcuidadescripcion)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setPadeceenfermedadcuidadescripcion', [$padeceenfermedadcuidadescripcion]);

        return parent::setPadeceenfermedadcuidadescripcion($padeceenfermedadcuidadescripcion);
    }

    /**
     * {@inheritDoc}
     */
    public function getPadeceenfermedadcuidadescripcion()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getPadeceenfermedadcuidadescripcion', []);

        return parent::getPadeceenfermedadcuidadescripcion();
    }

    /**
     * {@inheritDoc}
     */
    public function setDescripcionantecedenteimportante($descripcionantecedenteimportante)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setDescripcionantecedenteimportante', [$descripcionantecedenteimportante]);

        return parent::setDescripcionantecedenteimportante($descripcionantecedenteimportante);
    }

    /**
     * {@inheritDoc}
     */
    public function getDescripcionantecedenteimportante()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getDescripcionantecedenteimportante', []);

        return parent::getDescripcionantecedenteimportante();
    }

    /**
     * {@inheritDoc}
     */
    public function getDatomedicoid()
    {
        if ($this->__isInitialized__ === false) {
            return (int)  parent::getDatomedicoid();
        }


        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getDatomedicoid', []);

        return parent::getDatomedicoid();
    }

    /**
     * {@inheritDoc}
     */
    public function setContactoemergenciaparentesco(\AppBundle\Entity\Parentesco $contactoemergenciaparentesco = NULL)
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
    public function setDatosaspiranteid(\AppBundle\Entity\Datoaspirante $datosaspiranteid = NULL)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setDatosaspiranteid', [$datosaspiranteid]);

        return parent::setDatosaspiranteid($datosaspiranteid);
    }

    /**
     * {@inheritDoc}
     */
    public function getDatosaspiranteid()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getDatosaspiranteid', []);

        return parent::getDatosaspiranteid();
    }

    /**
     * {@inheritDoc}
     */
    public function setTiposanguinio(\AppBundle\Entity\Tiposanguineo $tiposanguinio = NULL)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setTiposanguinio', [$tiposanguinio]);

        return parent::setTiposanguinio($tiposanguinio);
    }

    /**
     * {@inheritDoc}
     */
    public function getTiposanguinio()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getTiposanguinio', []);

        return parent::getTiposanguinio();
    }

}
