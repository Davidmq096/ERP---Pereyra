<?php

namespace AppBundle\Entity;

/**
 * CjSubconcepto
 */
class CjSubconcepto
{
    /**
     * @var string
     */
    private $clave;

    /**
     * @var string
     */
    private $alias;

    /**
     * @var string
     */
    private $nombre;

    /**
     * @var integer
     */
    private $codigosatid;

    /**
     * @var boolean
     */
    private $solocaja;

    /**
     * @var boolean
     */
    private $permiteeditarimporte;

    /**
     * @var boolean
     */
    private $generainteres;

    /**
     * @var string
     */
    private $interesprimermes;

    /**
     * @var string
     */
    private $interessiguientemes;

    /**
     * @var \DateTime
     */
    private $iniciocobro;

    /**
     * @var \DateTime
     */
    private $fincobro;

    /**
     * @var \DateTime
     */
    private $fincobrootrosmedios;

    /**
     * @var boolean
     */
    private $requiereasignacion;

    /**
     * @var \DateTime
     */
    private $inicioasignacion;

    /**
     * @var \DateTime
     */
    private $finasignacion;

    /**
     * @var boolean
     */
    private $activo;

    /**
     * @var boolean
     */
    private $espagomensual;

    /**
     * @var string
     */
    private $importe = '0.00';

    /**
     * @var boolean
     */
    private $editartexto = '0';

    /**
     * @var boolean
     */
    private $domiciliacionycargo;

    /**
     * @var boolean
     */
    private $unsolocargo;

    /**
     * @var boolean
     */
    private $capturarcantidad;

    /**
     * @var boolean
     */
    private $facturable;

    /**
     * @var boolean
     */
    private $pagodiversoparcialidades = '0';

    /**
     * @var integer
     */
    private $subconceptoid;

    /**
     * @var \AppBundle\Entity\CjSubconcepto
     */
    private $subconceptoantecesorid;

    /**
     * @var \AppBundle\Entity\Ciclo
     */
    private $cicloid;

    /**
     * @var \AppBundle\Entity\CjConcepto
     */
    private $conceptoid;

    /**
     * @var \AppBundle\Entity\Departamento
     */
    private $departamentoid;


    /**
     * Set clave
     *
     * @param string $clave
     *
     * @return CjSubconcepto
     */
    public function setClave($clave)
    {
        $this->clave = $clave;

        return $this;
    }

    /**
     * Get clave
     *
     * @return string
     */
    public function getClave()
    {
        return $this->clave;
    }

    /**
     * Set alias
     *
     * @param string $alias
     *
     * @return CjSubconcepto
     */
    public function setAlias($alias)
    {
        $this->alias = $alias;

        return $this;
    }

    /**
     * Get alias
     *
     * @return string
     */
    public function getAlias()
    {
        return $this->alias;
    }

    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return CjSubconcepto
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * Get nombre
     *
     * @return string
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Set codigosatid
     *
     * @param integer $codigosatid
     *
     * @return CjSubconcepto
     */
    public function setCodigosatid($codigosatid)
    {
        $this->codigosatid = $codigosatid;

        return $this;
    }

    /**
     * Get codigosatid
     *
     * @return integer
     */
    public function getCodigosatid()
    {
        return $this->codigosatid;
    }

    /**
     * Set solocaja
     *
     * @param boolean $solocaja
     *
     * @return CjSubconcepto
     */
    public function setSolocaja($solocaja)
    {
        $this->solocaja = $solocaja;

        return $this;
    }

    /**
     * Get solocaja
     *
     * @return boolean
     */
    public function getSolocaja()
    {
        return $this->solocaja;
    }

    /**
     * Set permiteeditarimporte
     *
     * @param boolean $permiteeditarimporte
     *
     * @return CjSubconcepto
     */
    public function setPermiteeditarimporte($permiteeditarimporte)
    {
        $this->permiteeditarimporte = $permiteeditarimporte;

        return $this;
    }

    /**
     * Get permiteeditarimporte
     *
     * @return boolean
     */
    public function getPermiteeditarimporte()
    {
        return $this->permiteeditarimporte;
    }

    /**
     * Set generainteres
     *
     * @param boolean $generainteres
     *
     * @return CjSubconcepto
     */
    public function setGenerainteres($generainteres)
    {
        $this->generainteres = $generainteres;

        return $this;
    }

    /**
     * Get generainteres
     *
     * @return boolean
     */
    public function getGenerainteres()
    {
        return $this->generainteres;
    }

    /**
     * Set interesprimermes
     *
     * @param string $interesprimermes
     *
     * @return CjSubconcepto
     */
    public function setInteresprimermes($interesprimermes)
    {
        $this->interesprimermes = $interesprimermes;

        return $this;
    }

    /**
     * Get interesprimermes
     *
     * @return string
     */
    public function getInteresprimermes()
    {
        return $this->interesprimermes;
    }

    /**
     * Set interessiguientemes
     *
     * @param string $interessiguientemes
     *
     * @return CjSubconcepto
     */
    public function setInteressiguientemes($interessiguientemes)
    {
        $this->interessiguientemes = $interessiguientemes;

        return $this;
    }

    /**
     * Get interessiguientemes
     *
     * @return string
     */
    public function getInteressiguientemes()
    {
        return $this->interessiguientemes;
    }

    /**
     * Set iniciocobro
     *
     * @param \DateTime $iniciocobro
     *
     * @return CjSubconcepto
     */
    public function setIniciocobro($iniciocobro)
    {
        $this->iniciocobro = $iniciocobro;

        return $this;
    }

    /**
     * Get iniciocobro
     *
     * @return \DateTime
     */
    public function getIniciocobro()
    {
        return $this->iniciocobro;
    }

    /**
     * Set fincobro
     *
     * @param \DateTime $fincobro
     *
     * @return CjSubconcepto
     */
    public function setFincobro($fincobro)
    {
        $this->fincobro = $fincobro;

        return $this;
    }

    /**
     * Get fincobro
     *
     * @return \DateTime
     */
    public function getFincobro()
    {
        return $this->fincobro;
    }

    /**
     * Set fincobrootrosmedios
     *
     * @param \DateTime $fincobrootrosmedios
     *
     * @return CjSubconcepto
     */
    public function setFincobrootrosmedios($fincobrootrosmedios)
    {
        $this->fincobrootrosmedios = $fincobrootrosmedios;

        return $this;
    }

    /**
     * Get fincobrootrosmedios
     *
     * @return \DateTime
     */
    public function getFincobrootrosmedios()
    {
        return $this->fincobrootrosmedios;
    }

    /**
     * Set requiereasignacion
     *
     * @param boolean $requiereasignacion
     *
     * @return CjSubconcepto
     */
    public function setRequiereasignacion($requiereasignacion)
    {
        $this->requiereasignacion = $requiereasignacion;

        return $this;
    }

    /**
     * Get requiereasignacion
     *
     * @return boolean
     */
    public function getRequiereasignacion()
    {
        return $this->requiereasignacion;
    }

    /**
     * Set inicioasignacion
     *
     * @param \DateTime $inicioasignacion
     *
     * @return CjSubconcepto
     */
    public function setInicioasignacion($inicioasignacion)
    {
        $this->inicioasignacion = $inicioasignacion;

        return $this;
    }

    /**
     * Get inicioasignacion
     *
     * @return \DateTime
     */
    public function getInicioasignacion()
    {
        return $this->inicioasignacion;
    }

    /**
     * Set finasignacion
     *
     * @param \DateTime $finasignacion
     *
     * @return CjSubconcepto
     */
    public function setFinasignacion($finasignacion)
    {
        $this->finasignacion = $finasignacion;

        return $this;
    }

    /**
     * Get finasignacion
     *
     * @return \DateTime
     */
    public function getFinasignacion()
    {
        return $this->finasignacion;
    }

    /**
     * Set activo
     *
     * @param boolean $activo
     *
     * @return CjSubconcepto
     */
    public function setActivo($activo)
    {
        $this->activo = $activo;

        return $this;
    }

    /**
     * Get activo
     *
     * @return boolean
     */
    public function getActivo()
    {
        return $this->activo;
    }

    /**
     * Set espagomensual
     *
     * @param boolean $espagomensual
     *
     * @return CjSubconcepto
     */
    public function setEspagomensual($espagomensual)
    {
        $this->espagomensual = $espagomensual;

        return $this;
    }

    /**
     * Get espagomensual
     *
     * @return boolean
     */
    public function getEspagomensual()
    {
        return $this->espagomensual;
    }

    /**
     * Set importe
     *
     * @param string $importe
     *
     * @return CjSubconcepto
     */
    public function setImporte($importe)
    {
        $this->importe = $importe;

        return $this;
    }

    /**
     * Get importe
     *
     * @return string
     */
    public function getImporte()
    {
        return $this->importe;
    }

    /**
     * Set editartexto
     *
     * @param boolean $editartexto
     *
     * @return CjSubconcepto
     */
    public function setEditartexto($editartexto)
    {
        $this->editartexto = $editartexto;

        return $this;
    }

    /**
     * Get editartexto
     *
     * @return boolean
     */
    public function getEditartexto()
    {
        return $this->editartexto;
    }

    /**
     * Set domiciliacionycargo
     *
     * @param boolean $domiciliacionycargo
     *
     * @return CjSubconcepto
     */
    public function setDomiciliacionycargo($domiciliacionycargo)
    {
        $this->domiciliacionycargo = $domiciliacionycargo;

        return $this;
    }

    /**
     * Get domiciliacionycargo
     *
     * @return boolean
     */
    public function getDomiciliacionycargo()
    {
        return $this->domiciliacionycargo;
    }

    /**
     * Set unsolocargo
     *
     * @param boolean $unsolocargo
     *
     * @return CjSubconcepto
     */
    public function setUnsolocargo($unsolocargo)
    {
        $this->unsolocargo = $unsolocargo;

        return $this;
    }

    /**
     * Get unsolocargo
     *
     * @return boolean
     */
    public function getUnsolocargo()
    {
        return $this->unsolocargo;
    }

    /**
     * Set capturarcantidad
     *
     * @param boolean $capturarcantidad
     *
     * @return CjSubconcepto
     */
    public function setCapturarcantidad($capturarcantidad)
    {
        $this->capturarcantidad = $capturarcantidad;

        return $this;
    }

    /**
     * Get capturarcantidad
     *
     * @return boolean
     */
    public function getCapturarcantidad()
    {
        return $this->capturarcantidad;
    }

    /**
     * Set facturable
     *
     * @param boolean $facturable
     *
     * @return CjSubconcepto
     */
    public function setFacturable($facturable)
    {
        $this->facturable = $facturable;

        return $this;
    }

    /**
     * Get facturable
     *
     * @return boolean
     */
    public function getFacturable()
    {
        return $this->facturable;
    }

    /**
     * Set pagodiversoparcialidades
     *
     * @param boolean $pagodiversoparcialidades
     *
     * @return CjSubconcepto
     */
    public function setPagodiversoparcialidades($pagodiversoparcialidades)
    {
        $this->pagodiversoparcialidades = $pagodiversoparcialidades;

        return $this;
    }

    /**
     * Get pagodiversoparcialidades
     *
     * @return boolean
     */
    public function getPagodiversoparcialidades()
    {
        return $this->pagodiversoparcialidades;
    }

    /**
     * Get subconceptoid
     *
     * @return integer
     */
    public function getSubconceptoid()
    {
        return $this->subconceptoid;
    }

    /**
     * Set subconceptoantecesorid
     *
     * @param \AppBundle\Entity\CjSubconcepto $subconceptoantecesorid
     *
     * @return CjSubconcepto
     */
    public function setSubconceptoantecesorid(\AppBundle\Entity\CjSubconcepto $subconceptoantecesorid = null)
    {
        $this->subconceptoantecesorid = $subconceptoantecesorid;

        return $this;
    }

    /**
     * Get subconceptoantecesorid
     *
     * @return \AppBundle\Entity\CjSubconcepto
     */
    public function getSubconceptoantecesorid()
    {
        return $this->subconceptoantecesorid;
    }

    /**
     * Set cicloid
     *
     * @param \AppBundle\Entity\Ciclo $cicloid
     *
     * @return CjSubconcepto
     */
    public function setCicloid(\AppBundle\Entity\Ciclo $cicloid = null)
    {
        $this->cicloid = $cicloid;

        return $this;
    }

    /**
     * Get cicloid
     *
     * @return \AppBundle\Entity\Ciclo
     */
    public function getCicloid()
    {
        return $this->cicloid;
    }

    /**
     * Set conceptoid
     *
     * @param \AppBundle\Entity\CjConcepto $conceptoid
     *
     * @return CjSubconcepto
     */
    public function setConceptoid(\AppBundle\Entity\CjConcepto $conceptoid = null)
    {
        $this->conceptoid = $conceptoid;

        return $this;
    }

    /**
     * Get conceptoid
     *
     * @return \AppBundle\Entity\CjConcepto
     */
    public function getConceptoid()
    {
        return $this->conceptoid;
    }

    /**
     * Set departamentoid
     *
     * @param \AppBundle\Entity\Departamento $departamentoid
     *
     * @return CjSubconcepto
     */
    public function setDepartamentoid(\AppBundle\Entity\Departamento $departamentoid = null)
    {
        $this->departamentoid = $departamentoid;

        return $this;
    }

    /**
     * Get departamentoid
     *
     * @return \AppBundle\Entity\Departamento
     */
    public function getDepartamentoid()
    {
        return $this->departamentoid;
    }
}

