<?php

namespace AppBundle\Entity;

/**
 * CeCalificacionperiodoporalumno
 */
class CeCalificacionperiodoporalumno
{
    /**
     * @var string
     */
    private $calificacionantesredondeo;

    /**
     * @var string
     */
    private $calificacion;

    /**
     * @var string
     */
    private $observacion;

    /**
     * @var float
     */
    private $avance = '0';

    /**
     * @var integer
     */
    private $calificacionperiodoporalumnoid;

    /**
     * @var \AppBundle\Entity\CeCalificacionperiodoporalumno
     */
    private $materiapadrecalificacionperiodoporalumnoid;

    /**
     * @var \AppBundle\Entity\CeCalificacionfinalperiodoporalumno
     */
    private $calificacionfinalporperiodoalumno;

    /**
     * @var \AppBundle\Entity\CeMateriaporplanestudios
     */
    private $materiaporplanestudioid;

    /**
     * @var \AppBundle\Entity\Materia
     */
    private $materiaid;

    /**
     * @var \AppBundle\Entity\CeAlumnoporciclo
     */
    private $alumnoporcicloid;

    /**
     * @var \AppBundle\Entity\CeProfesorpormateriaplanestudios
     */
    private $profesorpormateriaplanestudioid;

    /**
     * @var \AppBundle\Entity\CeAlumno
     */
    private $alumnoid;

    /**
     * @var \AppBundle\Entity\CePeriodoevaluacion
     */
    private $periodoevaluacionid;

    /**
     * @var \AppBundle\Entity\CePonderacionopcion
     */
    private $ponderacionopcionid;


    /**
     * Set calificacionantesredondeo
     *
     * @param string $calificacionantesredondeo
     *
     * @return CeCalificacionperiodoporalumno
     */
    public function setCalificacionantesredondeo($calificacionantesredondeo)
    {
        $this->calificacionantesredondeo = $calificacionantesredondeo;

        return $this;
    }

    /**
     * Get calificacionantesredondeo
     *
     * @return string
     */
    public function getCalificacionantesredondeo()
    {
        return $this->calificacionantesredondeo;
    }

    /**
     * Set calificacion
     *
     * @param string $calificacion
     *
     * @return CeCalificacionperiodoporalumno
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
     * Set observacion
     *
     * @param string $observacion
     *
     * @return CeCalificacionperiodoporalumno
     */
    public function setObservacion($observacion)
    {
        $this->observacion = $observacion;

        return $this;
    }

    /**
     * Get observacion
     *
     * @return string
     */
    public function getObservacion()
    {
        return $this->observacion;
    }

    /**
     * Set avance
     *
     * @param float $avance
     *
     * @return CeCalificacionperiodoporalumno
     */
    public function setAvance($avance)
    {
        $this->avance = $avance;

        return $this;
    }

    /**
     * Get avance
     *
     * @return float
     */
    public function getAvance()
    {
        return $this->avance;
    }

    /**
     * Get calificacionperiodoporalumnoid
     *
     * @return integer
     */
    public function getCalificacionperiodoporalumnoid()
    {
        return $this->calificacionperiodoporalumnoid;
    }

    /**
     * Set materiapadrecalificacionperiodoporalumnoid
     *
     * @param \AppBundle\Entity\CeCalificacionperiodoporalumno $materiapadrecalificacionperiodoporalumnoid
     *
     * @return CeCalificacionperiodoporalumno
     */
    public function setMateriapadrecalificacionperiodoporalumnoid(\AppBundle\Entity\CeCalificacionperiodoporalumno $materiapadrecalificacionperiodoporalumnoid = null)
    {
        $this->materiapadrecalificacionperiodoporalumnoid = $materiapadrecalificacionperiodoporalumnoid;

        return $this;
    }

    /**
     * Get materiapadrecalificacionperiodoporalumnoid
     *
     * @return \AppBundle\Entity\CeCalificacionperiodoporalumno
     */
    public function getMateriapadrecalificacionperiodoporalumnoid()
    {
        return $this->materiapadrecalificacionperiodoporalumnoid;
    }

    /**
     * Set calificacionfinalporperiodoalumno
     *
     * @param \AppBundle\Entity\CeCalificacionfinalperiodoporalumno $calificacionfinalporperiodoalumno
     *
     * @return CeCalificacionperiodoporalumno
     */
    public function setCalificacionfinalporperiodoalumno(\AppBundle\Entity\CeCalificacionfinalperiodoporalumno $calificacionfinalporperiodoalumno = null)
    {
        $this->calificacionfinalporperiodoalumno = $calificacionfinalporperiodoalumno;

        return $this;
    }

    /**
     * Get calificacionfinalporperiodoalumno
     *
     * @return \AppBundle\Entity\CeCalificacionfinalperiodoporalumno
     */
    public function getCalificacionfinalporperiodoalumno()
    {
        return $this->calificacionfinalporperiodoalumno;
    }

    /**
     * Set materiaporplanestudioid
     *
     * @param \AppBundle\Entity\CeMateriaporplanestudios $materiaporplanestudioid
     *
     * @return CeCalificacionperiodoporalumno
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

    /**
     * Set materiaid
     *
     * @param \AppBundle\Entity\Materia $materiaid
     *
     * @return CeCalificacionperiodoporalumno
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
     * Set alumnoporcicloid
     *
     * @param \AppBundle\Entity\CeAlumnoporciclo $alumnoporcicloid
     *
     * @return CeCalificacionperiodoporalumno
     */
    public function setAlumnoporcicloid(\AppBundle\Entity\CeAlumnoporciclo $alumnoporcicloid = null)
    {
        $this->alumnoporcicloid = $alumnoporcicloid;

        return $this;
    }

    /**
     * Get alumnoporcicloid
     *
     * @return \AppBundle\Entity\CeAlumnoporciclo
     */
    public function getAlumnoporcicloid()
    {
        return $this->alumnoporcicloid;
    }

    /**
     * Set profesorpormateriaplanestudioid
     *
     * @param \AppBundle\Entity\CeProfesorpormateriaplanestudios $profesorpormateriaplanestudioid
     *
     * @return CeCalificacionperiodoporalumno
     */
    public function setProfesorpormateriaplanestudioid(\AppBundle\Entity\CeProfesorpormateriaplanestudios $profesorpormateriaplanestudioid = null)
    {
        $this->profesorpormateriaplanestudioid = $profesorpormateriaplanestudioid;

        return $this;
    }

    /**
     * Get profesorpormateriaplanestudioid
     *
     * @return \AppBundle\Entity\CeProfesorpormateriaplanestudios
     */
    public function getProfesorpormateriaplanestudioid()
    {
        return $this->profesorpormateriaplanestudioid;
    }

    /**
     * Set alumnoid
     *
     * @param \AppBundle\Entity\CeAlumno $alumnoid
     *
     * @return CeCalificacionperiodoporalumno
     */
    public function setAlumnoid(\AppBundle\Entity\CeAlumno $alumnoid = null)
    {
        $this->alumnoid = $alumnoid;

        return $this;
    }

    /**
     * Get alumnoid
     *
     * @return \AppBundle\Entity\CeAlumno
     */
    public function getAlumnoid()
    {
        return $this->alumnoid;
    }

    /**
     * Set periodoevaluacionid
     *
     * @param \AppBundle\Entity\CePeriodoevaluacion $periodoevaluacionid
     *
     * @return CeCalificacionperiodoporalumno
     */
    public function setPeriodoevaluacionid(\AppBundle\Entity\CePeriodoevaluacion $periodoevaluacionid = null)
    {
        $this->periodoevaluacionid = $periodoevaluacionid;

        return $this;
    }

    /**
     * Get periodoevaluacionid
     *
     * @return \AppBundle\Entity\CePeriodoevaluacion
     */
    public function getPeriodoevaluacionid()
    {
        return $this->periodoevaluacionid;
    }

    /**
     * Set ponderacionopcionid
     *
     * @param \AppBundle\Entity\CePonderacionopcion $ponderacionopcionid
     *
     * @return CeCalificacionperiodoporalumno
     */
    public function setPonderacionopcionid(\AppBundle\Entity\CePonderacionopcion $ponderacionopcionid = null)
    {
        $this->ponderacionopcionid = $ponderacionopcionid;

        return $this;
    }

    /**
     * Get ponderacionopcionid
     *
     * @return \AppBundle\Entity\CePonderacionopcion
     */
    public function getPonderacionopcionid()
    {
        return $this->ponderacionopcionid;
    }
}

