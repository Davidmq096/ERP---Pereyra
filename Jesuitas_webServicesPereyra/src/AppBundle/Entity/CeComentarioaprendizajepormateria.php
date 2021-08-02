<?php

namespace AppBundle\Entity;

/**
 * CeComentarioaprendizajepormateria
 */
class CeComentarioaprendizajepormateria
{
    /**
     * @var string
     */
    private $comentario;

    /**
     * @var integer
     */
    private $comentarioaprendizajepormateriaid;

    /**
     * @var \AppBundle\Entity\CePonderacionopcion
     */
    private $ponderacionid;

    /**
     * @var \AppBundle\Entity\CeAprendizajepormateriaporsubmateria
     */
    private $aprendizajeesperadopormaterisubmateriaid;


    /**
     * Set comentario
     *
     * @param string $comentario
     *
     * @return CeComentarioaprendizajepormateria
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
     * Get comentarioaprendizajepormateriaid
     *
     * @return integer
     */
    public function getComentarioaprendizajepormateriaid()
    {
        return $this->comentarioaprendizajepormateriaid;
    }

    /**
     * Set ponderacionid
     *
     * @param \AppBundle\Entity\CePonderacionopcion $ponderacionid
     *
     * @return CeComentarioaprendizajepormateria
     */
    public function setPonderacionid(\AppBundle\Entity\CePonderacionopcion $ponderacionid = null)
    {
        $this->ponderacionid = $ponderacionid;

        return $this;
    }

    /**
     * Get ponderacionid
     *
     * @return \AppBundle\Entity\CePonderacionopcion
     */
    public function getPonderacionid()
    {
        return $this->ponderacionid;
    }

    /**
     * Set aprendizajeesperadopormaterisubmateriaid
     *
     * @param \AppBundle\Entity\CeAprendizajepormateriaporsubmateria $aprendizajeesperadopormaterisubmateriaid
     *
     * @return CeComentarioaprendizajepormateria
     */
    public function setAprendizajeesperadopormaterisubmateriaid(\AppBundle\Entity\CeAprendizajepormateriaporsubmateria $aprendizajeesperadopormaterisubmateriaid = null)
    {
        $this->aprendizajeesperadopormaterisubmateriaid = $aprendizajeesperadopormaterisubmateriaid;

        return $this;
    }

    /**
     * Get aprendizajeesperadopormaterisubmateriaid
     *
     * @return \AppBundle\Entity\CeAprendizajepormateriaporsubmateria
     */
    public function getAprendizajeesperadopormaterisubmateriaid()
    {
        return $this->aprendizajeesperadopormaterisubmateriaid;
    }
}

