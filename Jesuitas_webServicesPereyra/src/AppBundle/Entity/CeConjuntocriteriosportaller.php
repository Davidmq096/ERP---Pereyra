<?php

namespace AppBundle\Entity;

/**
 * CeConjuntocriteriosportaller
 */
class CeConjuntocriteriosportaller
{
    /**
     * @var integer
     */
    private $conjuntocriteriosportallerid;

    /**
     * @var \AppBundle\Entity\CeConjuntocriterioevaluacion
     */
    private $conjuntocriterioevaluacionid;

    /**
     * @var \AppBundle\Entity\CeMateriaporplanestudios
     */
    private $materiaporplanestudioid;


    /**
     * Get conjuntocriteriosportallerid
     *
     * @return integer
     */
    public function getConjuntocriteriosportallerid()
    {
        return $this->conjuntocriteriosportallerid;
    }

    /**
     * Set conjuntocriterioevaluacionid
     *
     * @param \AppBundle\Entity\CeConjuntocriterioevaluacion $conjuntocriterioevaluacionid
     *
     * @return CeConjuntocriteriosportaller
     */
    public function setConjuntocriterioevaluacionid(\AppBundle\Entity\CeConjuntocriterioevaluacion $conjuntocriterioevaluacionid = null)
    {
        $this->conjuntocriterioevaluacionid = $conjuntocriterioevaluacionid;

        return $this;
    }

    /**
     * Get conjuntocriterioevaluacionid
     *
     * @return \AppBundle\Entity\CeConjuntocriterioevaluacion
     */
    public function getConjuntocriterioevaluacionid()
    {
        return $this->conjuntocriterioevaluacionid;
    }

    /**
     * Set materiaporplanestudioid
     *
     * @param \AppBundle\Entity\CeMateriaporplanestudios $materiaporplanestudioid
     *
     * @return CeConjuntocriteriosportaller
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

