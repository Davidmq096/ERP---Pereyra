<?php

namespace AppBundle\Entity;

/**
 * LuCaptura
 */
class LuCaptura
{
    /**
     * @var \DateTime
     */
    private $fecha;

    /**
     * @var \DateTime
     */
    private $hora;

    /**
     * @var boolean
     */
    private $tienecontrato;

    /**
     * @var integer
     */
    private $diasvencidos;

    /**
     * @var float
     */
    private $adeudo;

    /**
     * @var string
     */
    private $personarecoge;

    /**
     * @var string
     */
    private $motivocancelacion;

    /**
     * @var integer
     */
    private $capturaid;

    /**
     * @var \AppBundle\Entity\Usuario
     */
    private $usuarioidcancelacion;

    /**
     * @var \AppBundle\Entity\CeAlumnoporciclo
     */
    private $alumnoporcicloid;

    /**
     * @var \AppBundle\Entity\CjDocumentoporpagar
     */
    private $documentoporpagarid;

    /**
     * @var \AppBundle\Entity\LuEstatuscaptura
     */
    private $estatuscapturaid;

    /**
     * @var \AppBundle\Entity\LuTipo
     */
    private $tipoid;

    /**
     * @var \AppBundle\Entity\Usuario
     */
    private $usuarioid;


    /**
     * Set fecha
     *
     * @param \DateTime $fecha
     *
     * @return LuCaptura
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
     * Set hora
     *
     * @param \DateTime $hora
     *
     * @return LuCaptura
     */
    public function setHora($hora)
    {
        $this->hora = $hora;

        return $this;
    }

    /**
     * Get hora
     *
     * @return \DateTime
     */
    public function getHora()
    {
        return $this->hora;
    }

    /**
     * Set tienecontrato
     *
     * @param boolean $tienecontrato
     *
     * @return LuCaptura
     */
    public function setTienecontrato($tienecontrato)
    {
        $this->tienecontrato = $tienecontrato;

        return $this;
    }

    /**
     * Get tienecontrato
     *
     * @return boolean
     */
    public function getTienecontrato()
    {
        return $this->tienecontrato;
    }

    /**
     * Set diasvencidos
     *
     * @param integer $diasvencidos
     *
     * @return LuCaptura
     */
    public function setDiasvencidos($diasvencidos)
    {
        $this->diasvencidos = $diasvencidos;

        return $this;
    }

    /**
     * Get diasvencidos
     *
     * @return integer
     */
    public function getDiasvencidos()
    {
        return $this->diasvencidos;
    }

    /**
     * Set adeudo
     *
     * @param float $adeudo
     *
     * @return LuCaptura
     */
    public function setAdeudo($adeudo)
    {
        $this->adeudo = $adeudo;

        return $this;
    }

    /**
     * Get adeudo
     *
     * @return float
     */
    public function getAdeudo()
    {
        return $this->adeudo;
    }

    /**
     * Set personarecoge
     *
     * @param string $personarecoge
     *
     * @return LuCaptura
     */
    public function setPersonarecoge($personarecoge)
    {
        $this->personarecoge = $personarecoge;

        return $this;
    }

    /**
     * Get personarecoge
     *
     * @return string
     */
    public function getPersonarecoge()
    {
        return $this->personarecoge;
    }

    /**
     * Set motivocancelacion
     *
     * @param string $motivocancelacion
     *
     * @return LuCaptura
     */
    public function setMotivocancelacion($motivocancelacion)
    {
        $this->motivocancelacion = $motivocancelacion;

        return $this;
    }

    /**
     * Get motivocancelacion
     *
     * @return string
     */
    public function getMotivocancelacion()
    {
        return $this->motivocancelacion;
    }

    /**
     * Get capturaid
     *
     * @return integer
     */
    public function getCapturaid()
    {
        return $this->capturaid;
    }

    /**
     * Set usuarioidcancelacion
     *
     * @param \AppBundle\Entity\Usuario $usuarioidcancelacion
     *
     * @return LuCaptura
     */
    public function setUsuarioidcancelacion(\AppBundle\Entity\Usuario $usuarioidcancelacion = null)
    {
        $this->usuarioidcancelacion = $usuarioidcancelacion;

        return $this;
    }

    /**
     * Get usuarioidcancelacion
     *
     * @return \AppBundle\Entity\Usuario
     */
    public function getUsuarioidcancelacion()
    {
        return $this->usuarioidcancelacion;
    }

    /**
     * Set alumnoporcicloid
     *
     * @param \AppBundle\Entity\CeAlumnoporciclo $alumnoporcicloid
     *
     * @return LuCaptura
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
     * Set documentoporpagarid
     *
     * @param \AppBundle\Entity\CjDocumentoporpagar $documentoporpagarid
     *
     * @return LuCaptura
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
     * Set estatuscapturaid
     *
     * @param \AppBundle\Entity\LuEstatuscaptura $estatuscapturaid
     *
     * @return LuCaptura
     */
    public function setEstatuscapturaid(\AppBundle\Entity\LuEstatuscaptura $estatuscapturaid = null)
    {
        $this->estatuscapturaid = $estatuscapturaid;

        return $this;
    }

    /**
     * Get estatuscapturaid
     *
     * @return \AppBundle\Entity\LuEstatuscaptura
     */
    public function getEstatuscapturaid()
    {
        return $this->estatuscapturaid;
    }

    /**
     * Set tipoid
     *
     * @param \AppBundle\Entity\LuTipo $tipoid
     *
     * @return LuCaptura
     */
    public function setTipoid(\AppBundle\Entity\LuTipo $tipoid = null)
    {
        $this->tipoid = $tipoid;

        return $this;
    }

    /**
     * Get tipoid
     *
     * @return \AppBundle\Entity\LuTipo
     */
    public function getTipoid()
    {
        return $this->tipoid;
    }

    /**
     * Set usuarioid
     *
     * @param \AppBundle\Entity\Usuario $usuarioid
     *
     * @return LuCaptura
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

