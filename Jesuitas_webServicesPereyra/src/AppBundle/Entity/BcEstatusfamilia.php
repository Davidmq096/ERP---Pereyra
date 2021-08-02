<?php

namespace AppBundle\Entity;

/**
 * BcEstatusfamilia
 */
class BcEstatusfamilia
{
    /**
     * @var string
     */
    private $estatus;

    /**
     * @var integer
     */
    private $estatusfamiliaid;


    /**
     * Set estatus
     *
     * @param string $estatus
     *
     * @return BcEstatusfamilia
     */
    public function setEstatus($estatus)
    {
        $this->estatus = $estatus;

        return $this;
    }

    /**
     * Get estatus
     *
     * @return string
     */
    public function getEstatus()
    {
        return $this->estatus;
    }

    /**
     * Get estatusfamiliaid
     *
     * @return integer
     */
    public function getEstatusfamiliaid()
    {
        return $this->estatusfamiliaid;
    }
}

