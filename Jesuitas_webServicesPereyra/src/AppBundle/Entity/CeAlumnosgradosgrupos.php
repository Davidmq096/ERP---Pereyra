<?php

namespace AppBundle\Entity;

/**
 * CeAlumnosgradosgrupos
 */
class CeAlumnosgradosgrupos
{
    /**
     * @var string
     */
    private $seccion;

    /**
     * @var string
     */
    private $grado;

    /**
     * @var string
     */
    private $grupo;

    /**
     * @var string
     */
    private $nomPadre;

    /**
     * @var string
     */
    private $nomMadre;

    /**
     * @var string
     */
    private $emailPadre;

    /**
     * @var string
     */
    private $emailMadre;

    /**
     * @var string
     */
    private $estatus;

    /**
     * @var integer
     */
    private $matricula;


    /**
     * Set seccion
     *
     * @param string $seccion
     *
     * @return CeAlumnosgradosgrupos
     */
    public function setSeccion($seccion)
    {
        $this->seccion = $seccion;

        return $this;
    }

    /**
     * Get seccion
     *
     * @return string
     */
    public function getSeccion()
    {
        return $this->seccion;
    }

    /**
     * Set grado
     *
     * @param string $grado
     *
     * @return CeAlumnosgradosgrupos
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
     * Set grupo
     *
     * @param string $grupo
     *
     * @return CeAlumnosgradosgrupos
     */
    public function setGrupo($grupo)
    {
        $this->grupo = $grupo;

        return $this;
    }

    /**
     * Get grupo
     *
     * @return string
     */
    public function getGrupo()
    {
        return $this->grupo;
    }

    /**
     * Set nomPadre
     *
     * @param string $nomPadre
     *
     * @return CeAlumnosgradosgrupos
     */
    public function setNomPadre($nomPadre)
    {
        $this->nomPadre = $nomPadre;

        return $this;
    }

    /**
     * Get nomPadre
     *
     * @return string
     */
    public function getNomPadre()
    {
        return $this->nomPadre;
    }

    /**
     * Set nomMadre
     *
     * @param string $nomMadre
     *
     * @return CeAlumnosgradosgrupos
     */
    public function setNomMadre($nomMadre)
    {
        $this->nomMadre = $nomMadre;

        return $this;
    }

    /**
     * Get nomMadre
     *
     * @return string
     */
    public function getNomMadre()
    {
        return $this->nomMadre;
    }

    /**
     * Set emailPadre
     *
     * @param string $emailPadre
     *
     * @return CeAlumnosgradosgrupos
     */
    public function setEmailPadre($emailPadre)
    {
        $this->emailPadre = $emailPadre;

        return $this;
    }

    /**
     * Get emailPadre
     *
     * @return string
     */
    public function getEmailPadre()
    {
        return $this->emailPadre;
    }

    /**
     * Set emailMadre
     *
     * @param string $emailMadre
     *
     * @return CeAlumnosgradosgrupos
     */
    public function setEmailMadre($emailMadre)
    {
        $this->emailMadre = $emailMadre;

        return $this;
    }

    /**
     * Get emailMadre
     *
     * @return string
     */
    public function getEmailMadre()
    {
        return $this->emailMadre;
    }

    /**
     * Set estatus
     *
     * @param string $estatus
     *
     * @return CeAlumnosgradosgrupos
     */
    public function setEstatus($estatus)
    {
        $this->estatus = $estatus;

        return $this;
    }

    /**
     * Get estatus
     *
     * @return string
     */
    public function getEstatus()
    {
        return $this->estatus;
    }

    /**
     * Get matricula
     *
     * @return integer
     */
    public function getMatricula()
    {
        return $this->matricula;
    }
}

