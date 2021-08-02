<?php

namespace AppBundle\Entity;

/**
 * CeAlumnocicloporidiomanivel
 */
class CeAlumnocicloporidiomanivel
{
    /**
     * @var integer
     */
    private $alumnocicloporidiomanivelid;

    /**
     * @var \AppBundle\Entity\CeAlumnoporciclo
     */
    private $alumnoporcicloid;

    /**
     * @var \AppBundle\Entity\CeIdiomanivel
     */
    private $idiomanivelid;


    /**
     * Get alumnocicloporidiomanivelid
     *
     * @return integer
     */
    public function getAlumnocicloporidiomanivelid()
    {
        return $this->alumnocicloporidiomanivelid;
    }

    /**
     * Set alumnoporcicloid
     *
     * @param \AppBundle\Entity\CeAlumnoporciclo $alumnoporcicloid
     *
     * @return CeAlumnocicloporidiomanivel
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
     * Set idiomanivelid
     *
     * @param \AppBundle\Entity\CeIdiomanivel $idiomanivelid
     *
     * @return CeAlumnocicloporidiomanivel
     */
    public function setIdiomanivelid(\AppBundle\Entity\CeIdiomanivel $idiomanivelid = null)
    {
        $this->idiomanivelid = $idiomanivelid;

        return $this;
    }

    /**
     * Get idiomanivelid
     *
     * @return \AppBundle\Entity\CeIdiomanivel
     */
    public function getIdiomanivelid()
    {
        return $this->idiomanivelid;
    }
}

