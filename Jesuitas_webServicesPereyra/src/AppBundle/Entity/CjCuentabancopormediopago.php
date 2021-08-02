<?php

namespace AppBundle\Entity;

/**
 * CjCuentabancopormediopago
 */
class CjCuentabancopormediopago
{
    /**
     * @var string
     */
    private $tipopago;

    /**
     * @var integer
     */
    private $cuentabancopormediopagoid;

    /**
     * @var \AppBundle\Entity\CjCuentacontable
     */
    private $cuentacontableid;

    /**
     * @var \AppBundle\Entity\CjFormapago
     */
    private $formapagoid;

    /**
     * @var \AppBundle\Entity\CjMediopago
     */
    private $mediopagoid;


    /**
     * Set tipopago
     *
     * @param string $tipopago
     *
     * @return CjCuentabancopormediopago
     */
    public function setTipopago($tipopago)
    {
        $this->tipopago = $tipopago;

        return $this;
    }

    /**
     * Get tipopago
     *
     * @return string
     */
    public function getTipopago()
    {
        return $this->tipopago;
    }

    /**
     * Get cuentabancopormediopagoid
     *
     * @return integer
     */
    public function getCuentabancopormediopagoid()
    {
        return $this->cuentabancopormediopagoid;
    }

    /**
     * Set cuentacontableid
     *
     * @param \AppBundle\Entity\CjCuentacontable $cuentacontableid
     *
     * @return CjCuentabancopormediopago
     */
    public function setCuentacontableid(\AppBundle\Entity\CjCuentacontable $cuentacontableid = null)
    {
        $this->cuentacontableid = $cuentacontableid;

        return $this;
    }

    /**
     * Get cuentacontableid
     *
     * @return \AppBundle\Entity\CjCuentacontable
     */
    public function getCuentacontableid()
    {
        return $this->cuentacontableid;
    }

    /**
     * Set formapagoid
     *
     * @param \AppBundle\Entity\CjFormapago $formapagoid
     *
     * @return CjCuentabancopormediopago
     */
    public function setFormapagoid(\AppBundle\Entity\CjFormapago $formapagoid = null)
    {
        $this->formapagoid = $formapagoid;

        return $this;
    }

    /**
     * Get formapagoid
     *
     * @return \AppBundle\Entity\CjFormapago
     */
    public function getFormapagoid()
    {
        return $this->formapagoid;
    }

    /**
     * Set mediopagoid
     *
     * @param \AppBundle\Entity\CjMediopago $mediopagoid
     *
     * @return CjCuentabancopormediopago
     */
    public function setMediopagoid(\AppBundle\Entity\CjMediopago $mediopagoid = null)
    {
        $this->mediopagoid = $mediopagoid;

        return $this;
    }

    /**
     * Get mediopagoid
     *
     * @return \AppBundle\Entity\CjMediopago
     */
    public function getMediopagoid()
    {
        return $this->mediopagoid;
    }
}

