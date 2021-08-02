<?php

namespace AppBundle\Entity;

/**
 * CeAlumnoporciclo
 */
class CeAlumnoporciclo
{
    /**
     * @var \DateTime
     */
    private $fechabaja;

    /**
     * @var boolean
     */
    private $correoenviado;

    /**
     * @var string
     */
    private $observacionesbaja;

    /**
     * @var boolean
     */
    private $documentosreinscripcion = '1';

    /**
     * @var integer
     */
    private $alumnoporcicloid;

    /**
     * @var \AppBundle\Entity\CeAlumno
     */
    private $alumnoid;

    /**
     * @var \AppBundle\Entity\CeAreaespecializacion
     */
    private $areaespecializacionid;

    /**
     * @var \AppBundle\Entity\Ciclo
     */
    private $cicloid;

    /**
     * @var \AppBundle\Entity\CeEstatusalumnoporciclo
     */
    private $estatusalumnocicloid;

    /**
     * @var \AppBundle\Entity\CeMotivobaja
     */
    private $motivobajaid;

    /**
     * @var \AppBundle\Entity\CePlanestudios
     */
    private $planestudiosid;

    /**
     * @var \AppBundle\Entity\CeIntencionreinscribirse
     */
    private $intencionreinscribirseid;

    /**
     * @var \AppBundle\Entity\Grado
     */
    private $gradoid;


    /**
     * Set fechabaja
     *
     * @param \DateTime $fechabaja
     *
     * @return CeAlumnoporciclo
     */
    public function setFechabaja($fechabaja)
    {
        $this->fechabaja = $fechabaja;

        return $this;
    }

    /**
     * Get fechabaja
     *
     * @return \DateTime
     */
    public function getFechabaja()
    {
        return $this->fechabaja;
    }

    /**
     * Set correoenviado
     *
     * @param boolean $correoenviado
     *
     * @return CeAlumnoporciclo
     */
    public function setCorreoenviado($correoenviado)
    {
        $this->correoenviado = $correoenviado;

        return $this;
    }

    /**
     * Get correoenviado
     *
     * @return boolean
     */
    public function getCorreoenviado()
    {
        return $this->correoenviado;
    }

    /**
     * Set observacionesbaja
     *
     * @param string $observacionesbaja
     *
     * @return CeAlumnoporciclo
     */
    public function setObservacionesbaja($observacionesbaja)
    {
        $this->observacionesbaja = $observacionesbaja;

        return $this;
    }

    /**
     * Get observacionesbaja
     *
     * @return string
     */
    public function getObservacionesbaja()
    {
        return $this->observacionesbaja;
    }

    /**
     * Set documentosreinscripcion
     *
     * @param boolean $documentosreinscripcion
     *
     * @return CeAlumnoporciclo
     */
    public function setDocumentosreinscripcion($documentosreinscripcion)
    {
        $this->documentosreinscripcion = $documentosreinscripcion;

        return $this;
    }

    /**
     * Get documentosreinscripcion
     *
     * @return boolean
     */
    public function getDocumentosreinscripcion()
    {
        return $this->documentosreinscripcion;
    }

    /**
     * Get alumnoporcicloid
     *
     * @return integer
     */
    public function getAlumnoporcicloid()
    {
        return $this->alumnoporcicloid;
    }

    /**
     * Set alumnoid
     *
     * @param \AppBundle\Entity\CeAlumno $alumnoid
     *
     * @return CeAlumnoporciclo
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
     * Set areaespecializacionid
     *
     * @param \AppBundle\Entity\CeAreaespecializacion $areaespecializacionid
     *
     * @return CeAlumnoporciclo
     */
    public function setAreaespecializacionid(\AppBundle\Entity\CeAreaespecializacion $areaespecializacionid = null)
    {
        $this->areaespecializacionid = $areaespecializacionid;

        return $this;
    }

    /**
     * Get areaespecializacionid
     *
     * @return \AppBundle\Entity\CeAreaespecializacion
     */
    public function getAreaespecializacionid()
    {
        return $this->areaespecializacionid;
    }

    /**
     * Set cicloid
     *
     * @param \AppBundle\Entity\Ciclo $cicloid
     *
     * @return CeAlumnoporciclo
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
     * Set estatusalumnocicloid
     *
     * @param \AppBundle\Entity\CeEstatusalumnoporciclo $estatusalumnocicloid
     *
     * @return CeAlumnoporciclo
     */
    public function setEstatusalumnocicloid(\AppBundle\Entity\CeEstatusalumnoporciclo $estatusalumnocicloid = null)
    {
        $this->estatusalumnocicloid = $estatusalumnocicloid;

        return $this;
    }

    /**
     * Get estatusalumnocicloid
     *
     * @return \AppBundle\Entity\CeEstatusalumnoporciclo
     */
    public function getEstatusalumnocicloid()
    {
        return $this->estatusalumnocicloid;
    }

    /**
     * Set motivobajaid
     *
     * @param \AppBundle\Entity\CeMotivobaja $motivobajaid
     *
     * @return CeAlumnoporciclo
     */
    public function setMotivobajaid(\AppBundle\Entity\CeMotivobaja $motivobajaid = null)
    {
        $this->motivobajaid = $motivobajaid;

        return $this;
    }

    /**
     * Get motivobajaid
     *
     * @return \AppBundle\Entity\CeMotivobaja
     */
    public function getMotivobajaid()
    {
        return $this->motivobajaid;
    }

    /**
     * Set planestudiosid
     *
     * @param \AppBundle\Entity\CePlanestudios $planestudiosid
     *
     * @return CeAlumnoporciclo
     */
    public function setPlanestudiosid(\AppBundle\Entity\CePlanestudios $planestudiosid = null)
    {
        $this->planestudiosid = $planestudiosid;

        return $this;
    }

    /**
     * Get planestudiosid
     *
     * @return \AppBundle\Entity\CePlanestudios
     */
    public function getPlanestudiosid()
    {
        return $this->planestudiosid;
    }

    /**
     * Set intencionreinscribirseid
     *
     * @param \AppBundle\Entity\CeIntencionreinscribirse $intencionreinscribirseid
     *
     * @return CeAlumnoporciclo
     */
    public function setIntencionreinscribirseid(\AppBundle\Entity\CeIntencionreinscribirse $intencionreinscribirseid = null)
    {
        $this->intencionreinscribirseid = $intencionreinscribirseid;

        return $this;
    }

    /**
     * Get intencionreinscribirseid
     *
     * @return \AppBundle\Entity\CeIntencionreinscribirse
     */
    public function getIntencionreinscribirseid()
    {
        return $this->intencionreinscribirseid;
    }

    /**
     * Set gradoid
     *
     * @param \AppBundle\Entity\Grado $gradoid
     *
     * @return CeAlumnoporciclo
     */
    public function setGradoid(\AppBundle\Entity\Grado $gradoid = null)
    {
        $this->gradoid = $gradoid;

        return $this;
    }

    /**
     * Get gradoid
     *
     * @return \AppBundle\Entity\Grado
     */
    public function getGradoid()
    {
        return $this->gradoid;
    }
}

