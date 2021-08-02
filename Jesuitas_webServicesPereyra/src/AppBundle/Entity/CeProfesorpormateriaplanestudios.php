<?php

namespace AppBundle\Entity;

/**
 * CeProfesorpormateriaplanestudios
 */
class CeProfesorpormateriaplanestudios
{
    /**
     * @var boolean
     */
    private $activo;

    /**
     * @var integer
     */
    private $profesorpormateriaplanestudiosid;

    /**
     * @var \AppBundle\Entity\CeProfesor
     */
    private $suplenteid;

    /**
     * @var \AppBundle\Entity\CeEstatuscriterioevaluacion
     */
    private $estatuscriterioevaluacionid;

    /**
     * @var \AppBundle\Entity\CeMateriaporplanestudios
     */
    private $materiaporplanestudioid;

    /**
     * @var \AppBundle\Entity\CeProfesor
     */
    private $profesorid;

    /**
     * @var \AppBundle\Entity\CeTallercurricular
     */
    private $tallerid;

    /**
     * @var \AppBundle\Entity\CeGrupo
     */
    private $grupoid;

    /**
     * @var \AppBundle\Entity\CeProfesor
     */
    private $cotitularid;

    /**
     * @var \AppBundle\Entity\CePlantillaprofesor
     */
    private $plantillaprofesorid;

    /**
     * @var \AppBundle\Entity\Materia
     */
    private $materiaid;


    /**
     * Set activo
     *
     * @param boolean $activo
     *
     * @return CeProfesorpormateriaplanestudios
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
     * Get profesorpormateriaplanestudiosid
     *
     * @return integer
     */
    public function getProfesorpormateriaplanestudiosid()
    {
        return $this->profesorpormateriaplanestudiosid;
    }

    /**
     * Set suplenteid
     *
     * @param \AppBundle\Entity\CeProfesor $suplenteid
     *
     * @return CeProfesorpormateriaplanestudios
     */
    public function setSuplenteid(\AppBundle\Entity\CeProfesor $suplenteid = null)
    {
        $this->suplenteid = $suplenteid;

        return $this;
    }

    /**
     * Get suplenteid
     *
     * @return \AppBundle\Entity\CeProfesor
     */
    public function getSuplenteid()
    {
        return $this->suplenteid;
    }

    /**
     * Set estatuscriterioevaluacionid
     *
     * @param \AppBundle\Entity\CeEstatuscriterioevaluacion $estatuscriterioevaluacionid
     *
     * @return CeProfesorpormateriaplanestudios
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
     * Set materiaporplanestudioid
     *
     * @param \AppBundle\Entity\CeMateriaporplanestudios $materiaporplanestudioid
     *
     * @return CeProfesorpormateriaplanestudios
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
     * Set profesorid
     *
     * @param \AppBundle\Entity\CeProfesor $profesorid
     *
     * @return CeProfesorpormateriaplanestudios
     */
    public function setProfesorid(\AppBundle\Entity\CeProfesor $profesorid = null)
    {
        $this->profesorid = $profesorid;

        return $this;
    }

    /**
     * Get profesorid
     *
     * @return \AppBundle\Entity\CeProfesor
     */
    public function getProfesorid()
    {
        return $this->profesorid;
    }

    /**
     * Set tallerid
     *
     * @param \AppBundle\Entity\CeTallercurricular $tallerid
     *
     * @return CeProfesorpormateriaplanestudios
     */
    public function setTallerid(\AppBundle\Entity\CeTallercurricular $tallerid = null)
    {
        $this->tallerid = $tallerid;

        return $this;
    }

    /**
     * Get tallerid
     *
     * @return \AppBundle\Entity\CeTallercurricular
     */
    public function getTallerid()
    {
        return $this->tallerid;
    }

    /**
     * Set grupoid
     *
     * @param \AppBundle\Entity\CeGrupo $grupoid
     *
     * @return CeProfesorpormateriaplanestudios
     */
    public function setGrupoid(\AppBundle\Entity\CeGrupo $grupoid = null)
    {
        $this->grupoid = $grupoid;

        return $this;
    }

    /**
     * Get grupoid
     *
     * @return \AppBundle\Entity\CeGrupo
     */
    public function getGrupoid()
    {
        return $this->grupoid;
    }

    /**
     * Set cotitularid
     *
     * @param \AppBundle\Entity\CeProfesor $cotitularid
     *
     * @return CeProfesorpormateriaplanestudios
     */
    public function setCotitularid(\AppBundle\Entity\CeProfesor $cotitularid = null)
    {
        $this->cotitularid = $cotitularid;

        return $this;
    }

    /**
     * Get cotitularid
     *
     * @return \AppBundle\Entity\CeProfesor
     */
    public function getCotitularid()
    {
        return $this->cotitularid;
    }

    /**
     * Set plantillaprofesorid
     *
     * @param \AppBundle\Entity\CePlantillaprofesor $plantillaprofesorid
     *
     * @return CeProfesorpormateriaplanestudios
     */
    public function setPlantillaprofesorid(\AppBundle\Entity\CePlantillaprofesor $plantillaprofesorid = null)
    {
        $this->plantillaprofesorid = $plantillaprofesorid;

        return $this;
    }

    /**
     * Get plantillaprofesorid
     *
     * @return \AppBundle\Entity\CePlantillaprofesor
     */
    public function getPlantillaprofesorid()
    {
        return $this->plantillaprofesorid;
    }

    /**
     * Set materiaid
     *
     * @param \AppBundle\Entity\Materia $materiaid
     *
     * @return CeProfesorpormateriaplanestudios
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

