<?php

namespace AppBundle\Entity;

/**
 * Medicamento
 */
class Medicamento
{
    /**
     * @var string
     */
    private $descripcion;

    /**
     * @var boolean
     */
    private $antigripal;

    /**
     * @var boolean
     */
    private $analgesico;

    /**
     * @var boolean
     */
    private $antispasmodico;

    /**
     * @var boolean
     */
    private $materialcuracion;

    /**
     * @var boolean
     */
    private $unguento;

    /**
     * @var boolean
     */
    private $remediosalternativo;

    /**
     * @var boolean
     */
    private $antiacidos;

    /**
     * @var integer
     */
    private $medicamentosid;


    /**
     * Set descripcion
     *
     * @param string $descripcion
     *
     * @return Medicamento
     */
    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    /**
     * Get descripcion
     *
     * @return string
     */
    public function getDescripcion()
    {
        return $this->descripcion;
    }

    /**
     * Set antigripal
     *
     * @param boolean $antigripal
     *
     * @return Medicamento
     */
    public function setAntigripal($antigripal)
    {
        $this->antigripal = $antigripal;

        return $this;
    }

    /**
     * Get antigripal
     *
     * @return boolean
     */
    public function getAntigripal()
    {
        return $this->antigripal;
    }

    /**
     * Set analgesico
     *
     * @param boolean $analgesico
     *
     * @return Medicamento
     */
    public function setAnalgesico($analgesico)
    {
        $this->analgesico = $analgesico;

        return $this;
    }

    /**
     * Get analgesico
     *
     * @return boolean
     */
    public function getAnalgesico()
    {
        return $this->analgesico;
    }

    /**
     * Set antispasmodico
     *
     * @param boolean $antispasmodico
     *
     * @return Medicamento
     */
    public function setAntispasmodico($antispasmodico)
    {
        $this->antispasmodico = $antispasmodico;

        return $this;
    }

    /**
     * Get antispasmodico
     *
     * @return boolean
     */
    public function getAntispasmodico()
    {
        return $this->antispasmodico;
    }

    /**
     * Set materialcuracion
     *
     * @param boolean $materialcuracion
     *
     * @return Medicamento
     */
    public function setMaterialcuracion($materialcuracion)
    {
        $this->materialcuracion = $materialcuracion;

        return $this;
    }

    /**
     * Get materialcuracion
     *
     * @return boolean
     */
    public function getMaterialcuracion()
    {
        return $this->materialcuracion;
    }

    /**
     * Set unguento
     *
     * @param boolean $unguento
     *
     * @return Medicamento
     */
    public function setUnguento($unguento)
    {
        $this->unguento = $unguento;

        return $this;
    }

    /**
     * Get unguento
     *
     * @return boolean
     */
    public function getUnguento()
    {
        return $this->unguento;
    }

    /**
     * Set remediosalternativo
     *
     * @param boolean $remediosalternativo
     *
     * @return Medicamento
     */
    public function setRemediosalternativo($remediosalternativo)
    {
        $this->remediosalternativo = $remediosalternativo;

        return $this;
    }

    /**
     * Get remediosalternativo
     *
     * @return boolean
     */
    public function getRemediosalternativo()
    {
        return $this->remediosalternativo;
    }

    /**
     * Set antiacidos
     *
     * @param boolean $antiacidos
     *
     * @return Medicamento
     */
    public function setAntiacidos($antiacidos)
    {
        $this->antiacidos = $antiacidos;

        return $this;
    }

    /**
     * Get antiacidos
     *
     * @return boolean
     */
    public function getAntiacidos()
    {
        return $this->antiacidos;
    }

    /**
     * Get medicamentosid
     *
     * @return integer
     */
    public function getMedicamentosid()
    {
        return $this->medicamentosid;
    }
}

