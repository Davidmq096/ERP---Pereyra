<?php

namespace AppBundle\Entity;

/**
 * CeConftallercurricular
 */
class CeConftallercurricular
{
    /**
     * @var \DateTime
     */
    private $fechaarmadogrupoinicio;

    /**
     * @var \DateTime
     */
    private $fechaarmadogrupofin;

    /**
     * @var \DateTime
     */
    private $fechapreregistroinicio;

    /**
     * @var \DateTime
     */
    private $fechapreregistrofin;

    /**
     * @var integer
     */
    private $conftallercurricularid;


    /**
     * Set fechaarmadogrupoinicio
     *
     * @param \DateTime $fechaarmadogrupoinicio
     *
     * @return CeConftallercurricular
     */
    public function setFechaarmadogrupoinicio($fechaarmadogrupoinicio)
    {
        $this->fechaarmadogrupoinicio = $fechaarmadogrupoinicio;

        return $this;
    }

    /**
     * Get fechaarmadogrupoinicio
     *
     * @return \DateTime
     */
    public function getFechaarmadogrupoinicio()
    {
        return $this->fechaarmadogrupoinicio;
    }

    /**
     * Set fechaarmadogrupofin
     *
     * @param \DateTime $fechaarmadogrupofin
     *
     * @return CeConftallercurricular
     */
    public function setFechaarmadogrupofin($fechaarmadogrupofin)
    {
        $this->fechaarmadogrupofin = $fechaarmadogrupofin;

        return $this;
    }

    /**
     * Get fechaarmadogrupofin
     *
     * @return \DateTime
     */
    public function getFechaarmadogrupofin()
    {
        return $this->fechaarmadogrupofin;
    }

    /**
     * Set fechapreregistroinicio
     *
     * @param \DateTime $fechapreregistroinicio
     *
     * @return CeConftallercurricular
     */
    public function setFechapreregistroinicio($fechapreregistroinicio)
    {
        $this->fechapreregistroinicio = $fechapreregistroinicio;

        return $this;
    }

    /**
     * Get fechapreregistroinicio
     *
     * @return \DateTime
     */
    public function getFechapreregistroinicio()
    {
        return $this->fechapreregistroinicio;
    }

    /**
     * Set fechapreregistrofin
     *
     * @param \DateTime $fechapreregistrofin
     *
     * @return CeConftallercurricular
     */
    public function setFechapreregistrofin($fechapreregistrofin)
    {
        $this->fechapreregistrofin = $fechapreregistrofin;

        return $this;
    }

    /**
     * Get fechapreregistrofin
     *
     * @return \DateTime
     */
    public function getFechapreregistrofin()
    {
        return $this->fechapreregistrofin;
    }

    /**
     * Get conftallercurricularid
     *
     * @return integer
     */
    public function getConftallercurricularid()
    {
        return $this->conftallercurricularid;
    }
}

