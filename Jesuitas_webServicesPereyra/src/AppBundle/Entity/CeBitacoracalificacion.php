<?php

namespace AppBundle\Entity;

/**
 * CeBitacoracalificacion
 */
class CeBitacoracalificacion
{
    /**
     * @var string
     */
    private $ciclo;

    /**
     * @var string
     */
    private $nivel;

    /**
     * @var string
     */
    private $grado;

    /**
     * @var string
     */
    private $clase;

    /**
     * @var string
     */
    private $materia;

    /**
     * @var string
     */
    private $criterioevaluacion;

    /**
     * @var string
     */
    private $numerocaptura;

    /**
     * @var string
     */
    private $alumno;

    /**
     * @var string
     */
    private $capturaanterior;

    /**
     * @var string
     */
    private $capturanuevo;

    /**
     * @var string
     */
    private $calperiodoanterior;

    /**
     * @var string
     */
    private $calperiodonuevo;

    /**
     * @var string
     */
    private $opcperiodoanterior;

    /**
     * @var string
     */
    private $opcperiodonuevo;

    /**
     * @var string
     */
    private $comperiodoanterior;

    /**
     * @var string
     */
    private $comperiodonuevo;

    /**
     * @var string
     */
    private $calfinalanterior;

    /**
     * @var string
     */
    private $calfinalnuevo;

    /**
     * @var string
     */
    private $opcfinalanterior;

    /**
     * @var string
     */
    private $opcfinalnuevo;

    /**
     * @var \DateTime
     */
    private $fecha = 'CURRENT_TIMESTAMP';

    /**
     * @var string
     */
    private $folioedicionextemporanea;

    /**
     * @var integer
     */
    private $bitacoracalificacionid;

    /**
     * @var \AppBundle\Entity\CePeriodoevaluacion
     */
    private $periodoevaluacionid;

    /**
     * @var \AppBundle\Entity\CeProfesorpormateriaplanestudios
     */
    private $profesorpormateriaplanestudiosid;

    /**
     * @var \AppBundle\Entity\Usuario
     */
    private $usuarioid;


    /**
     * Set ciclo
     *
     * @param string $ciclo
     *
     * @return CeBitacoracalificacion
     */
    public function setCiclo($ciclo)
    {
        $this->ciclo = $ciclo;

        return $this;
    }

    /**
     * Get ciclo
     *
     * @return string
     */
    public function getCiclo()
    {
        return $this->ciclo;
    }

    /**
     * Set nivel
     *
     * @param string $nivel
     *
     * @return CeBitacoracalificacion
     */
    public function setNivel($nivel)
    {
        $this->nivel = $nivel;

        return $this;
    }

    /**
     * Get nivel
     *
     * @return string
     */
    public function getNivel()
    {
        return $this->nivel;
    }

    /**
     * Set grado
     *
     * @param string $grado
     *
     * @return CeBitacoracalificacion
     */
    public function setGrado($grado)
    {
        $this->grado = $grado;

        return $this;
    }

    /**
     * Get grado
     *
     * @return string
     */
    public function getGrado()
    {
        return $this->grado;
    }

    /**
     * Set clase
     *
     * @param string $clase
     *
     * @return CeBitacoracalificacion
     */
    public function setClase($clase)
    {
        $this->clase = $clase;

        return $this;
    }

    /**
     * Get clase
     *
     * @return string
     */
    public function getClase()
    {
        return $this->clase;
    }

    /**
     * Set materia
     *
     * @param string $materia
     *
     * @return CeBitacoracalificacion
     */
    public function setMateria($materia)
    {
        $this->materia = $materia;

        return $this;
    }

    /**
     * Get materia
     *
     * @return string
     */
    public function getMateria()
    {
        return $this->materia;
    }

    /**
     * Set criterioevaluacion
     *
     * @param string $criterioevaluacion
     *
     * @return CeBitacoracalificacion
     */
    public function setCriterioevaluacion($criterioevaluacion)
    {
        $this->criterioevaluacion = $criterioevaluacion;

        return $this;
    }

    /**
     * Get criterioevaluacion
     *
     * @return string
     */
    public function getCriterioevaluacion()
    {
        return $this->criterioevaluacion;
    }

    /**
     * Set numerocaptura
     *
     * @param string $numerocaptura
     *
     * @return CeBitacoracalificacion
     */
    public function setNumerocaptura($numerocaptura)
    {
        $this->numerocaptura = $numerocaptura;

        return $this;
    }

    /**
     * Get numerocaptura
     *
     * @return string
     */
    public function getNumerocaptura()
    {
        return $this->numerocaptura;
    }

    /**
     * Set alumno
     *
     * @param string $alumno
     *
     * @return CeBitacoracalificacion
     */
    public function setAlumno($alumno)
    {
        $this->alumno = $alumno;

        return $this;
    }

    /**
     * Get alumno
     *
     * @return string
     */
    public function getAlumno()
    {
        return $this->alumno;
    }

    /**
     * Set capturaanterior
     *
     * @param string $capturaanterior
     *
     * @return CeBitacoracalificacion
     */
    public function setCapturaanterior($capturaanterior)
    {
        $this->capturaanterior = $capturaanterior;

        return $this;
    }

    /**
     * Get capturaanterior
     *
     * @return string
     */
    public function getCapturaanterior()
    {
        return $this->capturaanterior;
    }

    /**
     * Set capturanuevo
     *
     * @param string $capturanuevo
     *
     * @return CeBitacoracalificacion
     */
    public function setCapturanuevo($capturanuevo)
    {
        $this->capturanuevo = $capturanuevo;

        return $this;
    }

    /**
     * Get capturanuevo
     *
     * @return string
     */
    public function getCapturanuevo()
    {
        return $this->capturanuevo;
    }

    /**
     * Set calperiodoanterior
     *
     * @param string $calperiodoanterior
     *
     * @return CeBitacoracalificacion
     */
    public function setCalperiodoanterior($calperiodoanterior)
    {
        $this->calperiodoanterior = $calperiodoanterior;

        return $this;
    }

    /**
     * Get calperiodoanterior
     *
     * @return string
     */
    public function getCalperiodoanterior()
    {
        return $this->calperiodoanterior;
    }

    /**
     * Set calperiodonuevo
     *
     * @param string $calperiodonuevo
     *
     * @return CeBitacoracalificacion
     */
    public function setCalperiodonuevo($calperiodonuevo)
    {
        $this->calperiodonuevo = $calperiodonuevo;

        return $this;
    }

    /**
     * Get calperiodonuevo
     *
     * @return string
     */
    public function getCalperiodonuevo()
    {
        return $this->calperiodonuevo;
    }

    /**
     * Set opcperiodoanterior
     *
     * @param string $opcperiodoanterior
     *
     * @return CeBitacoracalificacion
     */
    public function setOpcperiodoanterior($opcperiodoanterior)
    {
        $this->opcperiodoanterior = $opcperiodoanterior;

        return $this;
    }

    /**
     * Get opcperiodoanterior
     *
     * @return string
     */
    public function getOpcperiodoanterior()
    {
        return $this->opcperiodoanterior;
    }

    /**
     * Set opcperiodonuevo
     *
     * @param string $opcperiodonuevo
     *
     * @return CeBitacoracalificacion
     */
    public function setOpcperiodonuevo($opcperiodonuevo)
    {
        $this->opcperiodonuevo = $opcperiodonuevo;

        return $this;
    }

    /**
     * Get opcperiodonuevo
     *
     * @return string
     */
    public function getOpcperiodonuevo()
    {
        return $this->opcperiodonuevo;
    }

    /**
     * Set comperiodoanterior
     *
     * @param string $comperiodoanterior
     *
     * @return CeBitacoracalificacion
     */
    public function setComperiodoanterior($comperiodoanterior)
    {
        $this->comperiodoanterior = $comperiodoanterior;

        return $this;
    }

    /**
     * Get comperiodoanterior
     *
     * @return string
     */
    public function getComperiodoanterior()
    {
        return $this->comperiodoanterior;
    }

    /**
     * Set comperiodonuevo
     *
     * @param string $comperiodonuevo
     *
     * @return CeBitacoracalificacion
     */
    public function setComperiodonuevo($comperiodonuevo)
    {
        $this->comperiodonuevo = $comperiodonuevo;

        return $this;
    }

    /**
     * Get comperiodonuevo
     *
     * @return string
     */
    public function getComperiodonuevo()
    {
        return $this->comperiodonuevo;
    }

    /**
     * Set calfinalanterior
     *
     * @param string $calfinalanterior
     *
     * @return CeBitacoracalificacion
     */
    public function setCalfinalanterior($calfinalanterior)
    {
        $this->calfinalanterior = $calfinalanterior;

        return $this;
    }

    /**
     * Get calfinalanterior
     *
     * @return string
     */
    public function getCalfinalanterior()
    {
        return $this->calfinalanterior;
    }

    /**
     * Set calfinalnuevo
     *
     * @param string $calfinalnuevo
     *
     * @return CeBitacoracalificacion
     */
    public function setCalfinalnuevo($calfinalnuevo)
    {
        $this->calfinalnuevo = $calfinalnuevo;

        return $this;
    }

    /**
     * Get calfinalnuevo
     *
     * @return string
     */
    public function getCalfinalnuevo()
    {
        return $this->calfinalnuevo;
    }

    /**
     * Set opcfinalanterior
     *
     * @param string $opcfinalanterior
     *
     * @return CeBitacoracalificacion
     */
    public function setOpcfinalanterior($opcfinalanterior)
    {
        $this->opcfinalanterior = $opcfinalanterior;

        return $this;
    }

    /**
     * Get opcfinalanterior
     *
     * @return string
     */
    public function getOpcfinalanterior()
    {
        return $this->opcfinalanterior;
    }

    /**
     * Set opcfinalnuevo
     *
     * @param string $opcfinalnuevo
     *
     * @return CeBitacoracalificacion
     */
    public function setOpcfinalnuevo($opcfinalnuevo)
    {
        $this->opcfinalnuevo = $opcfinalnuevo;

        return $this;
    }

    /**
     * Get opcfinalnuevo
     *
     * @return string
     */
    public function getOpcfinalnuevo()
    {
        return $this->opcfinalnuevo;
    }

    /**
     * Set fecha
     *
     * @param \DateTime $fecha
     *
     * @return CeBitacoracalificacion
     */
    public function setFecha($fecha)
    {
        $this->fecha = $fecha;

        return $this;
    }

    /**
     * Get fecha
     *
     * @return \DateTime
     */
    public function getFecha()
    {
        return $this->fecha;
    }

    /**
     * Set folioedicionextemporanea
     *
     * @param string $folioedicionextemporanea
     *
     * @return CeBitacoracalificacion
     */
    public function setFolioedicionextemporanea($folioedicionextemporanea)
    {
        $this->folioedicionextemporanea = $folioedicionextemporanea;

        return $this;
    }

    /**
     * Get folioedicionextemporanea
     *
     * @return string
     */
    public function getFolioedicionextemporanea()
    {
        return $this->folioedicionextemporanea;
    }

    /**
     * Get bitacoracalificacionid
     *
     * @return integer
     */
    public function getBitacoracalificacionid()
    {
        return $this->bitacoracalificacionid;
    }

    /**
     * Set periodoevaluacionid
     *
     * @param \AppBundle\Entity\CePeriodoevaluacion $periodoevaluacionid
     *
     * @return CeBitacoracalificacion
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
     * Set profesorpormateriaplanestudiosid
     *
     * @param \AppBundle\Entity\CeProfesorpormateriaplanestudios $profesorpormateriaplanestudiosid
     *
     * @return CeBitacoracalificacion
     */
    public function setProfesorpormateriaplanestudiosid(\AppBundle\Entity\CeProfesorpormateriaplanestudios $profesorpormateriaplanestudiosid = null)
    {
        $this->profesorpormateriaplanestudiosid = $profesorpormateriaplanestudiosid;

        return $this;
    }

    /**
     * Get profesorpormateriaplanestudiosid
     *
     * @return \AppBundle\Entity\CeProfesorpormateriaplanestudios
     */
    public function getProfesorpormateriaplanestudiosid()
    {
        return $this->profesorpormateriaplanestudiosid;
    }

    /**
     * Set usuarioid
     *
     * @param \AppBundle\Entity\Usuario $usuarioid
     *
     * @return CeBitacoracalificacion
     */
    public function setUsuarioid(\AppBundle\Entity\Usuario $usuarioid = null)
    {
        $this->usuarioid = $usuarioid;

        return $this;
    }

    /**
     * Get usuarioid
     *
     * @return \AppBundle\Entity\Usuario
     */
    public function getUsuarioid()
    {
        return $this->usuarioid;
    }
}

