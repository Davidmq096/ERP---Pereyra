<?php

namespace AppBundle\Entity;

/**
 * CeMateriaporplanestudios
 */
class CeMateriaporplanestudios
{
    /**
     * @var integer
     */
    private $ordenoficial;

    /**
     * @var integer
     */
    private $ordeninterno;

    /**
     * @var boolean
     */
    private $escurricular = '0';

    /**
     * @var boolean
     */
    private $seimprimeenboleta = '0';

    /**
     * @var boolean
     */
    private $imprimirsubmateriaymateria = '0';

    /**
     * @var boolean
     */
    private $promediointerno = '0';

    /**
     * @var boolean
     */
    private $requieremaestrotitular = '0';

    /**
     * @var boolean
     */
    private $requieremaestrocotitular = '0';

    /**
     * @var boolean
     */
    private $requierecapturadecomentarios = '0';

    /**
     * @var boolean
     */
    private $configurarsubmaterias = '0';

    /**
     * @var boolean
     */
    private $configurarsubgrupos = '0';

    /**
     * @var boolean
     */
    private $requiereconfigurarherramientas = '0';

    /**
     * @var boolean
     */
    private $requiereconfigurarapoyos = '0';

    /**
     * @var float
     */
    private $horasporsemana;

    /**
     * @var boolean
     */
    private $reportarcalificacion;

    /**
     * @var boolean
     */
    private $configurartaller = '0';

    /**
     * @var integer
     */
    private $materiaporplanestudioid;

    /**
     * @var \AppBundle\Entity\CeComponentecurricular
     */
    private $componentecurricularid;

    /**
     * @var \AppBundle\Entity\CePlanestudios
     */
    private $planestudioid;

    /**
     * @var \AppBundle\Entity\Materia
     */
    private $materiaid;

    /**
     * @var \AppBundle\Entity\CeMateriafrecuenciacaptura
     */
    private $materiafrecuenciacapturaid;

    /**
     * @var \AppBundle\Entity\Materia
     */
    private $reportarmateriaid;


    /**
     * Set ordenoficial
     *
     * @param integer $ordenoficial
     *
     * @return CeMateriaporplanestudios
     */
    public function setOrdenoficial($ordenoficial)
    {
        $this->ordenoficial = $ordenoficial;

        return $this;
    }

    /**
     * Get ordenoficial
     *
     * @return integer
     */
    public function getOrdenoficial()
    {
        return $this->ordenoficial;
    }

    /**
     * Set ordeninterno
     *
     * @param integer $ordeninterno
     *
     * @return CeMateriaporplanestudios
     */
    public function setOrdeninterno($ordeninterno)
    {
        $this->ordeninterno = $ordeninterno;

        return $this;
    }

    /**
     * Get ordeninterno
     *
     * @return integer
     */
    public function getOrdeninterno()
    {
        return $this->ordeninterno;
    }

    /**
     * Set escurricular
     *
     * @param boolean $escurricular
     *
     * @return CeMateriaporplanestudios
     */
    public function setEscurricular($escurricular)
    {
        $this->escurricular = $escurricular;

        return $this;
    }

    /**
     * Get escurricular
     *
     * @return boolean
     */
    public function getEscurricular()
    {
        return $this->escurricular;
    }

    /**
     * Set seimprimeenboleta
     *
     * @param boolean $seimprimeenboleta
     *
     * @return CeMateriaporplanestudios
     */
    public function setSeimprimeenboleta($seimprimeenboleta)
    {
        $this->seimprimeenboleta = $seimprimeenboleta;

        return $this;
    }

    /**
     * Get seimprimeenboleta
     *
     * @return boolean
     */
    public function getSeimprimeenboleta()
    {
        return $this->seimprimeenboleta;
    }

    /**
     * Set imprimirsubmateriaymateria
     *
     * @param boolean $imprimirsubmateriaymateria
     *
     * @return CeMateriaporplanestudios
     */
    public function setImprimirsubmateriaymateria($imprimirsubmateriaymateria)
    {
        $this->imprimirsubmateriaymateria = $imprimirsubmateriaymateria;

        return $this;
    }

    /**
     * Get imprimirsubmateriaymateria
     *
     * @return boolean
     */
    public function getImprimirsubmateriaymateria()
    {
        return $this->imprimirsubmateriaymateria;
    }

    /**
     * Set promediointerno
     *
     * @param boolean $promediointerno
     *
     * @return CeMateriaporplanestudios
     */
    public function setPromediointerno($promediointerno)
    {
        $this->promediointerno = $promediointerno;

        return $this;
    }

    /**
     * Get promediointerno
     *
     * @return boolean
     */
    public function getPromediointerno()
    {
        return $this->promediointerno;
    }

    /**
     * Set requieremaestrotitular
     *
     * @param boolean $requieremaestrotitular
     *
     * @return CeMateriaporplanestudios
     */
    public function setRequieremaestrotitular($requieremaestrotitular)
    {
        $this->requieremaestrotitular = $requieremaestrotitular;

        return $this;
    }

    /**
     * Get requieremaestrotitular
     *
     * @return boolean
     */
    public function getRequieremaestrotitular()
    {
        return $this->requieremaestrotitular;
    }

    /**
     * Set requieremaestrocotitular
     *
     * @param boolean $requieremaestrocotitular
     *
     * @return CeMateriaporplanestudios
     */
    public function setRequieremaestrocotitular($requieremaestrocotitular)
    {
        $this->requieremaestrocotitular = $requieremaestrocotitular;

        return $this;
    }

    /**
     * Get requieremaestrocotitular
     *
     * @return boolean
     */
    public function getRequieremaestrocotitular()
    {
        return $this->requieremaestrocotitular;
    }

    /**
     * Set requierecapturadecomentarios
     *
     * @param boolean $requierecapturadecomentarios
     *
     * @return CeMateriaporplanestudios
     */
    public function setRequierecapturadecomentarios($requierecapturadecomentarios)
    {
        $this->requierecapturadecomentarios = $requierecapturadecomentarios;

        return $this;
    }

    /**
     * Get requierecapturadecomentarios
     *
     * @return boolean
     */
    public function getRequierecapturadecomentarios()
    {
        return $this->requierecapturadecomentarios;
    }

    /**
     * Set configurarsubmaterias
     *
     * @param boolean $configurarsubmaterias
     *
     * @return CeMateriaporplanestudios
     */
    public function setConfigurarsubmaterias($configurarsubmaterias)
    {
        $this->configurarsubmaterias = $configurarsubmaterias;

        return $this;
    }

    /**
     * Get configurarsubmaterias
     *
     * @return boolean
     */
    public function getConfigurarsubmaterias()
    {
        return $this->configurarsubmaterias;
    }

    /**
     * Set configurarsubgrupos
     *
     * @param boolean $configurarsubgrupos
     *
     * @return CeMateriaporplanestudios
     */
    public function setConfigurarsubgrupos($configurarsubgrupos)
    {
        $this->configurarsubgrupos = $configurarsubgrupos;

        return $this;
    }

    /**
     * Get configurarsubgrupos
     *
     * @return boolean
     */
    public function getConfigurarsubgrupos()
    {
        return $this->configurarsubgrupos;
    }

    /**
     * Set requiereconfigurarherramientas
     *
     * @param boolean $requiereconfigurarherramientas
     *
     * @return CeMateriaporplanestudios
     */
    public function setRequiereconfigurarherramientas($requiereconfigurarherramientas)
    {
        $this->requiereconfigurarherramientas = $requiereconfigurarherramientas;

        return $this;
    }

    /**
     * Get requiereconfigurarherramientas
     *
     * @return boolean
     */
    public function getRequiereconfigurarherramientas()
    {
        return $this->requiereconfigurarherramientas;
    }

    /**
     * Set requiereconfigurarapoyos
     *
     * @param boolean $requiereconfigurarapoyos
     *
     * @return CeMateriaporplanestudios
     */
    public function setRequiereconfigurarapoyos($requiereconfigurarapoyos)
    {
        $this->requiereconfigurarapoyos = $requiereconfigurarapoyos;

        return $this;
    }

    /**
     * Get requiereconfigurarapoyos
     *
     * @return boolean
     */
    public function getRequiereconfigurarapoyos()
    {
        return $this->requiereconfigurarapoyos;
    }

    /**
     * Set horasporsemana
     *
     * @param float $horasporsemana
     *
     * @return CeMateriaporplanestudios
     */
    public function setHorasporsemana($horasporsemana)
    {
        $this->horasporsemana = $horasporsemana;

        return $this;
    }

    /**
     * Get horasporsemana
     *
     * @return float
     */
    public function getHorasporsemana()
    {
        return $this->horasporsemana;
    }

    /**
     * Set reportarcalificacion
     *
     * @param boolean $reportarcalificacion
     *
     * @return CeMateriaporplanestudios
     */
    public function setReportarcalificacion($reportarcalificacion)
    {
        $this->reportarcalificacion = $reportarcalificacion;

        return $this;
    }

    /**
     * Get reportarcalificacion
     *
     * @return boolean
     */
    public function getReportarcalificacion()
    {
        return $this->reportarcalificacion;
    }

    /**
     * Set configurartaller
     *
     * @param boolean $configurartaller
     *
     * @return CeMateriaporplanestudios
     */
    public function setConfigurartaller($configurartaller)
    {
        $this->configurartaller = $configurartaller;

        return $this;
    }

    /**
     * Get configurartaller
     *
     * @return boolean
     */
    public function getConfigurartaller()
    {
        return $this->configurartaller;
    }

    /**
     * Get materiaporplanestudioid
     *
     * @return integer
     */
    public function getMateriaporplanestudioid()
    {
        return $this->materiaporplanestudioid;
    }

    /**
     * Set componentecurricularid
     *
     * @param \AppBundle\Entity\CeComponentecurricular $componentecurricularid
     *
     * @return CeMateriaporplanestudios
     */
    public function setComponentecurricularid(\AppBundle\Entity\CeComponentecurricular $componentecurricularid = null)
    {
        $this->componentecurricularid = $componentecurricularid;

        return $this;
    }

    /**
     * Get componentecurricularid
     *
     * @return \AppBundle\Entity\CeComponentecurricular
     */
    public function getComponentecurricularid()
    {
        return $this->componentecurricularid;
    }

    /**
     * Set planestudioid
     *
     * @param \AppBundle\Entity\CePlanestudios $planestudioid
     *
     * @return CeMateriaporplanestudios
     */
    public function setPlanestudioid(\AppBundle\Entity\CePlanestudios $planestudioid = null)
    {
        $this->planestudioid = $planestudioid;

        return $this;
    }

    /**
     * Get planestudioid
     *
     * @return \AppBundle\Entity\CePlanestudios
     */
    public function getPlanestudioid()
    {
        return $this->planestudioid;
    }

    /**
     * Set materiaid
     *
     * @param \AppBundle\Entity\Materia $materiaid
     *
     * @return CeMateriaporplanestudios
     */
    public function setMateriaid(\AppBundle\Entity\Materia $materiaid = null)
    {
        $this->materiaid = $materiaid;

        return $this;
    }

    /**
     * Get materiaid
     *
     * @return \AppBundle\Entity\Materia
     */
    public function getMateriaid()
    {
        return $this->materiaid;
    }

    /**
     * Set materiafrecuenciacapturaid
     *
     * @param \AppBundle\Entity\CeMateriafrecuenciacaptura $materiafrecuenciacapturaid
     *
     * @return CeMateriaporplanestudios
     */
    public function setMateriafrecuenciacapturaid(\AppBundle\Entity\CeMateriafrecuenciacaptura $materiafrecuenciacapturaid = null)
    {
        $this->materiafrecuenciacapturaid = $materiafrecuenciacapturaid;

        return $this;
    }

    /**
     * Get materiafrecuenciacapturaid
     *
     * @return \AppBundle\Entity\CeMateriafrecuenciacaptura
     */
    public function getMateriafrecuenciacapturaid()
    {
        return $this->materiafrecuenciacapturaid;
    }

    /**
     * Set reportarmateriaid
     *
     * @param \AppBundle\Entity\Materia $reportarmateriaid
     *
     * @return CeMateriaporplanestudios
     */
    public function setReportarmateriaid(\AppBundle\Entity\Materia $reportarmateriaid = null)
    {
        $this->reportarmateriaid = $reportarmateriaid;

        return $this;
    }

    /**
     * Get reportarmateriaid
     *
     * @return \AppBundle\Entity\Materia
     */
    public function getReportarmateriaid()
    {
        return $this->reportarmateriaid;
    }
}

