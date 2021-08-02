<?php

namespace AppBundle\Entity;

/**
 * CeConftalleresextracurriculares
 */
class CeConftalleresextracurriculares
{
    /**
     * @var integer
     */
    private $horasreservacion;

    /**
     * @var float
     */
    private $descuentoempleados;

    /**
     * @var \DateTime
     */
    private $fechatallersem1inicio;

    /**
     * @var \DateTime
     */
    private $fechatallersem1fin;

    /**
     * @var \DateTime
     */
    private $fechatallersem2inicio;

    /**
     * @var \DateTime
     */
    private $fechatallersem2fin;

    /**
     * @var integer
     */
    private $conftallerextracurricularid;


    /**
     * Set horasreservacion
     *
     * @param integer $horasreservacion
     *
     * @return CeConftalleresextracurriculares
     */
    public function setHorasreservacion($horasreservacion)
    {
        $this->horasreservacion = $horasreservacion;

        return $this;
    }

    /**
     * Get horasreservacion
     *
     * @return integer
     */
    public function getHorasreservacion()
    {
        return $this->horasreservacion;
    }

    /**
     * Set descuentoempleados
     *
     * @param float $descuentoempleados
     *
     * @return CeConftalleresextracurriculares
     */
    public function setDescuentoempleados($descuentoempleados)
    {
        $this->descuentoempleados = $descuentoempleados;

        return $this;
    }

    /**
     * Get descuentoempleados
     *
     * @return float
     */
    public function getDescuentoempleados()
    {
        return $this->descuentoempleados;
    }

    /**
     * Set fechatallersem1inicio
     *
     * @param \DateTime $fechatallersem1inicio
     *
     * @return CeConftalleresextracurriculares
     */
    public function setFechatallersem1inicio($fechatallersem1inicio)
    {
        $this->fechatallersem1inicio = $fechatallersem1inicio;

        return $this;
    }

    /**
     * Get fechatallersem1inicio
     *
     * @return \DateTime
     */
    public function getFechatallersem1inicio()
    {
        return $this->fechatallersem1inicio;
    }

    /**
     * Set fechatallersem1fin
     *
     * @param \DateTime $fechatallersem1fin
     *
     * @return CeConftalleresextracurriculares
     */
    public function setFechatallersem1fin($fechatallersem1fin)
    {
        $this->fechatallersem1fin = $fechatallersem1fin;

        return $this;
    }

    /**
     * Get fechatallersem1fin
     *
     * @return \DateTime
     */
    public function getFechatallersem1fin()
    {
        return $this->fechatallersem1fin;
    }

    /**
     * Set fechatallersem2inicio
     *
     * @param \DateTime $fechatallersem2inicio
     *
     * @return CeConftalleresextracurriculares
     */
    public function setFechatallersem2inicio($fechatallersem2inicio)
    {
        $this->fechatallersem2inicio = $fechatallersem2inicio;

        return $this;
    }

    /**
     * Get fechatallersem2inicio
     *
     * @return \DateTime
     */
    public function getFechatallersem2inicio()
    {
        return $this->fechatallersem2inicio;
    }

    /**
     * Set fechatallersem2fin
     *
     * @param \DateTime $fechatallersem2fin
     *
     * @return CeConftalleresextracurriculares
     */
    public function setFechatallersem2fin($fechatallersem2fin)
    {
        $this->fechatallersem2fin = $fechatallersem2fin;

        return $this;
    }

    /**
     * Get fechatallersem2fin
     *
     * @return \DateTime
     */
    public function getFechatallersem2fin()
    {
        return $this->fechatallersem2fin;
    }

    /**
     * Get conftallerextracurricularid
     *
     * @return integer
     */
    public function getConftallerextracurricularid()
    {
        return $this->conftallerextracurricularid;
    }
}

