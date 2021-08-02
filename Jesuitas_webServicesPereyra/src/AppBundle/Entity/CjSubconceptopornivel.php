<?php

namespace AppBundle\Entity;

/**
 * CjSubconceptopornivel
 */
class CjSubconceptopornivel
{
    /**
     * @var string
     */
    private $importe;

    /**
     * @var boolean
     */
    private $descuentobeca;

    /**
     * @var boolean
     */
    private $descuentoprontopago;

    /**
     * @var string
     */
    private $importeminimo;

    /**
     * @var string
     */
    private $importedescuentoprontopago;

    /**
     * @var integer
     */
    private $dialimiteprontopago;

    /**
     * @var integer
     */
    private $dialimitepago;

    /**
     * @var \DateTime
     */
    private $fechalimitepago;

    /**
     * @var \DateTime
     */
    private $fechalimiteprontopago;

    /**
     * @var boolean
     */
    private $activo;

    /**
     * @var integer
     */
    private $subconceptopornivelid;

    /**
     * @var \AppBundle\Entity\CjCodigosat
     */
    private $codigosatid;

    /**
     * @var \AppBundle\Entity\Nivel
     */
    private $nivelid;

    /**
     * @var \AppBundle\Entity\CjSubconcepto
     */
    private $subconceptoid;


    /**
     * Set importe
     *
     * @param string $importe
     *
     * @return CjSubconceptopornivel
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
     * Set descuentobeca
     *
     * @param boolean $descuentobeca
     *
     * @return CjSubconceptopornivel
     */
    public function setDescuentobeca($descuentobeca)
    {
        $this->descuentobeca = $descuentobeca;

        return $this;
    }

    /**
     * Get descuentobeca
     *
     * @return boolean
     */
    public function getDescuentobeca()
    {
        return $this->descuentobeca;
    }

    /**
     * Set descuentoprontopago
     *
     * @param boolean $descuentoprontopago
     *
     * @return CjSubconceptopornivel
     */
    public function setDescuentoprontopago($descuentoprontopago)
    {
        $this->descuentoprontopago = $descuentoprontopago;

        return $this;
    }

    /**
     * Get descuentoprontopago
     *
     * @return boolean
     */
    public function getDescuentoprontopago()
    {
        return $this->descuentoprontopago;
    }

    /**
     * Set importeminimo
     *
     * @param string $importeminimo
     *
     * @return CjSubconceptopornivel
     */
    public function setImporteminimo($importeminimo)
    {
        $this->importeminimo = $importeminimo;

        return $this;
    }

    /**
     * Get importeminimo
     *
     * @return string
     */
    public function getImporteminimo()
    {
        return $this->importeminimo;
    }

    /**
     * Set importedescuentoprontopago
     *
     * @param string $importedescuentoprontopago
     *
     * @return CjSubconceptopornivel
     */
    public function setImportedescuentoprontopago($importedescuentoprontopago)
    {
        $this->importedescuentoprontopago = $importedescuentoprontopago;

        return $this;
    }

    /**
     * Get importedescuentoprontopago
     *
     * @return string
     */
    public function getImportedescuentoprontopago()
    {
        return $this->importedescuentoprontopago;
    }

    /**
     * Set dialimiteprontopago
     *
     * @param integer $dialimiteprontopago
     *
     * @return CjSubconceptopornivel
     */
    public function setDialimiteprontopago($dialimiteprontopago)
    {
        $this->dialimiteprontopago = $dialimiteprontopago;

        return $this;
    }

    /**
     * Get dialimiteprontopago
     *
     * @return integer
     */
    public function getDialimiteprontopago()
    {
        return $this->dialimiteprontopago;
    }

    /**
     * Set dialimitepago
     *
     * @param integer $dialimitepago
     *
     * @return CjSubconceptopornivel
     */
    public function setDialimitepago($dialimitepago)
    {
        $this->dialimitepago = $dialimitepago;

        return $this;
    }

    /**
     * Get dialimitepago
     *
     * @return integer
     */
    public function getDialimitepago()
    {
        return $this->dialimitepago;
    }

    /**
     * Set fechalimitepago
     *
     * @param \DateTime $fechalimitepago
     *
     * @return CjSubconceptopornivel
     */
    public function setFechalimitepago($fechalimitepago)
    {
        $this->fechalimitepago = $fechalimitepago;

        return $this;
    }

    /**
     * Get fechalimitepago
     *
     * @return \DateTime
     */
    public function getFechalimitepago()
    {
        return $this->fechalimitepago;
    }

    /**
     * Set fechalimiteprontopago
     *
     * @param \DateTime $fechalimiteprontopago
     *
     * @return CjSubconceptopornivel
     */
    public function setFechalimiteprontopago($fechalimiteprontopago)
    {
        $this->fechalimiteprontopago = $fechalimiteprontopago;

        return $this;
    }

    /**
     * Get fechalimiteprontopago
     *
     * @return \DateTime
     */
    public function getFechalimiteprontopago()
    {
        return $this->fechalimiteprontopago;
    }

    /**
     * Set activo
     *
     * @param boolean $activo
     *
     * @return CjSubconceptopornivel
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
     * Get subconceptopornivelid
     *
     * @return integer
     */
    public function getSubconceptopornivelid()
    {
        return $this->subconceptopornivelid;
    }

    /**
     * Set codigosatid
     *
     * @param \AppBundle\Entity\CjCodigosat $codigosatid
     *
     * @return CjSubconceptopornivel
     */
    public function setCodigosatid(\AppBundle\Entity\CjCodigosat $codigosatid = null)
    {
        $this->codigosatid = $codigosatid;

        return $this;
    }

    /**
     * Get codigosatid
     *
     * @return \AppBundle\Entity\CjCodigosat
     */
    public function getCodigosatid()
    {
        return $this->codigosatid;
    }

    /**
     * Set nivelid
     *
     * @param \AppBundle\Entity\Nivel $nivelid
     *
     * @return CjSubconceptopornivel
     */
    public function setNivelid(\AppBundle\Entity\Nivel $nivelid = null)
    {
        $this->nivelid = $nivelid;

        return $this;
    }

    /**
     * Get nivelid
     *
     * @return \AppBundle\Entity\Nivel
     */
    public function getNivelid()
    {
        return $this->nivelid;
    }

    /**
     * Set subconceptoid
     *
     * @param \AppBundle\Entity\CjSubconcepto $subconceptoid
     *
     * @return CjSubconceptopornivel
     */
    public function setSubconceptoid(\AppBundle\Entity\CjSubconcepto $subconceptoid = null)
    {
        $this->subconceptoid = $subconceptoid;

        return $this;
    }

    /**
     * Get subconceptoid
     *
     * @return \AppBundle\Entity\CjSubconcepto
     */
    public function getSubconceptoid()
    {
        return $this->subconceptoid;
    }
}

