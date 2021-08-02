<?php

namespace AppBundle\Controller\lib\Vistas;

use AppBundle\Entity\CePeriodoevaluacion;

/**
 * CePeriodoevaluacionVista
 */
class PeriodoEvaluacionVista
{
    /**
     * @var CePeriodoevaluacion
     */
    private $periodoevaluacion;

     /**
     * @var string
     */
    private $periodofechas;

    /**
     * @var integer
     */
    private $periodoevaluacionid;

    /**
     * Get the value of periodoevaluacion
     *
     * @return  CePeriodoevaluacion
     */ 
    public function getPeriodoevaluacion()
    {
        return $this->periodoevaluacion;
    }

    /**
     * Set the value of periodoevaluacion
     *
     * @param  CePeriodoevaluacion  $periodoevaluacion
     *
     * @return  self
     */ 
    public function setPeriodoevaluacion(CePeriodoevaluacion $periodoevaluacion)
    {
        $this->periodoevaluacion = $periodoevaluacion;

        return $this;
    }

    /**
     * Get the value of periodofechas
     *
     * @return  string
     */ 
    public function getPeriodofechas()
    {
        return $this->periodofechas;
    }

    /**
     * Set the value of periodofechas
     *
     * @param  string  $periodofechas
     *
     * @return  self
     */ 
    public function setPeriodofechas(string $periodofechas)
    {
        $this->periodofechas = $periodofechas;

        return $this;
    }

    /**
     * Get the value of periodoevaluacionid
     *
     * @return  integer
     */ 
    public function getPeriodoevaluacionid()
    {
        return $this->periodoevaluacionid;
    }

    /**
     * Set the value of periodoevaluacionid
     *
     * @param  integer  $periodoevaluacionid
     *
     * @return  self
     */ 
    public function setPeriodoevaluacionid($periodoevaluacionid)
    {
        $this->periodoevaluacionid = $periodoevaluacionid;

        return $this;
    }
}
