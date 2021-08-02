<?php

namespace AppBundle\Entity;

/**
 * CeCapturacalificacionporalumno
 */
class CeCapturacalificacionporalumno
{
    /**
     * @var integer
     */
    private $numerocaptura;

    /**
     * @var string
     */
    private $calificacion;

    /**
     * @var integer
     */
    private $capturacalificacionporalumnoid;

    /**
     * @var \AppBundle\Entity\CeCalificacionperiodoporalumno
     */
    private $calificacionperiodoporalumnoid;

    /**
     * @var \AppBundle\Entity\CeCriterioevaluaciongrupo
     */
    private $criterioevaluaciongrupoid;


    /**
     * Set numerocaptura
     *
     * @param integer $numerocaptura
     *
     * @return CeCapturacalificacionporalumno
     */
    public function setNumerocaptura($numerocaptura)
    {
        $this->numerocaptura = $numerocaptura;

        return $this;
    }

    /**
     * Get numerocaptura
     *
     * @return integer
     */
    public function getNumerocaptura()
    {
        return $this->numerocaptura;
    }

    /**
     * Set calificacion
     *
     * @param string $calificacion
     *
     * @return CeCapturacalificacionporalumno
     */
    public function setCalificacion($calificacion)
    {
        $this->calificacion = $calificacion;

        return $this;
    }

    /**
     * Get calificacion
     *
     * @return string
     */
    public function getCalificacion()
    {
        return $this->calificacion;
    }

    /**
     * Get capturacalificacionporalumnoid
     *
     * @return integer
     */
    public function getCapturacalificacionporalumnoid()
    {
        return $this->capturacalificacionporalumnoid;
    }

    /**
     * Set calificacionperiodoporalumnoid
     *
     * @param \AppBundle\Entity\CeCalificacionperiodoporalumno $calificacionperiodoporalumnoid
     *
     * @return CeCapturacalificacionporalumno
     */
    public function setCalificacionperiodoporalumnoid(\AppBundle\Entity\CeCalificacionperiodoporalumno $calificacionperiodoporalumnoid = null)
    {
        $this->calificacionperiodoporalumnoid = $calificacionperiodoporalumnoid;

        return $this;
    }

    /**
     * Get calificacionperiodoporalumnoid
     *
     * @return \AppBundle\Entity\CeCalificacionperiodoporalumno
     */
    public function getCalificacionperiodoporalumnoid()
    {
        return $this->calificacionperiodoporalumnoid;
    }

    /**
     * Set criterioevaluaciongrupoid
     *
     * @param \AppBundle\Entity\CeCriterioevaluaciongrupo $criterioevaluaciongrupoid
     *
     * @return CeCapturacalificacionporalumno
     */
    public function setCriterioevaluaciongrupoid(\AppBundle\Entity\CeCriterioevaluaciongrupo $criterioevaluaciongrupoid = null)
    {
        $this->criterioevaluaciongrupoid = $criterioevaluaciongrupoid;

        return $this;
    }

    /**
     * Get criterioevaluaciongrupoid
     *
     * @return \AppBundle\Entity\CeCriterioevaluaciongrupo
     */
    public function getCriterioevaluaciongrupoid()
    {
        return $this->criterioevaluaciongrupoid;
    }
}

