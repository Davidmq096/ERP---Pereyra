<?php

namespace AppBundle\Entity;

/**
 * MaInforme
 */
class MaInforme
{
    /**
     * @var \DateTime
     */
    private $fecha;

    /**
     * @var integer
     */
    private $animo;

    /**
     * @var integer
     */
    private $panal;

    /**
     * @var integer
     */
    private $panal1;

    /**
     * @var integer
     */
    private $panal2;

    /**
     * @var integer
     */
    private $panaltipo;

    /**
     * @var integer
     */
    private $bano;

    /**
     * @var integer
     */
    private $bano1;

    /**
     * @var integer
     */
    private $bano2;

    /**
     * @var integer
     */
    private $banotipo;

    /**
     * @var integer
     */
    private $accidente;

    /**
     * @var integer
     */
    private $accidenteaviso;

    /**
     * @var integer
     */
    private $comida;

    /**
     * @var string
     */
    private $comidaobservaciones;

    /**
     * @var integer
     */
    private $sueno;

    /**
     * @var integer
     */
    private $suenohoras;

    /**
     * @var string
     */
    private $observaciones;

    /**
     * @var integer
     */
    private $estatus = '0';

    /**
     * @var boolean
     */
    private $visto;

    /**
     * @var \DateTime
     */
    private $fechavisto;

    /**
     * @var integer
     */
    private $informeid;

    /**
     * @var \AppBundle\Entity\CeAlumno
     */
    private $alumnoid;


    /**
     * Set fecha
     *
     * @param \DateTime $fecha
     *
     * @return MaInforme
     */
    public function setFecha($fecha)
    {
        $this->fecha = $fecha;

        return $this;
    }

    /**
     * Get fecha
     *
     * @return \DateTime
     */
    public function getFecha()
    {
        return $this->fecha;
    }

    /**
     * Set animo
     *
     * @param integer $animo
     *
     * @return MaInforme
     */
    public function setAnimo($animo)
    {
        $this->animo = $animo;

        return $this;
    }

    /**
     * Get animo
     *
     * @return integer
     */
    public function getAnimo()
    {
        return $this->animo;
    }

    /**
     * Set panal
     *
     * @param integer $panal
     *
     * @return MaInforme
     */
    public function setPanal($panal)
    {
        $this->panal = $panal;

        return $this;
    }

    /**
     * Get panal
     *
     * @return integer
     */
    public function getPanal()
    {
        return $this->panal;
    }

    /**
     * Set panal1
     *
     * @param integer $panal1
     *
     * @return MaInforme
     */
    public function setPanal1($panal1)
    {
        $this->panal1 = $panal1;

        return $this;
    }

    /**
     * Get panal1
     *
     * @return integer
     */
    public function getPanal1()
    {
        return $this->panal1;
    }

    /**
     * Set panal2
     *
     * @param integer $panal2
     *
     * @return MaInforme
     */
    public function setPanal2($panal2)
    {
        $this->panal2 = $panal2;

        return $this;
    }

    /**
     * Get panal2
     *
     * @return integer
     */
    public function getPanal2()
    {
        return $this->panal2;
    }

    /**
     * Set panaltipo
     *
     * @param integer $panaltipo
     *
     * @return MaInforme
     */
    public function setPanaltipo($panaltipo)
    {
        $this->panaltipo = $panaltipo;

        return $this;
    }

    /**
     * Get panaltipo
     *
     * @return integer
     */
    public function getPanaltipo()
    {
        return $this->panaltipo;
    }

    /**
     * Set bano
     *
     * @param integer $bano
     *
     * @return MaInforme
     */
    public function setBano($bano)
    {
        $this->bano = $bano;

        return $this;
    }

    /**
     * Get bano
     *
     * @return integer
     */
    public function getBano()
    {
        return $this->bano;
    }

    /**
     * Set bano1
     *
     * @param integer $bano1
     *
     * @return MaInforme
     */
    public function setBano1($bano1)
    {
        $this->bano1 = $bano1;

        return $this;
    }

    /**
     * Get bano1
     *
     * @return integer
     */
    public function getBano1()
    {
        return $this->bano1;
    }

    /**
     * Set bano2
     *
     * @param integer $bano2
     *
     * @return MaInforme
     */
    public function setBano2($bano2)
    {
        $this->bano2 = $bano2;

        return $this;
    }

    /**
     * Get bano2
     *
     * @return integer
     */
    public function getBano2()
    {
        return $this->bano2;
    }

    /**
     * Set banotipo
     *
     * @param integer $banotipo
     *
     * @return MaInforme
     */
    public function setBanotipo($banotipo)
    {
        $this->banotipo = $banotipo;

        return $this;
    }

    /**
     * Get banotipo
     *
     * @return integer
     */
    public function getBanotipo()
    {
        return $this->banotipo;
    }

    /**
     * Set accidente
     *
     * @param integer $accidente
     *
     * @return MaInforme
     */
    public function setAccidente($accidente)
    {
        $this->accidente = $accidente;

        return $this;
    }

    /**
     * Get accidente
     *
     * @return integer
     */
    public function getAccidente()
    {
        return $this->accidente;
    }

    /**
     * Set accidenteaviso
     *
     * @param integer $accidenteaviso
     *
     * @return MaInforme
     */
    public function setAccidenteaviso($accidenteaviso)
    {
        $this->accidenteaviso = $accidenteaviso;

        return $this;
    }

    /**
     * Get accidenteaviso
     *
     * @return integer
     */
    public function getAccidenteaviso()
    {
        return $this->accidenteaviso;
    }

    /**
     * Set comida
     *
     * @param integer $comida
     *
     * @return MaInforme
     */
    public function setComida($comida)
    {
        $this->comida = $comida;

        return $this;
    }

    /**
     * Get comida
     *
     * @return integer
     */
    public function getComida()
    {
        return $this->comida;
    }

    /**
     * Set comidaobservaciones
     *
     * @param string $comidaobservaciones
     *
     * @return MaInforme
     */
    public function setComidaobservaciones($comidaobservaciones)
    {
        $this->comidaobservaciones = $comidaobservaciones;

        return $this;
    }

    /**
     * Get comidaobservaciones
     *
     * @return string
     */
    public function getComidaobservaciones()
    {
        return $this->comidaobservaciones;
    }

    /**
     * Set sueno
     *
     * @param integer $sueno
     *
     * @return MaInforme
     */
    public function setSueno($sueno)
    {
        $this->sueno = $sueno;

        return $this;
    }

    /**
     * Get sueno
     *
     * @return integer
     */
    public function getSueno()
    {
        return $this->sueno;
    }

    /**
     * Set suenohoras
     *
     * @param integer $suenohoras
     *
     * @return MaInforme
     */
    public function setSuenohoras($suenohoras)
    {
        $this->suenohoras = $suenohoras;

        return $this;
    }

    /**
     * Get suenohoras
     *
     * @return integer
     */
    public function getSuenohoras()
    {
        return $this->suenohoras;
    }

    /**
     * Set observaciones
     *
     * @param string $observaciones
     *
     * @return MaInforme
     */
    public function setObservaciones($observaciones)
    {
        $this->observaciones = $observaciones;

        return $this;
    }

    /**
     * Get observaciones
     *
     * @return string
     */
    public function getObservaciones()
    {
        return $this->observaciones;
    }

    /**
     * Set estatus
     *
     * @param integer $estatus
     *
     * @return MaInforme
     */
    public function setEstatus($estatus)
    {
        $this->estatus = $estatus;

        return $this;
    }

    /**
     * Get estatus
     *
     * @return integer
     */
    public function getEstatus()
    {
        return $this->estatus;
    }

    /**
     * Set visto
     *
     * @param boolean $visto
     *
     * @return MaInforme
     */
    public function setVisto($visto)
    {
        $this->visto = $visto;

        return $this;
    }

    /**
     * Get visto
     *
     * @return boolean
     */
    public function getVisto()
    {
        return $this->visto;
    }

    /**
     * Set fechavisto
     *
     * @param \DateTime $fechavisto
     *
     * @return MaInforme
     */
    public function setFechavisto($fechavisto)
    {
        $this->fechavisto = $fechavisto;

        return $this;
    }

    /**
     * Get fechavisto
     *
     * @return \DateTime
     */
    public function getFechavisto()
    {
        return $this->fechavisto;
    }

    /**
     * Get informeid
     *
     * @return integer
     */
    public function getInformeid()
    {
        return $this->informeid;
    }

    /**
     * Set alumnoid
     *
     * @param \AppBundle\Entity\CeAlumno $alumnoid
     *
     * @return MaInforme
     */
    public function setAlumnoid(\AppBundle\Entity\CeAlumno $alumnoid = null)
    {
        $this->alumnoid = $alumnoid;

        return $this;
    }

    /**
     * Get alumnoid
     *
     * @return \AppBundle\Entity\CeAlumno
     */
    public function getAlumnoid()
    {
        return $this->alumnoid;
    }
}

