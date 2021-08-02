<?php

namespace AppBundle\Entity;

/**
 * CeAlumnociclofoto
 */
class CeAlumnociclofoto
{
    /**
     * @var string
     */
    private $foto;

    /**
     * @var integer
     */
    private $alumnociclofotoid;

    /**
     * @var \AppBundle\Entity\CeAlumnoporciclo
     */
    private $alumnoporcicloid;


    /**
     * Set foto
     *
     * @param string $foto
     *
     * @return CeAlumnociclofoto
     */
    public function setFoto($foto)
    {
        $this->foto = $foto;

        return $this;
    }

    /**
     * Get foto
     *
     * @return string
     */
    public function getFoto()
    {
        return $this->foto;
    }

    /**
     * Get alumnociclofotoid
     *
     * @return integer
     */
    public function getAlumnociclofotoid()
    {
        return $this->alumnociclofotoid;
    }

    /**
     * Set alumnoporcicloid
     *
     * @param \AppBundle\Entity\CeAlumnoporciclo $alumnoporcicloid
     *
     * @return CeAlumnociclofoto
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
}

