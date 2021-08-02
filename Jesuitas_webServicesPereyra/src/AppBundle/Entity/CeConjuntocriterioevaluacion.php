<?php

namespace AppBundle\Entity;

/**
 * CeConjuntocriterioevaluacion
 */
class CeConjuntocriterioevaluacion
{
    /**
     * @var integer
     */
    private $conjuntocriterioevaluacionid;

    /**
     * @var \AppBundle\Entity\CeEstatuscriterioevaluacion
     */
    private $estatuscriterioevaluacionid;

    /**
     * @var \AppBundle\Entity\Ciclo
     */
    private $cicloid;

    /**
     * @var \AppBundle\Entity\CeTallercurricular
     */
    private $tallercurricularid;

    /**
     * @var \AppBundle\Entity\CeMateriaporplanestudios
     */
    private $materiaporplanestudioid;


    /**
     * Get conjuntocriterioevaluacionid
     *
     * @return integer
     */
    public function getConjuntocriterioevaluacionid()
    {
        return $this->conjuntocriterioevaluacionid;
    }

    /**
     * Set estatuscriterioevaluacionid
     *
     * @param \AppBundle\Entity\CeEstatuscriterioevaluacion $estatuscriterioevaluacionid
     *
     * @return CeConjuntocriterioevaluacion
     */
    public function setEstatuscriterioevaluacionid(\AppBundle\Entity\CeEstatuscriterioevaluacion $estatuscriterioevaluacionid = null)
    {
        $this->estatuscriterioevaluacionid = $estatuscriterioevaluacionid;

        return $this;
    }

    /**
     * Get estatuscriterioevaluacionid
     *
     * @return \AppBundle\Entity\CeEstatuscriterioevaluacion
     */
    public function getEstatuscriterioevaluacionid()
    {
        return $this->estatuscriterioevaluacionid;
    }

    /**
     * Set cicloid
     *
     * @param \AppBundle\Entity\Ciclo $cicloid
     *
     * @return CeConjuntocriterioevaluacion
     */
    public function setCicloid(\AppBundle\Entity\Ciclo $cicloid = null)
    {
        $this->cicloid = $cicloid;

        return $this;
    }

    /**
     * Get cicloid
     *
     * @return \AppBundle\Entity\Ciclo
     */
    public function getCicloid()
    {
        return $this->cicloid;
    }

    /**
     * Set tallercurricularid
     *
     * @param \AppBundle\Entity\CeTallercurricular $tallercurricularid
     *
     * @return CeConjuntocriterioevaluacion
     */
    public function setTallercurricularid(\AppBundle\Entity\CeTallercurricular $tallercurricularid = null)
    {
        $this->tallercurricularid = $tallercurricularid;

        return $this;
    }

    /**
     * Get tallercurricularid
     *
     * @return \AppBundle\Entity\CeTallercurricular
     */
    public function getTallercurricularid()
    {
        return $this->tallercurricularid;
    }

    /**
     * Set materiaporplanestudioid
     *
     * @param \AppBundle\Entity\CeMateriaporplanestudios $materiaporplanestudioid
     *
     * @return CeConjuntocriterioevaluacion
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

