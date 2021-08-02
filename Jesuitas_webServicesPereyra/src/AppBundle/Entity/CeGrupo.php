<?php

namespace AppBundle\Entity;

/**
 * CeGrupo
 */
class CeGrupo
{
    /**
     * @var integer
     */
    private $nivelid;

    /**
     * @var string
     */
    private $nombre;

    /**
     * @var integer
     */
    private $cupo;

    /**
     * @var boolean
     */
    private $bloqueolista;

    /**
     * @var integer
     */
    private $grupoid;

    /**
     * @var \AppBundle\Entity\CeTipogrupo
     */
    private $tipogrupoid;

    /**
     * @var \AppBundle\Entity\CeAreaespecializacion
     */
    private $areaespecializacionid;

    /**
     * @var \AppBundle\Entity\Ciclo
     */
    private $cicloid;

    /**
     * @var \AppBundle\Entity\CeNivelparaescolares
     */
    private $nivelparaescolaresid;

    /**
     * @var \AppBundle\Entity\Grado
     */
    private $gradoid;


    /**
     * Set nivelid
     *
     * @param integer $nivelid
     *
     * @return CeGrupo
     */
    public function setNivelid($nivelid)
    {
        $this->nivelid = $nivelid;

        return $this;
    }

    /**
     * Get nivelid
     *
     * @return integer
     */
    public function getNivelid()
    {
        return $this->nivelid;
    }

    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return CeGrupo
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * Get nombre
     *
     * @return string
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Set cupo
     *
     * @param integer $cupo
     *
     * @return CeGrupo
     */
    public function setCupo($cupo)
    {
        $this->cupo = $cupo;

        return $this;
    }

    /**
     * Get cupo
     *
     * @return integer
     */
    public function getCupo()
    {
        return $this->cupo;
    }

    /**
     * Set bloqueolista
     *
     * @param boolean $bloqueolista
     *
     * @return CeGrupo
     */
    public function setBloqueolista($bloqueolista)
    {
        $this->bloqueolista = $bloqueolista;

        return $this;
    }

    /**
     * Get bloqueolista
     *
     * @return boolean
     */
    public function getBloqueolista()
    {
        return $this->bloqueolista;
    }

    /**
     * Get grupoid
     *
     * @return integer
     */
    public function getGrupoid()
    {
        return $this->grupoid;
    }

    /**
     * Set tipogrupoid
     *
     * @param \AppBundle\Entity\CeTipogrupo $tipogrupoid
     *
     * @return CeGrupo
     */
    public function setTipogrupoid(\AppBundle\Entity\CeTipogrupo $tipogrupoid = null)
    {
        $this->tipogrupoid = $tipogrupoid;

        return $this;
    }

    /**
     * Get tipogrupoid
     *
     * @return \AppBundle\Entity\CeTipogrupo
     */
    public function getTipogrupoid()
    {
        return $this->tipogrupoid;
    }

    /**
     * Set areaespecializacionid
     *
     * @param \AppBundle\Entity\CeAreaespecializacion $areaespecializacionid
     *
     * @return CeGrupo
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
     * @return CeGrupo
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
     * Set nivelparaescolaresid
     *
     * @param \AppBundle\Entity\CeNivelparaescolares $nivelparaescolaresid
     *
     * @return CeGrupo
     */
    public function setNivelparaescolaresid(\AppBundle\Entity\CeNivelparaescolares $nivelparaescolaresid = null)
    {
        $this->nivelparaescolaresid = $nivelparaescolaresid;

        return $this;
    }

    /**
     * Get nivelparaescolaresid
     *
     * @return \AppBundle\Entity\CeNivelparaescolares
     */
    public function getNivelparaescolaresid()
    {
        return $this->nivelparaescolaresid;
    }

    /**
     * Set gradoid
     *
     * @param \AppBundle\Entity\Grado $gradoid
     *
     * @return CeGrupo
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

