<?php

namespace AppBundle\Entity;

/**
 * CjExtraordinariosubconceptopormateria
 */
class CjExtraordinariosubconceptopormateria
{
    /**
     * @var \DateTime
     */
    private $fechalimitepago;

    /**
     * @var integer
     */
    private $extraordinariosubconceptopormateriaid;

    /**
     * @var \AppBundle\Entity\CjSubconcepto
     */
    private $subconceptoid;

    /**
     * @var \AppBundle\Entity\Materia
     */
    private $materiaid;


    /**
     * Set fechalimitepago
     *
     * @param \DateTime $fechalimitepago
     *
     * @return CjExtraordinariosubconceptopormateria
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
     * Get extraordinariosubconceptopormateriaid
     *
     * @return integer
     */
    public function getExtraordinariosubconceptopormateriaid()
    {
        return $this->extraordinariosubconceptopormateriaid;
    }

    /**
     * Set subconceptoid
     *
     * @param \AppBundle\Entity\CjSubconcepto $subconceptoid
     *
     * @return CjExtraordinariosubconceptopormateria
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

    /**
     * Set materiaid
     *
     * @param \AppBundle\Entity\Materia $materiaid
     *
     * @return CjExtraordinariosubconceptopormateria
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
}

