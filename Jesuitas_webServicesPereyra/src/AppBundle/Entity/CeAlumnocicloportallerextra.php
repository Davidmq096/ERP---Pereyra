<?php

namespace AppBundle\Entity;

/**
 * CeAlumnocicloportallerextra
 */
class CeAlumnocicloportallerextra
{
    /**
     * @var \DateTime
     */
    private $fechavencimiento;

    /**
     * @var boolean
     */
    private $reglamento;

    /**
     * @var boolean
     */
    private $materialentregado;

    /**
     * @var \DateTime
     */
    private $fechapreregistro = 'CURRENT_TIMESTAMP';

    /**
     * @var string
     */
    private $personaautorizo;

    /**
     * @var boolean
     */
    private $credencialentregada;

    /**
     * @var integer
     */
    private $alumnocicloportallerextraid;

    /**
     * @var \AppBundle\Entity\CeAlumnoporciclo
     */
    private $alumnoporcicloid;

    /**
     * @var \AppBundle\Entity\CeTallerextracurricular
     */
    private $tallerextraid;

    /**
     * @var \AppBundle\Entity\CeTallerextraestatusinscripcion
     */
    private $tallerextraestatusinscripcionid;

    /**
     * @var \AppBundle\Entity\CjDocumentoporpagar
     */
    private $documentoporpagarid;

    /**
     * @var \AppBundle\Entity\Usuario
     */
    private $usuarioid;


    /**
     * Set fechavencimiento
     *
     * @param \DateTime $fechavencimiento
     *
     * @return CeAlumnocicloportallerextra
     */
    public function setFechavencimiento($fechavencimiento)
    {
        $this->fechavencimiento = $fechavencimiento;

        return $this;
    }

    /**
     * Get fechavencimiento
     *
     * @return \DateTime
     */
    public function getFechavencimiento()
    {
        return $this->fechavencimiento;
    }

    /**
     * Set reglamento
     *
     * @param boolean $reglamento
     *
     * @return CeAlumnocicloportallerextra
     */
    public function setReglamento($reglamento)
    {
        $this->reglamento = $reglamento;

        return $this;
    }

    /**
     * Get reglamento
     *
     * @return boolean
     */
    public function getReglamento()
    {
        return $this->reglamento;
    }

    /**
     * Set materialentregado
     *
     * @param boolean $materialentregado
     *
     * @return CeAlumnocicloportallerextra
     */
    public function setMaterialentregado($materialentregado)
    {
        $this->materialentregado = $materialentregado;

        return $this;
    }

    /**
     * Get materialentregado
     *
     * @return boolean
     */
    public function getMaterialentregado()
    {
        return $this->materialentregado;
    }

    /**
     * Set fechapreregistro
     *
     * @param \DateTime $fechapreregistro
     *
     * @return CeAlumnocicloportallerextra
     */
    public function setFechapreregistro($fechapreregistro)
    {
        $this->fechapreregistro = $fechapreregistro;

        return $this;
    }

    /**
     * Get fechapreregistro
     *
     * @return \DateTime
     */
    public function getFechapreregistro()
    {
        return $this->fechapreregistro;
    }

    /**
     * Set personaautorizo
     *
     * @param string $personaautorizo
     *
     * @return CeAlumnocicloportallerextra
     */
    public function setPersonaautorizo($personaautorizo)
    {
        $this->personaautorizo = $personaautorizo;

        return $this;
    }

    /**
     * Get personaautorizo
     *
     * @return string
     */
    public function getPersonaautorizo()
    {
        return $this->personaautorizo;
    }

    /**
     * Set credencialentregada
     *
     * @param boolean $credencialentregada
     *
     * @return CeAlumnocicloportallerextra
     */
    public function setCredencialentregada($credencialentregada)
    {
        $this->credencialentregada = $credencialentregada;

        return $this;
    }

    /**
     * Get credencialentregada
     *
     * @return boolean
     */
    public function getCredencialentregada()
    {
        return $this->credencialentregada;
    }

    /**
     * Get alumnocicloportallerextraid
     *
     * @return integer
     */
    public function getAlumnocicloportallerextraid()
    {
        return $this->alumnocicloportallerextraid;
    }

    /**
     * Set alumnoporcicloid
     *
     * @param \AppBundle\Entity\CeAlumnoporciclo $alumnoporcicloid
     *
     * @return CeAlumnocicloportallerextra
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
     * Set tallerextraid
     *
     * @param \AppBundle\Entity\CeTallerextracurricular $tallerextraid
     *
     * @return CeAlumnocicloportallerextra
     */
    public function setTallerextraid(\AppBundle\Entity\CeTallerextracurricular $tallerextraid = null)
    {
        $this->tallerextraid = $tallerextraid;

        return $this;
    }

    /**
     * Get tallerextraid
     *
     * @return \AppBundle\Entity\CeTallerextracurricular
     */
    public function getTallerextraid()
    {
        return $this->tallerextraid;
    }

    /**
     * Set tallerextraestatusinscripcionid
     *
     * @param \AppBundle\Entity\CeTallerextraestatusinscripcion $tallerextraestatusinscripcionid
     *
     * @return CeAlumnocicloportallerextra
     */
    public function setTallerextraestatusinscripcionid(\AppBundle\Entity\CeTallerextraestatusinscripcion $tallerextraestatusinscripcionid = null)
    {
        $this->tallerextraestatusinscripcionid = $tallerextraestatusinscripcionid;

        return $this;
    }

    /**
     * Get tallerextraestatusinscripcionid
     *
     * @return \AppBundle\Entity\CeTallerextraestatusinscripcion
     */
    public function getTallerextraestatusinscripcionid()
    {
        return $this->tallerextraestatusinscripcionid;
    }

    /**
     * Set documentoporpagarid
     *
     * @param \AppBundle\Entity\CjDocumentoporpagar $documentoporpagarid
     *
     * @return CeAlumnocicloportallerextra
     */
    public function setDocumentoporpagarid(\AppBundle\Entity\CjDocumentoporpagar $documentoporpagarid = null)
    {
        $this->documentoporpagarid = $documentoporpagarid;

        return $this;
    }

    /**
     * Get documentoporpagarid
     *
     * @return \AppBundle\Entity\CjDocumentoporpagar
     */
    public function getDocumentoporpagarid()
    {
        return $this->documentoporpagarid;
    }

    /**
     * Set usuarioid
     *
     * @param \AppBundle\Entity\Usuario $usuarioid
     *
     * @return CeAlumnocicloportallerextra
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

