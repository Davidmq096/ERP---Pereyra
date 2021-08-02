<?php

namespace AppBundle\Entity;

/**
 * CeAlumnocicloporgrupo
 */
class CeAlumnocicloporgrupo
{
    /**
     * @var integer
     */
    private $numerolista;

    /**
     * @var integer
     */
    private $alumnocicloporgrupo;

    /**
     * @var \AppBundle\Entity\CeAlumnoporciclo
     */
    private $alumnoporcicloid;

    /**
     * @var \AppBundle\Entity\CeGrupo
     */
    private $grupoid;


    /**
     * Set numerolista
     *
     * @param integer $numerolista
     *
     * @return CeAlumnocicloporgrupo
     */
    public function setNumerolista($numerolista)
    {
        $this->numerolista = $numerolista;

        return $this;
    }

    /**
     * Get numerolista
     *
     * @return integer
     */
    public function getNumerolista()
    {
        return $this->numerolista;
    }

    /**
     * Get alumnocicloporgrupo
     *
     * @return integer
     */
    public function getAlumnocicloporgrupo()
    {
        return $this->alumnocicloporgrupo;
    }

    /**
     * Set alumnoporcicloid
     *
     * @param \AppBundle\Entity\CeAlumnoporciclo $alumnoporcicloid
     *
     * @return CeAlumnocicloporgrupo
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
     * Set grupoid
     *
     * @param \AppBundle\Entity\CeGrupo $grupoid
     *
     * @return CeAlumnocicloporgrupo
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
}

