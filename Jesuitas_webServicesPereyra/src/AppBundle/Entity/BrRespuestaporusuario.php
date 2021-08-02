<?php

namespace AppBundle\Entity;

/**
 * BrRespuestaporusuario
 */
class BrRespuestaporusuario
{
    /**
     * @var string
     */
    private $respuestatext;

    /**
     * @var integer
     */
    private $puntaje;

    /**
     * @var integer
     */
    private $respuestaporusuarioid;

    /**
     * @var \AppBundle\Entity\BrReactivo
     */
    private $reactivoid;

    /**
     * @var \AppBundle\Entity\BrRespuestaporreactivo
     */
    private $respuestaid;

    /**
     * @var \AppBundle\Entity\BrUsuarioporexamen
     */
    private $usuarioexamenid;


    /**
     * Set respuestatext
     *
     * @param string $respuestatext
     *
     * @return BrRespuestaporusuario
     */
    public function setRespuestatext($respuestatext)
    {
        $this->respuestatext = $respuestatext;

        return $this;
    }

    /**
     * Get respuestatext
     *
     * @return string
     */
    public function getRespuestatext()
    {
        return $this->respuestatext;
    }

    /**
     * Set puntaje
     *
     * @param integer $puntaje
     *
     * @return BrRespuestaporusuario
     */
    public function setPuntaje($puntaje)
    {
        $this->puntaje = $puntaje;

        return $this;
    }

    /**
     * Get puntaje
     *
     * @return integer
     */
    public function getPuntaje()
    {
        return $this->puntaje;
    }

    /**
     * Get respuestaporusuarioid
     *
     * @return integer
     */
    public function getRespuestaporusuarioid()
    {
        return $this->respuestaporusuarioid;
    }

    /**
     * Set reactivoid
     *
     * @param \AppBundle\Entity\BrReactivo $reactivoid
     *
     * @return BrRespuestaporusuario
     */
    public function setReactivoid(\AppBundle\Entity\BrReactivo $reactivoid = null)
    {
        $this->reactivoid = $reactivoid;

        return $this;
    }

    /**
     * Get reactivoid
     *
     * @return \AppBundle\Entity\BrReactivo
     */
    public function getReactivoid()
    {
        return $this->reactivoid;
    }

    /**
     * Set respuestaid
     *
     * @param \AppBundle\Entity\BrRespuestaporreactivo $respuestaid
     *
     * @return BrRespuestaporusuario
     */
    public function setRespuestaid(\AppBundle\Entity\BrRespuestaporreactivo $respuestaid = null)
    {
        $this->respuestaid = $respuestaid;

        return $this;
    }

    /**
     * Get respuestaid
     *
     * @return \AppBundle\Entity\BrRespuestaporreactivo
     */
    public function getRespuestaid()
    {
        return $this->respuestaid;
    }

    /**
     * Set usuarioexamenid
     *
     * @param \AppBundle\Entity\BrUsuarioporexamen $usuarioexamenid
     *
     * @return BrRespuestaporusuario
     */
    public function setUsuarioexamenid(\AppBundle\Entity\BrUsuarioporexamen $usuarioexamenid = null)
    {
        $this->usuarioexamenid = $usuarioexamenid;

        return $this;
    }

    /**
     * Get usuarioexamenid
     *
     * @return \AppBundle\Entity\BrUsuarioporexamen
     */
    public function getUsuarioexamenid()
    {
        return $this->usuarioexamenid;
    }
}

