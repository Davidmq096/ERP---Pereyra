<?php

namespace AppBundle\Entity;

/**
 * CeAsistenciaporpadreotutor
 */
class CeAsistenciaporpadreotutor
{
    /**
     * @var integer
     */
    private $asistenciaporpadreotutorid;

    /**
     * @var \AppBundle\Entity\CeAlumnoporciclo
     */
    private $alumnoporcicloid;

    /**
     * @var \AppBundle\Entity\CeEstatusinasistencia
     */
    private $estatusinasistenciaid;

    /**
     * @var \AppBundle\Entity\CeJuntapadretutor
     */
    private $juntapadreotutorid;

    /**
     * @var \AppBundle\Entity\CeTipoasistencia
     */
    private $tipoasistenciaid;


    /**
     * Get asistenciaporpadreotutorid
     *
     * @return integer
     */
    public function getAsistenciaporpadreotutorid()
    {
        return $this->asistenciaporpadreotutorid;
    }

    /**
     * Set alumnoporcicloid
     *
     * @param \AppBundle\Entity\CeAlumnoporciclo $alumnoporcicloid
     *
     * @return CeAsistenciaporpadreotutor
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
     * Set estatusinasistenciaid
     *
     * @param \AppBundle\Entity\CeEstatusinasistencia $estatusinasistenciaid
     *
     * @return CeAsistenciaporpadreotutor
     */
    public function setEstatusinasistenciaid(\AppBundle\Entity\CeEstatusinasistencia $estatusinasistenciaid = null)
    {
        $this->estatusinasistenciaid = $estatusinasistenciaid;

        return $this;
    }

    /**
     * Get estatusinasistenciaid
     *
     * @return \AppBundle\Entity\CeEstatusinasistencia
     */
    public function getEstatusinasistenciaid()
    {
        return $this->estatusinasistenciaid;
    }

    /**
     * Set juntapadreotutorid
     *
     * @param \AppBundle\Entity\CeJuntapadretutor $juntapadreotutorid
     *
     * @return CeAsistenciaporpadreotutor
     */
    public function setJuntapadreotutorid(\AppBundle\Entity\CeJuntapadretutor $juntapadreotutorid = null)
    {
        $this->juntapadreotutorid = $juntapadreotutorid;

        return $this;
    }

    /**
     * Get juntapadreotutorid
     *
     * @return \AppBundle\Entity\CeJuntapadretutor
     */
    public function getJuntapadreotutorid()
    {
        return $this->juntapadreotutorid;
    }

    /**
     * Set tipoasistenciaid
     *
     * @param \AppBundle\Entity\CeTipoasistencia $tipoasistenciaid
     *
     * @return CeAsistenciaporpadreotutor
     */
    public function setTipoasistenciaid(\AppBundle\Entity\CeTipoasistencia $tipoasistenciaid = null)
    {
        $this->tipoasistenciaid = $tipoasistenciaid;

        return $this;
    }

    /**
     * Get tipoasistenciaid
     *
     * @return \AppBundle\Entity\CeTipoasistencia
     */
    public function getTipoasistenciaid()
    {
        return $this->tipoasistenciaid;
    }
}

