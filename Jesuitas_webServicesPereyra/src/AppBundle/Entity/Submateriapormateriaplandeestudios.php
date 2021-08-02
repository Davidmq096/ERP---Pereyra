<?php

namespace AppBundle\Entity;

/**
 * Submateriapormateriaplandeestudios
 */
class Submateriapormateriaplandeestudios
{
    /**
     * @var string
     */
    private $porcentajedecalificacion;

    /**
     * @var integer
     */
    private $submateriapormateriaplandeestudiosid;

    /**
     * @var \AppBundle\Entity\Materia
     */
    private $materiaid;

    /**
     * @var \AppBundle\Entity\CeMateriaporplanestudios
     */
    private $materiaporplanestudioid;


    /**
     * Set porcentajedecalificacion
     *
     * @param string $porcentajedecalificacion
     *
     * @return Submateriapormateriaplandeestudios
     */
    public function setPorcentajedecalificacion($porcentajedecalificacion)
    {
        $this->porcentajedecalificacion = $porcentajedecalificacion;

        return $this;
    }

    /**
     * Get porcentajedecalificacion
     *
     * @return string
     */
    public function getPorcentajedecalificacion()
    {
        return $this->porcentajedecalificacion;
    }

    /**
     * Get submateriapormateriaplandeestudiosid
     *
     * @return integer
     */
    public function getSubmateriapormateriaplandeestudiosid()
    {
        return $this->submateriapormateriaplandeestudiosid;
    }

    /**
     * Set materiaid
     *
     * @param \AppBundle\Entity\Materia $materiaid
     *
     * @return Submateriapormateriaplandeestudios
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
     * Set materiaporplanestudioid
     *
     * @param \AppBundle\Entity\CeMateriaporplanestudios $materiaporplanestudioid
     *
     * @return Submateriapormateriaplandeestudios
     */
    public function setMateriaporplanestudioid(\AppBundle\Entity\CeMateriaporplanestudios $materiaporplanestudioid = null)
    {
        $this->materiaporplanestudioid = $materiaporplanestudioid;

        return $this;
    }

    /**
     * Get materiaporplanestudioid
     *
     * @return \AppBundle\Entity\CeMateriaporplanestudios
     */
    public function getMateriaporplanestudioid()
    {
        return $this->materiaporplanestudioid;
    }
}

