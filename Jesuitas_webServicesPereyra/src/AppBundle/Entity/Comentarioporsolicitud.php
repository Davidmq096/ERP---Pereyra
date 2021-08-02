<?php

namespace AppBundle\Entity;

/**
 * Comentarioporsolicitud
 */
class Comentarioporsolicitud
{
    /**
     * @var string
     */
    private $comentario;

    /**
     * @var integer
     */
    private $comentarioporsolicitudid;

    /**
     * @var \AppBundle\Entity\Solicitudadmision
     */
    private $solicitudadmisionid;


    /**
     * Set comentario
     *
     * @param string $comentario
     *
     * @return Comentarioporsolicitud
     */
    public function setComentario($comentario)
    {
        $this->comentario = $comentario;

        return $this;
    }

    /**
     * Get comentario
     *
     * @return string
     */
    public function getComentario()
    {
        return $this->comentario;
    }

    /**
     * Get comentarioporsolicitudid
     *
     * @return integer
     */
    public function getComentarioporsolicitudid()
    {
        return $this->comentarioporsolicitudid;
    }

    /**
     * Set solicitudadmisionid
     *
     * @param \AppBundle\Entity\Solicitudadmision $solicitudadmisionid
     *
     * @return Comentarioporsolicitud
     */
    public function setSolicitudadmisionid(\AppBundle\Entity\Solicitudadmision $solicitudadmisionid = null)
    {
        $this->solicitudadmisionid = $solicitudadmisionid;

        return $this;
    }

    /**
     * Get solicitudadmisionid
     *
     * @return \AppBundle\Entity\Solicitudadmision
     */
    public function getSolicitudadmisionid()
    {
        return $this->solicitudadmisionid;
    }
}

